import { hideOnClickOutside } from '../helpers'

export default class MultipleTermsSelector {
  // Config
  name = 'MultiTermsSelector'
  rootClass = '.c-multi-filter'
  applySelectionEvent

  // Data
  taxonomy
  selected = []

  // Elements
  wrapper
  toggle
  options
  applyButton

  constructor(element) {
    this.wrapper = element
    this.taxonomy = element.dataset.taxonomy

    if (!this.taxonomy) {
      console.error(`${this.name} | error: no data-taxonomy found on wrapper element`)
      return
    }

    this.toggle = this.wrapper.querySelector('.c-multi-filter__toggle')
    console.log(this.toggle)
    this.options = this.wrapper.querySelectorAll(`${this.rootClass}__option`)

    if (!this.toggle || !this.options) {
      console.error(`${this.name} | error: malformed markup - toggle or options could not be found.`)
    }

    this.archiveElem = document.querySelector('#events-archive')

    this.archiveElem.addEventListener('load-events', () => {
      this.isLoading = true
    })

    this.archiveElem.addEventListener('loaded-events', () => {
      this.isLoading = false
    })

    this.setListeners()
  }

  setListeners() {
    // Toggle selector
    this.toggle.addEventListener('click', this.toggleOptions.bind(this))

    // Selection events
    this.options.forEach(option => option.addEventListener('click', this.toggleOption.bind(this)))

    // Close on outside click
    hideOnClickOutside(this.wrapper, false, 'expand')
  }

  toggleOptions() {
    this.wrapper.classList.toggle('expand')
  }

  toggleOption(e) {
    if (this.isLoading) return
    e.currentTarget.dataset.selected = e.currentTarget.dataset.selected === 'true' ? 'false' : 'true'
  }

  getElement() {
    return this.wrapper
  }

  getTaxonomy() {
    return this.taxonomy
  }

  getSelected() {
    return this.selected
  }

  fetchSelected() {
    const selectedOptions = this.wrapper.querySelectorAll('[data-selected=true]')

    this.selected = [...selectedOptions].map((option) => {
      return {
        id: option.dataset.id,
        slug: option.dataset.slug,
        label: option.innerHTML
      }
    })

    return this.selected
  }

  /**
     *
     * @param {int} termId
     */
  toggleTerm(termId) {
    const element = this.wrapper.querySelector(`[data-id="${termId}"`)

    if (!element) {
      console.log('MultipleTermsSelector | Error - Could not find element for termId: ', termId)
      return
    }

    element.dataset.selected = false
    this.fetchSelected()
  }

  resetSelection() {
    this.options.forEach(option => {
      option.dataset.selected = 'false'
    })
    this.fetchSelected()
  }
}
