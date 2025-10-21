import { registerGsapPlugins } from './config/gsap'
import Menu from './components/menu'
// import Newsletter from './components/newsletter'
import { NewsletterForm } from './components/newsletter'
import TestimonialsSlider from '../../dotstarter/layouts/testimonials/testimonials.js'
import NewsSlider from '../../dotstarter/layouts/news-slider/news-slider.js'
import FullWidthSlider from '../../dotstarter/layouts/slider-full-width/slider-full-width.js'
import cardsSliderSwiper from '../../dotstarter/layouts/cards-slider/cards-slider.js'
import singleBibliothequeMediaSlider from './templates/bibliotheque-media-single.js'

import { modalAnims, modalForm } from './layouts/modal'
import { dropdownslist } from '../../dotstarter/layouts/dropdowns-list/dropdowns-list.js'
import { dropdownoperator } from '../../dotstarter/layouts/operateurs-grid/operateurs-grid.js'
import { pageHeaderScrollDown } from '../../dotstarter/layouts/page-header/page-header.js'
import { SingleEventsContactSlider, SingleEventsSlider } from './templates/events-single.js'
import QueryManager from './components/query-manager.js'
import GenericContentSlider from '../../dotstarter/layouts/generic-content/generic-content.js'
// import { onResize } from './lib/utils.js'
import searchModal from './components/search-modal.js'

import FormationQueryManager from './components/formation-query-manager.js'
import BibliothequeMediaQueryManager from './components/bibliotheque-media-query-manager.js'
import Popup from './components/popup'
/* eslint-disable */
const Sliders = [
  TestimonialsSlider,
  NewsSlider,
  FullWidthSlider,
  GenericContentSlider,
  cardsSliderSwiper,
  singleBibliothequeMediaSlider,
  // ProjectPartnersSlider
]

const sliders = [
  SingleEventsSlider,
  SingleEventsContactSlider,
];

jQuery(function ($) {
  // onResize
  // onResize()
  Sliders.forEach((slider) => {
    slider.init();
  });

  registerGsapPlugins()
  Menu();
  Popup();
  // Newsletter();
  NewsletterForm();

  // Initialize popup newsletter form
  NewsletterForm({
    formSelector: '#newsletter-popup-form',
    emailSelector: '#newsletter-popup-email',
    lastnameSelector: '#newsletter-popup-lastname',
    firstnameSelector: '#newsletter-popup-firstname',
    companySelector: '#newsletter-popup-company',
    roleSelector: '#newsletter-popup-role',
    citySelector: '#newsletter-popup-city',
    termsSelector: '#newsletter-popup-terms',
    feedbackSelector: '#newsletter-popup-feedback',
    expandableSelector: '.c-newsletter-__expandable',
    termsControlSelector: '.c-newsletter-form__terms'
  });

  NewsletterForm({
    formSelector: '#newsletter-form-block',
    emailSelector: '#newsletter-block-email',
    lastnameSelector: '#newsletter-block-lastname',
    firstnameSelector: '#newsletter-block-firstname',
    companySelector: '#newsletter-block-company',
    roleSelector: '#newsletter-block-role',
    citySelector: '#newsletter-block-city',
    termsSelector: '#newsletter-block-terms',
    feedbackSelector: '#newsletter-block-feedback',
    expandableSelector: '.c-newsletter-form__expandable',
    termsControlSelector: '.c-newsletter-form__terms'
  });
  searchModal();

  modalAnims();
  modalForm();

  //faq
  dropdownslist()
  dropdownoperator()
  pageHeaderScrollDown()

  sliders.forEach(slider => slider.init())

  // new EventsArchiveManager();

  // QueryFilters : Blog, Community
  new QueryManager('.f-blog', '.f-blog__posts', 'post');
  new QueryManager('.t-events-archive', '.t-events-archive__events', 'tribe_events');
  new QueryManager('.t-search', '.t-search__results', 'all', false);
  new QueryManager('.f-past-events', '.f-past-events__results', 'tribe_events', false);

  new FormationQueryManager('.f-formation-calendar__archive', '.f-formation-grid');
  new BibliothequeMediaQueryManager('.f-bibliotheque-media__archive', '.f-bibliotheque-media-grid');
})

