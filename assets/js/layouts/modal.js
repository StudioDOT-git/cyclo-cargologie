// import gsap from 'gsap'

function modalAnims () {
  const layoutClass = '.c-button__modal'
  const modalClass = '.l-modal'
  const btnCloseClass = '.l-modal__btn-close'
  const bgCloseClass = '.l-modal__background'

  const modalButtons = document.querySelectorAll(layoutClass)
  const modal = document.querySelector(modalClass)
  const btnClose = document.querySelector(btnCloseClass)
  const bgClose = document.querySelector(bgCloseClass)

  modalButtons.forEach(function (modalButton) {
    modalButton.addEventListener('click', function () {
      modal.classList.add('visible')
      document.getElementsByTagName('body')[0].style.overflow = 'hidden'
      document.getElementsByTagName('html')[0].style.overflow = 'hidden'
    })
  })

  btnClose.addEventListener('click', function () {
    modal.classList.remove('visible')
    document.getElementsByTagName('body')[0].style.overflow = 'auto'
    document.getElementsByTagName('html')[0].style.overflow = 'auto'
  })
  bgClose.addEventListener('click', function () {
    modal.classList.remove('visible')
    document.getElementsByTagName('body')[0].style.overflow = 'auto'
    document.getElementsByTagName('html')[0].style.overflow = 'auto'
  })
}

function modalForm () {
  const btn = document.querySelector('.l-modal .wpforms-submit')
  const input = document.querySelector('.l-modal #wpforms-82-field_1')
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

export {
  modalAnims,
  modalForm
}

export default function () { }
