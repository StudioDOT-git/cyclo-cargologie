function Menu() {
  const openButton = document.querySelector('.main-menu__cta-open')
  const closeButton = document.querySelector('.main-menu__cta-close')

  if (!openButton || !closeButton) return

  openButton.addEventListener('click', open)
  closeButton.addEventListener('click', close)

  function open() {
    document.querySelector('.main-menu__nav').classList.add('is-open')
    document.documentElement.classList.toggle('noscroll')
  }
  function close() {
    document.querySelector('.main-menu__nav').classList.remove('is-open')
    document.documentElement.classList.remove('noscroll')
  }
}

export default Menu
