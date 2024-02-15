import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

const abreviations = {
    'janvier': 'janv',
    'février': 'févr',
    'mars': 'mars',
    'avril': 'avr',
    'mai': 'mai',
    'juin': 'juin',
    'juillet': 'juill',
    'août': 'août',
    'septembre': 'sept',
    'octobre': 'oct',
    'novembre': 'nov',
    'décembre': 'déc',
}
export class EventsArchiveMonthsNavbar {
    constructor(eventsArchive) {
        this.wrapperElem = document.querySelector('#events-archive-months-navbar');
        if (!this.wrapperElem) return;

        this.eventsArchive = eventsArchive;

        this.rootClass = 'c-months-navbar';
        this.navItemClass = 'c-months-navbar__item';
        this.archiveRootElem = document.querySelector('#events-archive');

        this.navElem = this.wrapperElem.querySelector(`.${this.rootClass}__nav`);
        this.monthsContainer = this.wrapperElem.querySelector(`.${this.rootClass}__months`);
        this.monthElems = [...document.querySelectorAll('.c-events-archive-month')];
        this.monthsData = [];

        this.prevButtonElem = this.wrapperElem.querySelector('#months-navbar-btn-prev');
        this.nextButtonElem = this.wrapperElem.querySelector('#months-navbar-btn-next');

        this.startIdx = 0;
        this.endIdx = 3;

        this.isInitialLoad = false;
        this.isLoading = true; // At page load eventsArchive will be loading

        this.scrollTriggers = [];
        this.toggleScrollTrigger = null;

        this.setListeners();
    }

    setListeners() {
        // Run once after initial month load
        this.archiveRootElem.addEventListener('month-loaded', () => {
            this.navItems = this.wrapperElem.querySelectorAll(`.${this.navItemClass}`);
            this.prepareInitialMonthsData();
            this.isLoading = false;

            // Run every month load after initial load

            this.archiveRootElem.addEventListener('month-loaded', this.onMonthLoaded.bind(this));
        }, { once: true });

        this.prevButtonElem.addEventListener('click', e => this.onNavItemClick(e));
        this.nextButtonElem.addEventListener('click', e => this.onNavItemClick(e));

        // Toggle navbar on scroll
        this.createToggleTrigger();
    }

    createToggleTrigger() {
        if (this.toggleScrollTrigger) {
            this.toggleScrollTrigger.kill()
        }

        this.toggleScrollTrigger = ScrollTrigger.create({
            trigger: this.archiveRootElem,
            start: "top",
            end: "bottom",
            onEnter: () => this.show(),
            onEnterBack: () => this.show(),
            onLeave: () => this.hide(),
            onLeaveBack: () => this.hide()
        })
    }

    onMonthLoaded() {
        this.resetTriggers();
        this.createToggleTrigger();

        this.prepareNextMonthsData();

        this.setSelectedNavItem();

        this.setMonthsToDisplay();

        this.render();
    }

