import gsap from 'gsap';

import {
    gsapContentCards
} from "../../../assets/js/animations/text.js";

export function defaultEventArchive(myMonth) {

    const layoutClass = '.c-events-archive-month';

    const layoutClassRepeater = '.c-events-archive-month';
    const layoutsRepeater = document.querySelectorAll(layoutClassRepeater);

    if (!layoutsRepeater) return;
    if (!document.querySelector(`.c-events-archive-month`)) return;

    gsap.utils.toArray(layoutClassRepeater).forEach(layout => {

        if (layout.id === myMonth) {
            let tlRepeater = gsap.timeline({
                scrollTrigger: {
                    trigger: layout.querySelector(`${layoutClassRepeater} .c-event-card`),
                    start: "top 10%",
                    toggleActions: "play none play none",
                    // markers: true
                }
            });

            if (layout.querySelector(`${layoutClass} .c-event-card`)) {
                tlRepeater.from(layout.querySelectorAll(`${layoutClassRepeater} .c-event-card`), gsapContentCards);
            }
        }

    })
}