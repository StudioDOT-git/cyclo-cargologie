export default class JobFilter {
  constructor (element, queryManager) {
    this.$wrapper = element
    this.queryManager = queryManager
    this.$jobButtons = this.$wrapper.querySelectorAll('.f-formation-calendar__job')
    this.selectedJobs = new Set()

    // Initialize from URL parameters
    const urlParams = new URLSearchParams(window.location.search)
    const metierParam = urlParams.get('metier')

    if (metierParam) {
      const selectedMetiers = metierParam.split(',')
      this.$jobButtons.forEach(button => {
        const jobValue = this.getJobValue(button)
        if (selectedMetiers.includes(jobValue)) {
          button.classList.add('is-active')
          this.selectedJobs.add(jobValue)
        } else {
          button.classList.remove('is-active')
        }
      })
    }

    this.init()
  }

  init () {
    this.$jobButtons.forEach(button => {
      button.addEventListener('click', () => this.toggleJob(button))
    })
  }

  toggleJob (button) {
    const jobValue = this.getJobValue(button)

    if (button.classList.contains('is-active')) {
      button.classList.remove('is-active')
      this.selectedJobs.delete(jobValue)
    } else {
      button.classList.add('is-active')
      this.selectedJobs.add(jobValue)
    }

    this.queryManager.applyJobFilter()
  }

  getJobValue (button) {
    const text = button.textContent.trim()
    if (text.includes('Livraison')) return 'livreur'
    if (text.includes('Dispatch')) return 'dispatch'
    if (text.includes('Management')) return 'manager'
    return ''
  }

  getSelected () {
    const selected = Array.from(this.selectedJobs)
    return selected
  }
}
