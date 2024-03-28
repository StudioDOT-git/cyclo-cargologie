import gsap from 'gsap'

import {
  gsapContentCards

} from '../../../assets/js/animations/text.js'

function dropdownslist() {
  const dropdownslist = document.querySelectorAll('.f-dropdowns-list__item')
  if (dropdownslist.length > 0) {
    dropdownslist.forEach((item) => {
      item.addEventListener('click', () => {
        if (document.querySelector('.f-dropdowns-list__item.js-open') && document.querySelector('.f-dropdowns-list__item.js-open') !== item) {
          autoToZero(document.querySelector('.f-dropdowns-list__item.js-open .f-dropdowns-list__inner'))
          document.querySelector('.f-dropdowns-list__item.js-open').classList.remove('js-open')
        }
        item.classList.toggle('js-open')

        if (item.classList.contains('js-open')) {
          zeroToAuto(item.querySelector('.f-dropdowns-list__inner'))
        } else {
          autoToZero(item.querySelector('.f-dropdowns-list__inner'))
        }
        // document.querySelectorAll('.f-dropdowns-list__item').forEach((elt) => {
        //     elt.classList.add('f-dropdowns-list__item--blurred');
        // });
      })
    })
  }
}

function fromAuto($element, height, duration = 0.3, ease = 'power4.inOut') {
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

function autoToZero($element, duration = 0.85, ease = 'power4.inOut') {
  return fromAuto($element, 0, duration, ease)
}

function zeroToAuto($element, duration = 0.85, ease = 'power4.inOut') {
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

function dropdownslistAnims() {
  const layoutClass = '.f-dropdowns-list'
  const layouts = document.querySelectorAll(layoutClass)

  if (!layouts) return
  if (!document.querySelector('.f-dropdowns-list')) return

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
      const dropdownslistItems = layout.querySelectorAll(`${layoutClass}__item`)

      dropdownslistItems.forEach((dropdownslistItem) => {
        tl.add(function () {
          dropdownslistItem.classList.add('is-inview')
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
  dropdownslist,
  dropdownslistAnims
}

export default function () { }
