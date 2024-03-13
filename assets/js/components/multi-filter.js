import { hideOnClickOutside } from '../helpers'

const $ = jQuery

export default class MultiFilter {
  rootClass = '.c-multi-filter'

  // Elements
  $wrapper
  $toggle
  $options

  queryManager
  taxonomy
  selected = []

  constructor(element, queryManager) {
    this.queryManager = queryManager
    this.$wrapper = element
    this.taxonomy = element.dataset.taxonomy
    if (!this.taxonomy) {
      console.error('MultiFilter error : no data-taxonomy found on wrapper element')
      return
    }

    this.$toggle = this.$wrapper.querySelector(`${this.rootClass}__toggle`)
    this.$options = this.$wrapper.querySelectorAll(`${this.rootClass}__option`)

    if (!this.$toggle || !this.$options) {
      console.error('MultiSelect | Malformed markup : toggle or options could not be found.')
    }

    this.setListeners()
  }

  setListeners() {
    this.$toggle.addEventListener('click', this.toggleOptions.bind(this))
    this.$options.forEach($option => $option.addEventListener('click', this.toggleOption.bind(this)))
    hideOnClickOutside(this.$wrapper, false, 'expand')
  }

  toggleOptions() {
    this.$wrapper.classList.toggle('expand')
  }

  toggleOption(e) {
    e.currentTarget.dataset.selected = e.currentTarget.dataset.selected === 'true' ? 'false' : 'true'

    this.queryManager.applyTaxonomyFilter()
  }

  getTaxonomy() {
    return this.taxonomy
  }

  getSelected() {
    const $selectedOptions = this.$wrapper.querySelectorAll('[data-selected=true]')
    return [...$selectedOptions].map($option => $option.dataset.termId)
  }

  resetSelection() {
    this.$options.forEach($option => {
      $option.dataset.selected = 'false'
    })
  }
}
