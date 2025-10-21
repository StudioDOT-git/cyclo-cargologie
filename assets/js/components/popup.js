export default function Popup () {
  const popup = document.querySelector('.l-pop-up')
  if (!popup) return

  // Get cookie duration and content hash from data attributes (set in PHP)
  const cookieDuration = parseInt(popup.dataset.cookieDuration, 10) || 24 // fallback 24h
  const contentHash = popup.dataset.contentHash || 'default'

  // Cookie helpers
  function setCookie (name, value, hours) {
    const d = new Date()
    d.setTime(d.getTime() + (hours * 60 * 60 * 1000))
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/;SameSite=Lax`
  }

  function getCookie (name) {
    const v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')
    return v ? v.pop() : ''
  }

  // Hide popup if cookie is set AND content hasn't changed
  const cookieName = `popup_closed_${contentHash}`
  if (getCookie(cookieName)) {
    return
  }

  // Show popup with animation
  popup.classList.add('l-pop-up--visible')

  // Add close button event
  let closeBtn = popup.querySelector('.l-pop-up__close')
  if (!closeBtn) {
    // If not present, create it
    closeBtn = document.createElement('button')
    closeBtn.className = 'l-pop-up__close'
    closeBtn.setAttribute('aria-label', 'Fermer le pop-up')
    closeBtn.innerHTML = '&times;'
    popup.insertBefore(closeBtn, popup.firstChild)
  }

  closeBtn.addEventListener('click', function () {
    popup.classList.remove('l-pop-up--visible')
    setCookie(cookieName, '1', cookieDuration)
  })
}
