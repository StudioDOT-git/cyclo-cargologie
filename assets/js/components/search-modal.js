const openBtn = document.querySelector('.main-menu__search-btn')
const closeBtn = document.querySelector('.l-search-modal__bg')
const modal = document.querySelector('.l-search-modal')

function searchModal() {
  openBtn.addEventListener('click', () => {
    modal.classList.add('visible')
  })
  closeBtn.addEventListener('click', () => {
    modal.classList.remove('visible')
  })
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('visible')) {
      modal.classList.remove('visible')
    }
  })
}

export default searchModal
