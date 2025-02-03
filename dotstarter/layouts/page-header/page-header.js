function pageHeaderScrollDown() {
  const scrollDownButton = document.querySelector('.f-page-header__scroll-down')

  if (!scrollDownButton) return
  scrollDownButton.addEventListener('click', function () {
    window.scrollBy({
      top: window.innerHeight,
      left: 0,
      behavior: 'smooth'
    })
  })
}

export { pageHeaderScrollDown }
