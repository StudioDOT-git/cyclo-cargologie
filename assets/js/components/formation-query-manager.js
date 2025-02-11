import { bindAll } from '../helpers.js'
import MultiFilter from './multi-filter'

export default class FormationQueryManager {
  // Static properties
  endpoint = '/wp-json/ajax-formation-posts/v1/posts'
  $query
  multiFilters

  // Elements
  $wrapper
  $postsContainer
  $loader
  $resetFiltersButton

  // Pagination elements
  $prevPageButton
  $nextPageButton
  $pagesButtonsContainer
  $pageButtons

  // Query vars
  postType = 'formation'
  postsPerPage
  paged = 1
  maxNumPages

  // State
  allPostsLoaded = false
  isLoading = false
  posts = []

  constructor (selector, templateSelector) {
    // Only bind methods that we've implemented
    bindAll(this, ['resetFilters', 'applyTaxonomyFilter', 'toggleFilters'])
    this.$wrapper = document.querySelector(selector)

    if (!this.$wrapper) {
      return
    }

    this.$postsContainer = this.$wrapper.querySelector(templateSelector)
    this.postsPerPage = this.$wrapper.dataset.postsPerPage

    // Initialize pagination elements
    this.$prevPageButton = this.$wrapper.querySelector('.c-pagination__prev')
    this.$nextPageButton = this.$wrapper.querySelector('.c-pagination__next')
    this.$pagesButtonsContainer = this.$wrapper.querySelector('.c-pagination__pages')

    const paginationContainer = this.$wrapper.querySelector('.c-pagination')
    if (paginationContainer) {
      this.paginationContainer = paginationContainer
      this.maxNumPages = paginationContainer.dataset.maxNumPages
      this.paged = parseInt(paginationContainer.dataset.paged)
    }

    // Initialize filters
    const $multiFilters = document.querySelectorAll('.c-multi-filter')
    this.multiFilters = [...$multiFilters].map(($multiFilter) => new MultiFilter($multiFilter, this))

    this.$loader = document.querySelector('#loader')
    this.$resetFiltersButton = this.$wrapper.querySelector('.reset-filters')

    // Add event listeners
    if (this.$resetFiltersButton) {
      this.$resetFiltersButton.addEventListener('click', this.resetFilters)
    }

    this.$prevPageButton?.addEventListener('click', () => this.previousPage())
    this.$nextPageButton?.addEventListener('click', () => this.nextPage())

    this.buildPagination()
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

    // Formation specific parameters
    queryUrl.searchParams.append('meta_key', 'date')
    queryUrl.searchParams.append('orderby', 'meta_value_num')
    queryUrl.searchParams.append('order', 'ASC')
    queryUrl.searchParams.append('meta_type', 'NUMERIC')

    // Standard parameters
    queryUrl.searchParams.append('per_page', this.postsPerPage)
    queryUrl.searchParams.append('post_type', this.postType)
    queryUrl.searchParams.append('page', this.paged)

    // Handle filters
    this.multiFilters.forEach(multiFilter => {
      const taxonomy = multiFilter.getTaxonomy()
      const selectedTerms = multiFilter.getSelected()

      console.log('Taxonomy:', taxonomy, 'Selected terms:', selectedTerms)

      if (selectedTerms.length > 0) {
        queryUrl.searchParams.append(taxonomy, selectedTerms.join(','))
        this.$resetFiltersButton?.removeAttribute('disabled')
      }
    })

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

      if (response.total_posts) {
        this.posts = response.rendered_posts
        return
      }

      this.posts = []
    } catch (error) {
      console.error('Error fetching posts:', error)
      this.posts = []
    }
  }

  renderPosts () {
    if (this.posts.length === 0) {
      this.$postsContainer.innerHTML = '<div class="c-filters__no-results">\n' +
        '                <div>Aucun article trouvé</div>\n' +
        '            </div>'
      return
    }

    this.$postsContainer.innerHTML = this.posts
  }

  resetFilters () {
    this.$resetFiltersButton.setAttribute('disabled', true)
    this.paged = 1

    this.multiFilters?.forEach(filter => {
      filter.resetSelection()
    })

    this.doQueryAndRender()
  }

  buildPagination () {
    if (this.maxNumPages === 0) {
      this.paginationContainer.classList.add('hide')
      return
    } else {
      this.paginationContainer.classList.remove('hide')
    }

    const paginationButtons = []

    this.$prevPageButton.classList.remove('hide')
    this.$nextPageButton.classList.remove('hide')

    if (this.paged - 1 >= 1) {
      paginationButtons.push(`<div class="c-pagination__page c-button--b c-button c-button--sm c-button--sand" data-page-number="${this.paged - 1}">${this.paged - 1}</div>`)
    } else {
      this.$prevPageButton.classList.add('hide')
    }

    paginationButtons.push(`<div class="c-pagination__page c-button--b c-button c-button--sm c-button--sand active" data-page-number="${this.paged}">${this.paged}</div>`)

    if (this.paged + 1 <= this.maxNumPages) {
      paginationButtons.push(`<div class="c-pagination__page c-button--b c-button c-button--sm c-button--sand" data-page-number="${this.paged + 1}">${this.paged + 1}</div>`)
    } else {
      this.$nextPageButton.classList.add('hide')
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

    const viewport = document.querySelector('.c-filters-bar')
    viewport?.scrollIntoView()
  }

  setCurrentUrl () {
    let url = location.origin + location.pathname

    const params = new URLSearchParams()

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

    const queryString = params.toString()
    url = url.endsWith('/') ? url.slice(0, -1) : url
    url += queryString ? '/?' + queryString : ''
    url += '#formation-archive'

    history.pushState({ page: this.paged }, null, url)
  }

  nextPage () {
    if (this.paged + 1 <= this.maxNumPages) {
      this.paged = this.paged + 1
      this.doQueryAndRender()
    }
  }

  previousPage () {
    if (this.paged - 1 >= 1) {
      this.paged = this.paged - 1
      this.doQueryAndRender()
    }
  }

  applyTaxonomyFilter () {
    this.paged = 1
    this.doQueryAndRender()
  }

  toggleFilters () {
    const $filtersContainer = this.$wrapper.querySelector('.c-filters-bar__filters')
    const $filtersOpenButton = this.$wrapper.querySelector('.c-filters-bar__filters-open')
    const $filtersCloseButton = this.$wrapper.querySelector('.c-filters-bar__filters-close')

    if ($filtersContainer && $filtersOpenButton && $filtersCloseButton) {
      $filtersContainer.classList.toggle('show')
      $filtersOpenButton.classList.toggle('hide')
      $filtersCloseButton.classList.toggle('show')
    }
  }
}
