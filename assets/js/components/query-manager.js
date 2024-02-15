import MultiFilter from './multi-filter'
import PostCard from './post-card'

const $ = jQuery

export default class QueryManager {
  // Static
  endpoint = '/wp-json/wp/v2/'
  $query
  multiFilters

  templatesMap = {
    posts: PostCard
  }

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

  constructor(selector, templateSelector, postType) {
    this.$wrapper = document.querySelector(selector)

    if (!this.$wrapper) { return }

    this.$postsContainer = this.$wrapper.querySelector(templateSelector)

    if (!this.$postsContainer) {
      console.error('QueryManager - Element not found:', templateSelector)
    }

    this.postType = postType

    // Get elements
    if (!(this.postType in this.templatesMap)) {
      console.error('Query Manager - Unsupported post type: ', this.postType)
      return
    }

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
    this.$resetFiltersButton.addEventListener('click', () => this.resetFilters())
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
    let orderby = 'date'
    let order = 'desc'

    if (this.postType === 'membre' || this.postType === 'ressource') {
      orderby = 'title'
      order = 'asc'
    }

    const baseUrl = ajaxConfig.baseUrl + this.endpoint + this.postType
    console.log(ajaxConfig)

    const queryUrl = new URL(baseUrl)
    queryUrl.searchParams.append('per_page', this.postsPerPage)
    queryUrl.searchParams.append('page', this.paged)
    queryUrl.searchParams.append('orderby', orderby)
    queryUrl.searchParams.append('order', order)
    queryUrl.searchParams.append('acf_format', 'standard') // Set ACF format
    queryUrl.searchParams.append('_embed', true) // Set context to get terms - see https://developer.wordpress.org/rest-api/reference/posts/

    this.firstTaxonomy = this.multiFilters[0].getTaxonomy()
    this.firstTerm = this.multiFilters[0].getSelected().length ? this.multiFilters[0].getSelected()[0] : false

    this.multiFilters.forEach(multiFilter => {
      const taxonomy = multiFilter.getTaxonomy()
      const selectedTerms = multiFilter.getSelected()

      if (selectedTerms.length > 0) {
        const terms = selectedTerms.join(',')
        queryUrl.searchParams.append(taxonomy, terms)
      }
    })

    this.query = queryUrl
  }

  async fetchPosts() {
    let response = await fetch(this.query, {
      method: 'GET'
    })

    const maxNumPages = response.headers.get('x-wp-totalpages')
    if (maxNumPages) this.maxNumPages = maxNumPages

    response = await response.json()

    if (Array.isArray(response)) {
      this.posts = response
      return
    }

    // TODO : error handling

    this.posts = []
  }

  renderPosts() {
    const postCards = []

    if (this.posts.length === 0) {
      this.$postsContainer.innerHTML = '<div class="query-no-results">Aucun résultat pour cette recherche.</div>'
      return
    }

    this.posts.forEach(post => {
      postCards.push(new this.templatesMap[this.postType](post))
    })

    const postCardTemplates = postCards.map(postCard => postCard.getTemplate())

    this.$postsContainer.innerHTML = postCardTemplates.join('')
  }

  resetFilters() {
    this.paged = 1

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
    let url = window.location.href

    url = url.endsWith('/') ? url.slice(0, -1) : url

    if (this.firstTaxonomy && this.firstTerm) {
      url += `/${this.firstTaxonomy}/${this.firstTerm}`
    }

    // Reset "/page/{i}" part
    url = url.replace(/\/page\/\d.*/, '')

    // Set "/page/{i}" part
    if (this.paged > 1) {
      url += `/page/${this.paged}`
    }

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

    // window.scrollTo(0, 0);

    document.querySelector('.c-filters-bar').scrollIntoView()
  }
}
