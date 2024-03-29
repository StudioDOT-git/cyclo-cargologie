import MultiFilter from './multi-filter'
import { bindAll } from '../helpers.js'

const $ = jQuery

export default class QueryManager {
  // Static
  endpoint = '/wp-json/ajax-posts/v1/posts'
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
  postType
  postsPerPage
  paged = 1
  maxNumPages

  // Url related
  firstTaxonomy
  firstTerm

  // State
  allPostsLoaded = false
  isLoading = false
  posts = []

  constructor(selector, templateSelector, postType, hasFilters = true) {
    bindAll(this, ['resetFilters', 'search', 'toggleFilters'])
    this.$wrapper = document.querySelector(selector)

    if (!this.$wrapper) {
      return
    }

    this.$postsContainer = this.$wrapper.querySelector(templateSelector)

    if (!this.$postsContainer) {
      console.error('QueryManager - Element not found:', templateSelector)
    }

    this.postType = postType
    this.hasFilters = hasFilters

    this.postsPerPage = this.$wrapper.dataset.postsPerPage
    if (!this.postsPerPage) {
      console.error('QueryManager - data-posts-per-page not found on ', selector)
      return
    }

    this.$loader = document.querySelector('#loader')
    this.$resetFiltersButton = this.$wrapper.querySelector('.reset-filters')

    // Prepare pagination
    this.$prevPageButton = this.$wrapper.querySelector('.c-pagination__prev')
    this.$nextPageButton = this.$wrapper.querySelector('.c-pagination__next')
    this.$pagesButtonsContainer = this.$wrapper.querySelector('.c-pagination__pages')

    const paginationContainer = this.$wrapper.querySelector('.c-pagination')
    this.paginationContainer = paginationContainer
    this.maxNumPages = paginationContainer.dataset.maxNumPages
    this.paged = parseInt(paginationContainer.dataset.paged)

    if (!this.$prevPageButton || !this.$nextPageButton || !this.$pagesButtonsContainer || !this.maxNumPages || !this.paged) {
      console.error('QueryManager - Malformed pagination markup')
      return
    }

    this.$prevPageButton.addEventListener('click', () => this.previousPage())
    this.$nextPageButton.addEventListener('click', () => this.nextPage())

    this.buildPagination()

    // Prepare filters
    const $multiFilters = document.querySelectorAll('.c-multi-filter')
    this.multiFilters = [...$multiFilters].map(($multiFilter) => new MultiFilter($multiFilter, this))

    // Prepare reset button
    if (this.$resetFiltersButton) {
      this.$resetFiltersButton.addEventListener('click', (e) => this.resetFilters(e))
    }

    // Prepare search form
    this.searchForm = this.postType === 'all' ? document.querySelector('.l-search-modal__form') : this.$wrapper.querySelector('.c-filters-bar-search-form')
    this.states = {}
    if (this.searchForm) {
      this.searchForm.addEventListener('submit', this.search)
      this.inputElem = this.searchForm.querySelector('input[type="search"]')
      this.states.isSearch = false
    }

    // Prepare toggle filters button
    this.$filtersOpenButton = this.$wrapper.querySelector('.c-filters-bar__filters-open')
    this.$filtersCloseButton = this.$wrapper.querySelector('.c-filters-bar__filters-close')
    this.$filtersContainer = this.$wrapper.querySelector('.c-filters-bar__filters')
    if (this.$filtersOpenButton && this.$filtersCloseButton && this.$filtersContainer) {
      this.$filtersOpenButton.addEventListener('click', this.toggleFilters)
      this.$filtersCloseButton.addEventListener('click', this.toggleFilters)
    }
  }

  async doQueryAndRender() {
    this.startLoading()

    this.buildQuery()
    this.setCurrentUrl()

    await this.fetchPosts()
    this.renderPosts()
    this.buildPagination()

    this.endLoading()
  }

  buildQuery() {
    if (this.$filtersContainer) {
      this.$filtersContainer.classList.remove('show')
      this.$filtersOpenButton.classList.remove('hide')
      this.$filtersCloseButton.classList.remove('show')
    }
    let orderby = 'date'
    let order = 'desc'

    if (this.postType === 'membre' || this.postType === 'ressource') {
      orderby = 'title'
      order = 'asc'
    }

    const baseUrl = ajaxConfig.baseUrl + this.endpoint

    const queryUrl = new URL(baseUrl)
    queryUrl.searchParams.append('per_page', this.postsPerPage)
    queryUrl.searchParams.append('post_type', this.postType)
    queryUrl.searchParams.append('page', this.paged)
    queryUrl.searchParams.append('orderby', orderby)
    queryUrl.searchParams.append('order', order)
    if (this.$wrapper.id === 'past-events') {
      queryUrl.searchParams.append('from_past', true)
    }

    if (this.searchForm) {
      const s = this.inputElem.value

      if (s.length > 0) {
        queryUrl.searchParams.append('s', s)
      }
    }

    if (this.hasFilters) {
      this.firstTaxonomy = this.multiFilters[0].getTaxonomy()
      this.firstTerm = this.multiFilters[0].getSelected().length ? this.multiFilters[0].getSelected()[0] : false

      this.$resetFiltersButton.setAttribute('disabled', true)

      this.multiFilters.forEach(multiFilter => {
        const taxonomy = multiFilter.getTaxonomy()
        const selectedTerms = multiFilter.getSelected()

        if (selectedTerms.length > 0) {
          const terms = selectedTerms.join(',')
          queryUrl.searchParams.append(taxonomy, terms)

          if (terms) {
            this.$resetFiltersButton.removeAttribute('disabled')
          }
        }
      })
    }

    this.newPathName = new URL(queryUrl.toString())
    this.newPathName.searchParams.delete('per_page')
    this.newPathName.searchParams.delete('post_type')
    this.newPathName.searchParams.delete('orderby')
    this.newPathName.searchParams.delete('order')

    this.query = queryUrl
  }

