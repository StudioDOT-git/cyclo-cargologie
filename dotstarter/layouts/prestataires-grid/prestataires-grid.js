import gsap from 'gsap'
import { isMobile } from '../../../assets/js/helpers.js'

import {
  gsapContentCards
} from '../../../assets/js/animations/text.js'

function dropdownprestataire () {
  if (!isMobile()) return
  const dropdownprestataire = document.querySelectorAll('.f-prestataires-grid__item')
  if (dropdownprestataire.length > 0) {
    dropdownprestataire.forEach((item) => {
      item.addEventListener('click', () => {
        if (document.querySelector('.f-prestataires-grid__item.js-open') && document.querySelector('.f-prestataires-grid__item.js-open') !== item) {
          autoToZero(document.querySelector('.f-prestataires-grid__item.js-open .f-prestataires-grid__inner'))
          document.querySelector('.f-prestataires-grid__item.js-open').classList.remove('js-open')
        }
        item.classList.toggle('js-open')

        if (item.classList.contains('js-open')) {
          zeroToAuto(item.querySelector('.f-prestataires-grid__inner'))
        } else {
          autoToZero(item.querySelector('.f-prestataires-grid__inner'))
        }
        // document.querySelectorAll('.f-prestataires-grid__item').forEach((elt) => {
        //     elt.classList.add('f-prestataires-grid__item--blurred');
        // });
      })
    })
  }
}

function fromAuto ($element, height, duration = 0.3, ease = 'power4.inOut') {
  $element.style.height = 'auto'
  const autoHeight = $element.offsetHeight

  return gsap.fromTo($element, {
    height: autoHeight
  }, {
    height,
    ease,
    duration
  })
}

function autoToZero ($element, duration = 0.85, ease = 'power4.inOut') {
  return fromAuto($element, 0, duration, ease)
}

function zeroToAuto ($element, duration = 0.85, ease = 'power4.inOut') {
  const curHeight = $element.offsetHeight
  $element.style.height = 'auto'
  const autoHeight = $element.offsetHeight
  $element.style.height = curHeight

  return gsap.fromTo($element, {
    height: 0
  }, {
    height: autoHeight,
    ease,
    duration,
    onComplete: () => {
      $element.style.height = 'auto'
    }
  })
}

function dropdownprestataireAnims () {
  const layoutClass = '.f-prestataires-grid'
  const layouts = document.querySelectorAll(layoutClass)

  if (!layouts) return
  if (!document.querySelector('.f-prestataires-grid')) return

  gsap.utils.toArray(layoutClass).forEach(layout => {
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: layout.querySelector(`${layoutClass} .l-container`),
        start: 'top 90%',
        toggleActions: 'play none play none'
        // markers: true
      }
    })
    let delay = 0 // initial delay value, incremented for each element

    if (layout.querySelector(`${layoutClass}__title `)) {
      tl.add(function () {
        layout.querySelector(`${layoutClass}__title`).classList.add('is-inview')
      }, delay)
      delay += 0.15
    }

    if (layout.querySelectorAll(`${layoutClass}__item`)) {
      const dropdownprestataireItems = layout.querySelectorAll(`${layoutClass}__item`)

      dropdownprestataireItems.forEach((dropdownprestataireItem) => {
        tl.add(function () {
          dropdownprestataireItem.classList.add('is-inview')
        }, delay)
        delay += 0.15
      })
    }

    if (layout.querySelector(`${layoutClass}__container`)) {
      tl.from(layout.querySelectorAll(`${layoutClass}__container`), gsapContentCards, '>-=80%')
    }
  })
}

export {
  dropdownprestataire,
  dropdownprestataireAnims
}

export default function () { }
