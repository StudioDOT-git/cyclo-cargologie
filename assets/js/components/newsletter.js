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

// Make NewsletterForm accept a config object for selectors
function NewsletterForm ({
  formSelector = '#newsletter-form',
  emailSelector = '#newsletter-email',
  lastnameSelector = '#newsletter-lastname',
  firstnameSelector = '#newsletter-firstname',
  companySelector = '#newsletter-company',
  roleSelector = '#newsletter-role',
  citySelector = '#newsletter-city',
  termsSelector = '#newsletter-terms',
  feedbackSelector = '#newsletter-feedback',
  expandableSelector = '.c-newsletter-form__expandable',
  termsControlSelector = '.c-newsletter-form__terms'
} = {}) {
  const formEl = document.querySelector(formSelector)
  const emailInputEl = document.querySelector(emailSelector)
  const termsCheckboxEl = document.querySelector(termsSelector)
  const termsControlEl = formEl?.querySelector(termsControlSelector)
  const feedbackEl = document.querySelector(feedbackSelector)
  const expandableEl = formEl?.querySelector(expandableSelector)
  const expandableElHeight = expandableEl && termsControlEl
    ? expandableEl.scrollHeight + termsControlEl.scrollHeight
    : 0

  const errors = []
  let email, firstname, lastname, company, role, city
  let isSubscribed = false

  if (!emailInputEl || !formEl) {
    return
  }

  emailInputEl.addEventListener('keydown', expandAndRemoveListeners)
  emailInputEl.addEventListener('onautocomplete', expandAndRemoveListeners)
  formEl.addEventListener('submit', handleSubmit)

  function validateForm () {
    email = emailInputEl.value
    lastname = formEl.querySelector(lastnameSelector).value
    firstname = formEl.querySelector(firstnameSelector).value
    company = formEl.querySelector(companySelector).value
    role = formEl.querySelector(roleSelector).value
    city = formEl.querySelector(citySelector).value

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
    if (!company.length) {
      errors.push('L\'entreprise est obligatoire')
    }
    if (!city.length) {
      errors.push('La ville est obligatoire')
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

  async function sendToMailjet (data = null) {
    const params = data ?? {
      action: 'subscribe_contact_to_mailjet',
      data: JSON.stringify({
        email,
        firstname,
        lastname,
        company,
        role,
        city
      })
    }

    try {
      const response = await fetch(ajaxConfig.ajaxUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Cache-Control': 'no-cache'
        },
        body: new URLSearchParams(params)
      })

      const result = await response.json()

      if (result.success) {
        errors.length = 0
        return true
      }

      const responseData = result.data?.response ?? result.data
      const errorMessage = Array.isArray(responseData)
        ? responseData[0]?.ErrorMessage
        : responseData?.ErrorMessage

      if (errorMessage?.startsWith('MJ18')) {
        errors.push('Cette adresse e-mail est déjà inscrite')
      } else if (typeof errorMessage === 'string' && errorMessage.length) {
        errors.push('Inscription impossible : ' + errorMessage)
      } else if (typeof result.data?.error === 'string' && result.data.error.length) {
        errors.push(result.data.error)
      } else {
        errors.push('Inscription impossible. Vérifiez vos informations ou réessayez plus tard.')
      }

      return false
    } catch (err) {
      errors.push('Inscription impossible. Vérifiez vos informations ou réessayez plus tard.')
      return false
    }
  }

  function expandAndRemoveListeners () {
    expandForm()
    emailInputEl.removeEventListener('keydown', expandAndRemoveListeners)
    emailInputEl.removeEventListener('onautocomplete', expandAndRemoveListeners)
  }

  function expandForm () {
    if (expandableEl) {
      // console.log('expandableEl for', formSelector, expandableEl)
      expandableEl.classList.add('is-expanded')
      expandableEl.style.maxHeight = expandableElHeight + 'px'
    }
  }

  function resetFeedback () {
    errors.length = 0
    if (feedbackEl) {
      feedbackEl.innerHTML = ''
      feedbackEl.classList.remove('is-error', 'is-success')
    }
  }

  function showFeedback (errors = null) {
    if (!feedbackEl) return
    feedbackEl.classList.remove('is-error', 'is-success')
    if (errors && errors.length) {
      feedbackEl.innerHTML = errors.join('<br/>')
      feedbackEl.classList.add('is-error')
      return
    }
    feedbackEl.innerHTML = 'Félicitations, vous avez correctement été inscrit(e) à la Newsletter'
    feedbackEl.classList.add('is-success')
  }
}

export default Newsletter

export { NewsletterForm }
