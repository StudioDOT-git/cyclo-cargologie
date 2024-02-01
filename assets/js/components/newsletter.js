function Newsletter () {
  const btn = document.querySelector('.wpforms-submit')
  const input = document.querySelector('#wpforms-82-field_1')
  function checkInput() {
    console.log('show ss')

    if (input.value.trim() !== '') {
      console.log('show')
      btn.classList.add('is-show')
    } else {
      btn.classList.remove('is-show')
    }
  }
  input.addEventListener('input', checkInput)
  checkInput()
}

export default Newsletter