    onNavItemClick(e) {
        if (this.isLoading) return;

        this.isLoading = true;
        // Check if month is loaded already
        const target = e.target.dataset.target;
        let slug = target;

        let monthToHandle;

        if (target === 'prev' || target === 'next') {
            // Find prev / next month
            const currentMonthIdx = this.monthsData.findIndex(monthToCompare => this.selectedMonth.slug === monthToCompare.slug);
            const targetIdx = target === 'prev' ? currentMonthIdx - 1 : currentMonthIdx + 1;

            if (typeof this.monthsData[targetIdx] !== 'undefined') {
                monthToHandle = this.monthsData[targetIdx];
            } else {
                console.log('Could not find month data for month index: ', targetIdx);
            }
        } else {
            monthToHandle = this.monthsData.find(month => month.slug === slug);
        }

        const isAlreadyLoaded = this.eventsArchive.isMonthLoaded(monthToHandle.date);

        if (isAlreadyLoaded) {
            // Find month DOM element
            this.scrollToMonth(monthToHandle.slug);
            this.isLoading = false;
            return;
        } else {
            // Scroll to bottom of events container
            // gsap.to(window, { scrollTo: '#events-end', offsetY: -400 });

            const latestMonth = this.eventsArchive.loadedMonths[this.eventsArchive.loadedMonths.length - 1];

            // Count number of months between clicked date & last loaded date
            const monthsToLoadCount = monthToHandle.date.getMonth() - latestMonth.getMonth() +
                (12 * (monthToHandle.date.getFullYear() - latestMonth.getFullYear()))

            // Load events
            this.lastMonthsLoadedCount = monthsToLoadCount;
            this.eventsArchive.loadEvents(monthsToLoadCount);

            // Wait for load to finish then scroll to end of container again
            this.eventsArchive.getWrapper().addEventListener('month-loaded', () => {
                this.prepareNextMonthsData();

                const monthElems = document.querySelectorAll('.c-events-archive-month');
                const scrollTo = monthElems[monthElems.length - 1];
                // gsap.to(window, { scrollTo: scrollTo, offsetY: -200 });

                this.isLoading = false;
            }, { once: true })
        }
    }

    /**
     * Scroll to month DOM element
     * @param {string} slug
     */
    scrollToMonth(slug) {
        const elem = document.getElementById(slug);
        console.log(elem.id);

        if (!elem) {
            console.error('Could not find month DOM element to scroll to.');
        }

        // gsap.to(window, { duration: 1, scrollTo: elem, offsetY: 10 });
    }

    prepareInitialMonthsData() {
        const initialDate = this.eventsArchive.loadedMonths[0];

        const nextDate = new Date(initialDate.getTime());
        nextDate.setMonth(nextDate.getMonth() + 1);

        const nextNextDate = new Date(initialDate.getTime());
        nextNextDate.setMonth(nextNextDate.getMonth() + 2);

        const monthsData = [initialDate, nextDate, nextNextDate].map(date => this.generateMonthObject(date));

        this.selectedMonth = monthsData[0];
        this.initialDate = initialDate;

        this.monthsData = monthsData;
    }

    /**
     * Generate array of months to render in navbar
     */
    prepareNextMonthsData() {
        const lastLoadedDate = this.eventsArchive.loadedMonths[this.eventsArchive.loadedMonths.length - 1];

        const datesToHandle = [];

        for (let i = 1; i < 3; i++) {
            const date = new Date(lastLoadedDate.getTime());
            date.setMonth(date.getMonth() + i);
            datesToHandle.push(date);
        }

        datesToHandle.forEach(date => {
            const month = this.generateMonthObject(date);

            // Add to monthsData if it doesn't exist in it yet
            if (!this.monthsData.find(toCompare => toCompare.slug === month.slug)) {
                this.monthsData.push(month)
            }
        })
    }

    /**
     * Render all nav items
     */
    render() {
        // Remove previous items
        const previousNavItems = this.wrapperElem.querySelectorAll(`.${this.navItemClass}`);
        previousNavItems.forEach(item => item.remove());

        // Generate template

        let displayCount = this.monthsData.indexOf(this.selectedMonth) === 0 ? 3 : this.startIdx + 4;
        let template = '';

        for (let i = this.startIdx; i < displayCount; i++) {
            if (!(typeof this.monthsData[i] === 'undefined')) {
                template += this.getNavItemTemplate(this.monthsData[i]);
            } else {
                console.log("Can't find month data for date index: ", i);
            }
        }

        // Replace template
        this.monthsContainer.innerHTML = template;

        // Toggle prev button if needed
        if (this.selectedMonth.date === this.initialDate) {
            if (!this.prevButtonElem.classList.contains('hide')) {
                this.prevButtonElem.classList.add('hide');
            }
        } else {
            if (this.prevButtonElem.classList.contains('hide')) {
                this.prevButtonElem.classList.remove('hide');
            }
        }

        // Get nav item elements & set listeners
        this.navItems = this.wrapperElem.querySelectorAll(`.${this.navItemClass}`);
        this.navItems.forEach(navItem => navItem.addEventListener('click', e => this.onNavItemClick(e)));
    }

