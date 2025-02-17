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

  constructor ($el, queryManager) {
    this.$el = $el
    this.queryManager = queryManager
    this.isSingleSelect = this.$el.dataset.singleSelect === 'true'
    this.$wrapper = $el
    this.taxonomy = $el.dataset.taxonomy
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

  setListeners () {
    this.$toggle.addEventListener('click', this.toggleOptions.bind(this))
    this.$options.forEach($option => $option.addEventListener('click', this.handleOptionClick.bind(this)))
    hideOnClickOutside(this.$wrapper, false, 'expand')
  }

  toggleOptions () {
    this.$wrapper.classList.toggle('expand')
  }

  handleOptionClick (e) {
    const $option = e.currentTarget

    if (this.isSingleSelect) {
      // Deselect all other options first
      this.$options.forEach($opt => {
        if ($opt !== $option) {
          $opt.dataset.selected = 'false'
        }
      })
      // Toggle current option
      $option.dataset.selected = $option.dataset.selected === 'true' ? 'false' : 'true'
    } else {
      // Your existing toggle logic for multi-select
      $option.dataset.selected = $option.dataset.selected === 'true' ? 'false' : 'true'
    }

    this.$wrapper.classList.remove('expand')
    this.queryManager.applyTaxonomyFilter()
  }

  getTaxonomy () {
    return this.taxonomy
  }

  getSelected () {
    const $selectedOptions = this.$wrapper.querySelectorAll('[data-selected=true]')
    return [...$selectedOptions].map($option => $option.dataset.termId)
  }

  resetSelection () {
    this.$options.forEach($option => {
      $option.dataset.selected = 'false'
    })
  }
}
