import gsap from 'gsap';
import SplitText from "gsap/SplitText";
import DrawSVGPlugin from "gsap/DrawSVGPlugin";

import {
    gsapHeading1,
    gsapParagraph,
    gsapContentCards,
    gsapLineDeco
} from "../../../assets/js/animations/text.js";

function genericContentAnims() {

    const layoutClass = '.f-generic-content';
    const layouts = document.querySelectorAll(layoutClass);

    if (!layouts) return;
    if (!document.querySelector(`.f-generic-content`)) return;

    gsap.utils.toArray(layoutClass).forEach(layout => {

        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: layout.querySelector(`${layoutClass} .l-container`),
                start: "top 80%",
                toggleActions: "play none play none"
                // markers: true
            }
        });

        let delay = 0; // initial delay value, incremented for each element

        if (layout.querySelectorAll(`${layoutClass}__main .a-fade-in`)) {

            let dropdownslistItems = layout.querySelectorAll(`${layoutClass}__main .a-fade-in`);

            dropdownslistItems.forEach((dropdownslistItem) => {
                tl.add(function () {
                    dropdownslistItem.classList.add("is-inview");
                }, delay);
                delay += 0.15;
            });
        }
    })
}

export {
    genericContentAnims
}