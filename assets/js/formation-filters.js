import FormationQueryManager from './formation-query-manager'
import MultiFilter from './multi-filter'
import { hideOnClickOutside } from '../utils/dom'

document.addEventListener('DOMContentLoaded', () => {
  const formationArchive = document.querySelector('#formation-archive')
  if (!formationArchive) return

  const queryManager = new FormationQueryManager('#formation-archive', '.f-formation-grid')

  // Initialize filters with correct taxonomy selectors
  const filters = document.querySelectorAll('.c-multi-terms-selector')
  filters.forEach($filter => {
    const taxonomy = $filter.dataset.taxonomy
    // Process all taxonomies including date_filter
    if (['ville', 'operateur', 'date_filter'].includes(taxonomy)) {
      const multiFilter = new MultiFilter($filter, queryManager)
      queryManager.addFilter(multiFilter)
    }
  })
  // Reset filters button
  const resetButton = document.querySelector('.reset-filters')
  if (resetButton) {
    resetButton.addEventListener('click', () => {
      queryManager.resetFilters()
      resetButton.setAttribute('disabled', '')
    })
  }

  // Handle filter bar expansion
  const filtersBar = document.querySelector('.c-filters-bar')
  const filtersOpen = document.querySelector('#filters-open')
  const filtersClose = document.querySelector('#filters-close')

  if (filtersBar && filtersOpen && filtersClose) {
    filtersOpen.addEventListener('click', () => filtersBar.classList.add('expand'))
    filtersClose.addEventListener('click', () => filtersBar.classList.remove('expand'))
    hideOnClickOutside(filtersBar, 'expand')
  }
})
