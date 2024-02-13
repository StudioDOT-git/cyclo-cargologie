function Newsletter () {
  const btn = document.querySelector('.l-newsletter__column .wpforms-submit')
  const input = document.querySelector('.l-newsletter__column #wpforms-82-field_1')
  function checkInput () {
    if (input.value.trim() !== '') {
      btn.classList.add('is-show')
    } else {
      btn.classList.remove('is-show')
    }
  }
  input.addEventListener('input', checkInput)
  checkInput()
}

export default Newsletter