    /**
     * Create scroll trigger to keep track of user position
     */
    addTriggerToElem(elem) {
        this.scrollTriggers.push(ScrollTrigger.create({
            trigger: elem,
            start: "top 50%",
            end: "bottom 50%",
            onEnter: data => this.onTrigger(data),
            onEnterBack: data => this.onTrigger(data)
        }))
    }

    /**
     * Reset items to observe on intersection
     */
    resetTriggers() {
        // Observe previous & new elements
        const allMonthElems = [...document.querySelectorAll('.c-events-archive-month')];

        this.scrollTriggers.forEach(trigger => trigger.kill());
        allMonthElems.forEach(this.addTriggerToElem.bind(this));

        this.monthElems = allMonthElems;
    }

    /**
     *
     * @param {*} data
     * @returns
     */
    onTrigger(data) {
        if (this.isLoading) return;

        const id = data.trigger.id;

        this.selectedMonth = this.monthsData.find(month => month.slug === id);

        if (this.selectedMonth) {
            this.setMonthsToDisplay();
            this.setSelectedNavItem();
            this.render();
        } else {
            console.error('Could not find month : ', id)
        }
    }

    /**
     * Refresh navigation on intersection : get new dates, update DOM, notify archive to load month if needed
     */
    setSelectedNavItem() {
        this.navItems.forEach(item => delete item.dataset.selected);

        const elemToUpdate = this.getSelectedNavItem();

        if (elemToUpdate) {
            if (elemToUpdate.dataset.selected !== true) {
                elemToUpdate.dataset.selected = true;
            }
        }
    }

    /**
     *
     * @returns HTMLElement
     */
    getSelectedNavItem() {
        return document.querySelector(`[data-target="${this.selectedMonth.slug}"]`);
    }

    setMonthsToDisplay() {
        const selectedMonthIdx = this.monthsData.indexOf(this.selectedMonth);

        this.endIdx = selectedMonthIdx + 2;

        this.startIdx = selectedMonthIdx - 1 >= 0 ? selectedMonthIdx - 1 : 0;
        if (this.endIdx < 3) {
            this.startIdx = 0;
        }
    }

    /**
     * Generate a month name, shortname and slug from a date
     * @param {Date} date
     * @returns
     */
    generateMonthObject(date) {
        const name = this.getMonthName(date);
        const shortname = this.getMonthShortName(name);
        const slug = this.getMonthSlug(date);

        return {
            date,
            name,
            shortname,
            slug
        }
    }

    /**
     * Generate localized month name (fr-FR) from date
     * @param {Date} date
     * @returns string | false
     */
    getMonthName(date) {
        if (date instanceof Date) {
            return date.toLocaleDateString('fr-FR', { month: "long" });
        }
        return false;
    }

    /**
     * Get short version of month name
     *
     * @param {string} name
     */
    getMonthShortName(name) {
        if (name in abreviations) {
            return abreviations[name];
        }
        return name;
    }

    getMonthSlug(date) {
        const year = date.getFullYear();
        const month = date.toLocaleString("fr-FR", { month: "long" });

        const slug = `${month}-${year}`;

        return slug;
    }

    /**
     * Generate nav item template from month object
     *
     * @param {date: Date, name: string, shortname: string, slug: string} month
     * @returns
     */
    getNavItemTemplate(month) {
        const selected = this.selectedMonth.slug === month.slug ? 'data-selected="true"' : '';

        const target = this.getMonthSlug(month.date);
        // date : {name: string, shortName: string, slug: string, date: Date}
        return `<li class="c-months-navbar__item" data-target="${target}" ${selected}>${month.shortname}</li>`
    }

    show() {
        this.wrapperElem.classList.add('show');
    }

    hide() {
        this.wrapperElem.classList.remove('show');
    }
}
