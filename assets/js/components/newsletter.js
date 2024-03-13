import * as EmailValidator from 'email-validator'

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

function NewsletterForm () {
  const formEl = document.querySelector('#newsletter-form')

  const emailInputEl = document.querySelector('#newsletter-email')

  const termsCheckboxEl = document.querySelector('#newsletter-terms')
  const termsControlEl = formEl.querySelector('.c-newsletter-form__terms')
  const feedbackEl = document.querySelector('#newsletter-feedback')
  const expandableEl = formEl.querySelector('.c-newsletter-form__expandable')
  const expandableElHeight = expandableEl.scrollHeight + termsControlEl.scrollHeight

  const errors = []
  let email, firstname, lastname, region
  let isSubscribed = false

  if (!emailInputEl || !formEl) {
    return
  }

  // We don't use "once" param because both event listeners are removed manually
  emailInputEl.addEventListener('keydown', expandAndRemoveListeners)
  emailInputEl.addEventListener('onautocomplete', expandAndRemoveListeners)
  formEl.addEventListener('submit', handleSubmit)

  function validateForm () {
    email = emailInputEl.value
    lastname = formEl.querySelector('#newsletter-lastname').value
    firstname = formEl.querySelector('#newsletter-firstname').value
    region = formEl.querySelector('#newsletter-region').value

    const isEmailValid = EmailValidator.validate(email)

    if (!isEmailValid) {
      errors.push('Adresse e-mail invalide')
    }

    if (!lastname.length) {
      errors.push('Le nom de famille est obligatoire')
    }

    if (!firstname.length) {
      errors.push('Le prénom est obligatoire')
    }

    if (!region.length) {
      errors.push('Le pays est obligatoire')
    }

    if (!termsCheckboxEl.checked) {
      errors.push('Vous devez accepter les conditions.')
      termsCheckboxEl.addEventListener('click', () => resetFeedback(), { once: true })
    }
  }

  async function handleSubmit (e) {
    e.preventDefault()
    resetFeedback()

    if (isSubscribed) return

    validateForm()

    if (errors.length) {
      showFeedback(errors)
      return
    }

    const sentToMailjet = await sendToMailjet()

    if (!sentToMailjet) {
      showFeedback(errors)
      return
    }

    showFeedback()
    isSubscribed = true
  }

  async function sendToMailjet () {
    const params = {
      action: 'subscribe_contact_to_mailjet',
      data: JSON.stringify({
        email,
        firstname,
        lastname,
        region
      })
    }

    await fetch(ajaxConfig.ajaxUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Cache-Control': 'no-cache'
      },
      body: new URLSearchParams(params)
    })
      .then(res => res.json())
      .then(res => {
        const data = res.data?.response

        if (!data?.ErrorMessage) {
          errors.length = 0
          return
        }

        if (data?.ErrorMessage?.startsWith('MJ18')) {
          errors.push('Cette adresse e-mail est déjà inscrite')
        }
      }).catch(err => {
        console.log('Inscription impossible. Vérifiez vos informations ou réessayez plus tard.', err)
        errors.push('Inscription impossible. Vérifiez vos informations ou réessayez plus tard.')
      })
  }

  function expandAndRemoveListeners () {
    expandForm()
    emailInputEl.removeEventListener('keydown', expandAndRemoveListeners)
    emailInputEl.removeEventListener('onautocomplete', expandAndRemoveListeners)
  }

  function expandForm () {
    expandableEl.classList.add('is-expanded')
    expandableEl.style.maxHeight = expandableElHeight + 'px'
  }

  function resetFeedback () {
    errors.length = 0
    feedbackEl.innerHTML = ''
    feedbackEl.classList.remove('is-error', 'is-success')
  }

  function showFeedback (errors = null) {
    feedbackEl.classList.remove('is-error', 'is-success')

    if (errors.length) {
      const errorStr = errors.join('<br/>')
      // errorEl.innerHTML = error;
      feedbackEl.innerHTML = errorStr
      feedbackEl.classList.add('is-error')
      return
    }

    feedbackEl.innerHTML = 'Félicitations, vous avez correctement été inscrit(e) à la Newsletter'
    feedbackEl.classList.add('is-success')
  }
}

export default Newsletter

export { NewsletterForm }
