import { bindAll } from '../helpers.js'
import MultiFilter from './multi-filter'
import JobFilter from './job-filter'

export default class FormationQueryManager {
  endpoint = '/wp-json/ajax-formation-posts/v1/posts'
  $query
  multiFilters
  jobFilter = null

  $wrapper
  $postsContainer
  $loader
  $resetFiltersButton
  $filtersOpenButton
  $filtersCloseButton
  $filtersContainer

  $prevPageButton
  $nextPageButton
  $pagesButtonsContainer
  $pageButtons

  postType = 'formation'
  postsPerPage
  paged = 1
  maxNumPages

  allPostsLoaded = false
  isLoading = false
  posts = []

  constructor (selector, templateSelector) {
    this.$wrapper = document.querySelector(selector)
    if (!this.$wrapper) return

    this.$postsContainer = this.$wrapper.querySelector(templateSelector)
    this.postsPerPage = this.$wrapper.dataset.postsPerPage

    this.$prevPageButton = this.$wrapper.querySelector('.c-pagination__prev')
    this.$nextPageButton = this.$wrapper.querySelector('.c-pagination__next')
    this.$pagesButtonsContainer = this.$wrapper.querySelector('.c-pagination__pages')

    const paginationContainer = this.$wrapper.querySelector('.c-pagination')
    if (paginationContainer) {
      this.paginationContainer = paginationContainer
      this.maxNumPages = paginationContainer.dataset.maxNumPages
      this.paged = parseInt(paginationContainer.dataset.paged)
    }

    const $multiFilters = document.querySelectorAll('.c-multi-filter')
    this.multiFilters = [...$multiFilters].map(($multiFilter) => new MultiFilter($multiFilter, this))

    const jobFilterWrapper = document.querySelector('.f-formation-calendar__job-filter')
    if (jobFilterWrapper) {
      this.jobFilter = new JobFilter(jobFilterWrapper, this)
    }

    this.$loader = document.querySelector('#loader')
    this.$resetFiltersButton = this.$wrapper.querySelector('.reset-filters')
    this.$filtersOpenButton = this.$wrapper.querySelector('.c-formation-filters-bar__filters-toggle-wrapper button')
    this.$filtersCloseButton = this.$wrapper.querySelector('.c-formation-filters-bar__filters-close')
    this.$filtersContainer = this.$wrapper.querySelector('.c-formation-filters-bar__filters')

    if (this.$resetFiltersButton) {
      this.$resetFiltersButton.addEventListener('click', this.resetFilters.bind(this))
    }

    if (this.$filtersOpenButton && this.$filtersCloseButton && this.$filtersContainer) {
      this.$filtersOpenButton.addEventListener('click', this.toggleFilters.bind(this))
      this.$filtersCloseButton.addEventListener('click', this.toggleFilters.bind(this))
    }

    this.$prevPageButton?.addEventListener('click', () => this.previousPage())
    this.$nextPageButton?.addEventListener('click', () => this.nextPage())

    this.buildPagination()
  }

  applyJobFilter () {
    this.paged = 1
    this.doQueryAndRender()
  }

  async doQueryAndRender () {
    this.startLoading()
    this.buildQuery()
    this.setCurrentUrl()
    await this.fetchPosts()
    this.renderPosts()
    this.buildPagination()
    this.endLoading()
  }

  buildQuery () {
    const baseUrl = ajaxConfig.baseUrl + this.endpoint
    const queryUrl = new URL(baseUrl)

    queryUrl.searchParams.append('meta_key', 'date')
    queryUrl.searchParams.append('orderby', 'meta_value_num')
    queryUrl.searchParams.append('order', 'ASC')
    queryUrl.searchParams.append('meta_type', 'NUMERIC')
    queryUrl.searchParams.append('per_page', this.postsPerPage)
    queryUrl.searchParams.append('post_type', this.postType)
    queryUrl.searchParams.append('page', this.paged)

    this.multiFilters.forEach(multiFilter => {
      const taxonomy = multiFilter.getTaxonomy()
      const selectedTerms = multiFilter.getSelected()
      if (selectedTerms.length > 0) {
        queryUrl.searchParams.append(taxonomy, selectedTerms.join(','))
        this.$resetFiltersButton?.removeAttribute('disabled')
      }
    })

    if (this.jobFilter) {
      const selectedJobs = this.jobFilter.getSelected()
      console.log('Selected jobs for query:', selectedJobs)
      if (selectedJobs.length > 0) {
        queryUrl.searchParams.append('metier', selectedJobs.join(','))
      }
    }

    console.log('Final query URL:', queryUrl.toString())
    this.query = queryUrl
  }