  async fetchPosts() {
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

    // TODO : error handling

    this.posts = []
  }

  renderPosts() {
    if (this.posts.length === 0) {
      this.$postsContainer.innerHTML = ' <div class="c-filters__no-results">\n' +
        '                <div>Aucun article trouvé</div>\n' +
        '            </div>'
      return
    }

    this.$postsContainer.innerHTML = this.posts
  }

  resetFilters(e) {
    this.$resetFiltersButton.setAttribute('disabled', true)
    this.paged = 1
    if (e) {
      this.states.isSearch = false
    }

    if (!this.states.isSearch) {
      this.inputElem.value = ''
    }

    this.multiFilters?.forEach(filter => {
      filter.resetSelection()
    })

    this.doQueryAndRender()
  }

  applyTaxonomyFilter() {
    this.paged = 1
    this.doQueryAndRender()
  }

  // todo: make pagination an independent component
  buildPagination() {
    if (this.maxNumPages === 0) {
      this.paginationContainer.classList.add('hide')
      return
    } else {
      this.paginationContainer.classList.remove('hide')
    }

    const paginationButtons = []

    // Reset Prev/Next buttons
    this.$prevPageButton.classList.remove('hide')
    this.$nextPageButton.classList.remove('hide')

    if (this.paged - 1 >= 1) {
      paginationButtons.push(`<div class="c-pagination__page c-button c-button--sm c-button--sand" data-page-number="${this.paged - 1}">${this.paged - 1}</div>`)
    } else {
      if (!this.$prevPageButton.classList.contains('hide')) {
        this.$prevPageButton.classList.add('hide')
      }
    }

    paginationButtons.push(`<div class="c-pagination__page c-button c-button--sm c-button--sand active" data-page-number="${this.paged}">${this.paged}</div>`)

    if (this.paged + 1 <= this.maxNumPages) {
      paginationButtons.push(`<div class="c-pagination__page c-button c-button--sm c-button--sand" data-page-number="${this.paged + 1}">${this.paged + 1}</div>`)
    } else {
      if (!this.$nextPageButton.classList.contains('hide')) {
        this.$nextPageButton.classList.add('hide')
      }
    }
    if (this.paged + 2 <= this.maxNumPages) {
      paginationButtons.push('<div class="c-pagination__page c-button c-button--sm c-button--sand">...</div>')
    }

    // Add elements to document
    this.$pagesButtonsContainer.innerHTML = paginationButtons.join('')

    // Retrieve elements from document (yes, it could be cleaner)
    this.$pageButtons = this.$wrapper.querySelectorAll('.c-pagination__page')

    this.$pageButtons.forEach($button => {
      $button.addEventListener('click', (e) => {
        const target = e.currentTarget

        this.paged = parseInt(target.dataset.pageNumber)
        this.goToPage(this.paged)
      })
    })
  }

  setCurrentUrl() {
    let url = location.origin + location.pathname

    url = url.endsWith('/') ? url.slice(0, -1) : url
    url += '/?' + this.newPathName.searchParams

    // Reset "/page/{i}" part
    url = url.replace(/\/page\/\d.*/, '')

    history.pushState({ page: this.paged }, null, url)
  }

  goToPage(page) {
    this.paged = page

    this.doQueryAndRender()
  }

  nextPage() {
    if (this.paged + 1 <= this.maxNumPages) {
      this.paged = this.paged + 1
      this.goToPage(this.paged)
    }
  }

  previousPage() {
    if (this.paged - 1 >= 1) {
      this.paged = this.paged - 1
      this.goToPage(this.paged)
    }
  }

  search(e) {
    if (this.postType === 'all') {
      return
    }
    e.preventDefault()
    this.states.isSearch = true

    this.resetFilters()

    this.doQueryAndRender()
  }

  startLoading() {
    document.documentElement.classList.add('no-scroll')

    if (this.$loader) {
      this.$loader.classList.add('show')
    }

    this.isLoading = true
  }

  endLoading() {
    document.documentElement.classList.remove('no-scroll')

    if (this.$loader) {
      this.$loader.classList.remove('show')
    }

    this.isLoading = false

    let viewport = this.postType === 'all' ? document.querySelector('.t-search__header') : document.querySelector('.c-filters-bar')

    if (this.$wrapper.id === 'past-events') {
      viewport = document.querySelector('.f-past-events__header')
    }
    viewport.scrollIntoView()
  }

  toggleFilters() {
    this.$filtersContainer.classList.toggle('show')
    this.$filtersOpenButton.classList.toggle('hide')
    this.$filtersCloseButton.classList.toggle('show')
  }
}
