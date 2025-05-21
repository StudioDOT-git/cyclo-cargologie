import { bindAll } from '../helpers.js'
import MultiFilter from './multi-filter'

export default class BibliothequeMediaQueryManager {
  // Static properties
  endpoint = '/wp-json/ajax-bibliotheque-media-posts/v1/posts'
  $query
  multiFilters

  // Elements
  $wrapper
  $postsContainer
  $loader
  $resetFiltersButton
  $filtersOpenButton
  $filtersCloseButton
  $filtersContainer

  // Pagination elements
  $prevPageButton
  $nextPageButton
  $pagesButtonsContainer
  $pageButtons

  // Query vars
  postType = 'bibliotheque-media'
  postsPerPage
  paged = 1
  maxNumPages

  // State
  allPostsLoaded = false
  isLoading = false
  posts = []
  constructor (selector, templateSelector) {
    this.$wrapper = document.querySelector(selector)

    // Log initialization
    // console.log('[BibliothequeMediaQueryManager] Initializing on selector:', selector, 'Found:', !!this.$wrapper)

    if (!this.$wrapper) {
      return
    }

    // Initialize all properties first
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

    this.$loader = document.querySelector('#loader')
    this.$resetFiltersButton = this.$wrapper.querySelector('.reset-filters')
    this.$filtersOpenButton = this.$wrapper.querySelector('.c-formation-filters-bar__filters-toggle-wrapper button')
    this.$filtersCloseButton = this.$wrapper.querySelector('.c-formation-filters-bar__filters-close')
    this.$filtersContainer = this.$wrapper.querySelector('.c-formation-filters-bar__filters')

    // Then bind methods
    bindAll(this, ['resetFilters', 'applyTaxonomyFilter', 'toggleFilters'])

    // Finally add event listeners
    if (this.$resetFiltersButton) {
      this.$resetFiltersButton.addEventListener('click', this.resetFilters)
    }

    if (this.$filtersOpenButton && this.$filtersCloseButton && this.$filtersContainer) {
      this.$filtersOpenButton.addEventListener('click', this.toggleFilters)
      this.$filtersCloseButton.addEventListener('click', this.toggleFilters)
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

    // Standard parameters
    queryUrl.searchParams.append('per_page', this.postsPerPage)
    queryUrl.searchParams.append('post_type', this.postType)
    queryUrl.searchParams.append('page', this.paged)

    // Handle filters (only category for Bibliotheque Media)
    this.multiFilters.forEach(multiFilter => {
      const taxonomy = multiFilter.getTaxonomy()
      const selectedTerms = multiFilter.getSelected()

      if (selectedTerms.length > 0) {
        queryUrl.searchParams.append(taxonomy, selectedTerms.join(','))
        this.$resetFiltersButton?.removeAttribute('disabled')
      }
    })

    this.query = queryUrl

    // Log the built query URL
    // console.log('[BibliothequeMediaQueryManager] Built query URL:', queryUrl.toString())
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
        '                <div>Aucun média trouvé</div>\n' +
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

    if (this.query.searchParams.has('category')) {
      params.append('category', this.query.searchParams.get('category'))
    }
    if (this.paged > 1) {
      params.append('page', this.paged)
    }

    const queryString = params.toString()
    url = url.endsWith('/') ? url.slice(0, -1) : url
    url += queryString ? '/?' + queryString : ''
    url += '#bibliotheque-media-archive'

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
    const $filtersContainer = this.$wrapper.querySelector('.c-formation-filters-bar__filters')
    const $filtersOpenButton = this.$wrapper.querySelector('.c-formation-filters-bar__filters-open')
    const $filtersCloseButton = this.$wrapper.querySelector('.c-formation-filters-bar__filters-close')

    if ($filtersContainer && $filtersOpenButton && $filtersCloseButton) {
      $filtersContainer.classList.toggle('show')
      $filtersOpenButton.classList.toggle('hide')
      $filtersCloseButton.classList.toggle('show')
    }
  }
}