  async fetchPosts () {
    try {
      let response = await fetch(this.query, {
        method: 'GET'
      })

      const maxNumPages = response.headers.get('x-ap-totalpages')
      this.maxNumPages = parseInt(maxNumPages)

      response = await response.json()
      this.posts = response.total_posts ? response.rendered_posts : []
    } catch (error) {
      console.error('Error fetching posts:', error)
      this.posts = []
    }
  }

  renderPosts () {
    this.$postsContainer.innerHTML = this.posts.length ? this.posts : '<div class="c-filters__no-results"><div>Aucun article trouvé</div></div>'
  }

  buildPagination () {
    if (!this.paginationContainer) return

    if (this.maxNumPages === 0) {
      this.paginationContainer.classList.add('hide')
      return
    }

    this.paginationContainer.classList.remove('hide')
    this.$prevPageButton.classList.toggle('hide', this.paged <= 1)
    this.$nextPageButton.classList.toggle('hide', this.paged >= this.maxNumPages)

    const paginationButtons = []
    if (this.paged > 1) {
      paginationButtons.push(`<div class="c-pagination__page c-button--b c-button c-button--sm c-button--sand" data-page-number="${this.paged - 1}">${this.paged - 1}</div>`)
    }

    paginationButtons.push(`<div class="c-pagination__page c-button--b c-button c-button--sm c-button--sand active" data-page-number="${this.paged}">${this.paged}</div>`)

    if (this.paged < this.maxNumPages) {
      paginationButtons.push(`<div class="c-pagination__page c-button--b c-button c-button--sm c-button--sand" data-page-number="${this.paged + 1}">${this.paged + 1}</div>`)
    }

    this.$pagesButtonsContainer.innerHTML = paginationButtons.join('')
    this.bindPaginationEvents()
  }

  bindPaginationEvents () {
    this.$pageButtons = this.$wrapper.querySelectorAll('.c-pagination__page')
    this.$pageButtons.forEach($button => {
      $button.addEventListener('click', (e) => {
        this.paged = parseInt(e.currentTarget.dataset.pageNumber)
        this.doQueryAndRender()
      })
    })
  }

  startLoading () {
    document.documentElement.classList.add('no-scroll')
    this.$loader?.classList.add('show')
    this.isLoading = true
  }

  endLoading () {
    document.documentElement.classList.remove('no-scroll')
    this.$loader?.classList.remove('show')
    this.isLoading = false
    this.$wrapper.querySelector('.c-filters-bar')?.scrollIntoView()
  }

  setCurrentUrl () {
    const params = new URLSearchParams()

    // Get all filter parameters
    if (this.jobFilter) {
      const selectedJobs = this.jobFilter.getSelected()
      if (selectedJobs.length > 0) {
        params.append('metier', selectedJobs.join(','))
      }
    }

    // Add other existing parameters
    if (this.query.searchParams.has('ville')) {
      params.append('ville', this.query.searchParams.get('ville'))
    }
    if (this.query.searchParams.has('operateur')) {
      params.append('operateur', this.query.searchParams.get('operateur'))
    }
    if (this.query.searchParams.has('date_filter')) {
      params.append('date_filter', this.query.searchParams.get('date_filter'))
    }
    if (this.paged > 1) {
      params.append('page', this.paged)
    }

    let url = location.origin + location.pathname
    url = url.endsWith('/') ? url.slice(0, -1) : url
    url += params.toString() ? '/?' + params.toString() : ''
    url += '#formation-archive'

    history.pushState({ page: this.paged }, null, url)
  }

  resetFilters () {
    this.$resetFiltersButton.setAttribute('disabled', true)
    this.paged = 1
    this.multiFilters?.forEach(filter => filter.resetSelection())
    this.doQueryAndRender()
  }

  applyTaxonomyFilter () {
    this.paged = 1
    this.doQueryAndRender()
  }

  toggleFilters () {
    this.$filtersContainer?.classList.toggle('show')
    this.$filtersOpenButton?.classList.toggle('hide')
    this.$filtersCloseButton?.classList.toggle('show')
  }

  previousPage () {
    if (this.paged > 1) {
      this.paged--
      this.doQueryAndRender()
    }
  }

  nextPage () {
    if (this.paged < this.maxNumPages) {
      this.paged++
      this.doQueryAndRender()
    }
  }
}
