import * as EmailValidator from 'email-validator'

function Newsletter() {
  const btn = document.querySelector('.l-newsletter__column .wpforms-submit')
  const input = document.querySelector('.l-newsletter__column #wpforms-82-field_1')

  function checkInput() {
    if (input.value.trim() !== '') {
      btn.classList.add('is-show')
    } else {
      btn.classList.remove('is-show')
    }
  }

  input.addEventListener('input', checkInput)
  checkInput()
}

function NewsletterForm() {
  const contactForm = document.querySelector('.f-contact-form__form-container form')

  const formEl = document.querySelector('#newsletter-form')

  const emailInputEl = document.querySelector('#newsletter-email')

  const termsCheckboxEl = document.querySelector('#newsletter-terms')
  const termsControlEl = formEl.querySelector('.c-newsletter-form__terms')
  const feedbackEl = document.querySelector('#newsletter-feedback')
  const expandableEl = formEl.querySelector('.c-newsletter-form__expandable')
  const expandableElHeight = expandableEl.scrollHeight + termsControlEl.scrollHeight

  const errors = []
  let email, firstname, lastname, company, role, city
  let isSubscribed = false

  if (!emailInputEl || !formEl) {
    return
  }

  // We don't use "once" param because both event listeners are removed manually
  emailInputEl.addEventListener('keydown', expandAndRemoveListeners)
  emailInputEl.addEventListener('onautocomplete', expandAndRemoveListeners)
  formEl.addEventListener('submit', handleSubmit)
  contactForm.addEventListener('submit', onContactFormSubmit)

  function validateForm() {
    email = emailInputEl.value
    lastname = formEl.querySelector('#newsletter-lastname').value
    firstname = formEl.querySelector('#newsletter-firstname').value

    // TODO
    company = formEl.querySelector('#newsletter-company').value
    role = formEl.querySelector('#newsletter-role').value
    city = formEl.querySelector('#newsletter-city').value

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

    // if (!role.length) {
    //   errors.push('La fonction est obligatoire')
    // }

    if (!city.length) {
      errors.push('La ville est obligatoire')
    }

    if (!termsCheckboxEl.checked) {
      errors.push('Vous devez accepter les conditions.')
      termsCheckboxEl.addEventListener('click', () => resetFeedback(), { once: true })
    }
  }

  async function handleSubmit(e) {
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

  function getContactFormInput(selector) {
    const baseClass = '.f-contact-form__field'
    return contactForm.querySelector(`${baseClass}-${selector} input`)
  }

  async function onContactFormSubmit(e) {
    const newsletterCheckbox = getContactFormInput('newsletter')
    const termsCheckbox = getContactFormInput('terms')
    if (!newsletterCheckbox || !newsletterCheckbox.checked || !termsCheckbox || !termsCheckbox.checked) return
    const email = getContactFormInput('email').value
    const firstname = getContactFormInput('firstname').value
    const lastname = getContactFormInput('lastname').value
    const company = getContactFormInput('company').value
    const role = getContactFormInput('role').value
    const city = getContactFormInput('city').value

    if (!EmailValidator.validate(email) || !firstname || !lastname || !company || !city) return
    const data = {
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
    sendToMailjet(data)
  }

  async function sendToMailjet(data = null) {
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

  function expandAndRemoveListeners() {
    expandForm()
    emailInputEl.removeEventListener('keydown', expandAndRemoveListeners)
    emailInputEl.removeEventListener('onautocomplete', expandAndRemoveListeners)
  }

  function expandForm() {
    expandableEl.classList.add('is-expanded')
    expandableEl.style.maxHeight = expandableElHeight + 'px'
  }

  function resetFeedback() {
    errors.length = 0
    feedbackEl.innerHTML = ''
    feedbackEl.classList.remove('is-error', 'is-success')
  }

  function showFeedback(errors = null) {
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
