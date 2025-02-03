import gsap from 'gsap'
import SplitText from 'gsap/SplitText'
import DrawSVGPlugin from 'gsap/DrawSVGPlugin'
import {

  gsapHeading1,
  gsapParagraph,
  gsapContentCards,
  gsapLineDeco
} from '../../../assets/js/animations/text.js'

export default function () {
  const layoutClass = '.f-blog'
  const layouts = document.querySelectorAll(layoutClass)

  if (!layouts) return
  if (!document.querySelector('.f-blog')) return

  gsap.utils.toArray(layoutClass).forEach(layout => {
    const splitTitle = new SplitText(document.querySelector(`${layoutClass}__title`), {
      type: 'words'
    })

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: layout.querySelector(`${layoutClass} .l-container`),
        start: 'top 90%'
        // markers: true
      }
    })

    if (document.querySelector('.c-blog-header .c-breadcrumbs')) {
      tl.from(document.querySelector('.c-blog-header .c-breadcrumbs'), gsapParagraph, '>-=0%')
    }

    if (document.querySelector('.c-blog-header__title')) {
      tl.from(document.querySelectorAll('.c-blog-header__title *'), gsapHeading1, '>-=80%')
    }

    if (document.querySelector('.c-filters-bar')) {
      tl.from(document.querySelector(' .c-filters-bar'), gsapParagraph, '>-=80%')
    }

    if (layout.querySelector(`${layoutClass} .f-blog__posts`)) {
      tl.from(layout.querySelectorAll(`${layoutClass} .f-blog__posts`), gsapContentCards, '>-=60%')
    }

    if (document.querySelector('.c-blog-header__deco path')) {
      tl.from(document.querySelector('.c-blog-header__deco path'), gsapLineDeco, '>-=80%')
    }
  })
}
