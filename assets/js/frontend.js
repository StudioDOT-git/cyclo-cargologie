import { registerGsapPlugins } from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'
import TestimonialsSlider from '../../dotstarter/layouts/testimonials/testimonials.js'
import FullWidthSlider from '../../dotstarter/layouts/slider-full-width/slider-full-width.js'
import cardsSliderSwiper from '../../dotstarter/layouts/cards-slider/cards-slider.js'

import { modalAnims, modalForm } from './layouts/modal'
import { dropdownslist } from '../../dotstarter/layouts/dropdowns-list/dropdowns-list.js'
import { SingleEventsContactSlider, SingleEventsSlider } from './templates/events-single.js'
import QueryManager from './components/query-manager.js'
import GenericContentSlider from '../../dotstarter/layouts/generic-content/generic-content.js'
import { onResize } from './lib/utils.js'
import searchModal from './components/search-modal.js'

/* eslint-disable */
const Sliders = [
  TestimonialsSlider,
  FullWidthSlider,
  GenericContentSlider,
  cardsSliderSwiper,
  // ProjectPartnersSlider
]

const sliders = [
  SingleEventsSlider,
  SingleEventsContactSlider,
];


jQuery(function ($) {
  // onResize
  onResize()
  Sliders.forEach((slider) => {
    slider.init();
  });

  registerGsapPlugins()
  Menu();
  Newsletter();
  searchModal();

  modalAnims();
  modalForm();

  //faq
  dropdownslist()


  sliders.forEach(slider => slider.init())


  // new EventsArchiveManager();

  // QueryFilters : Blog, Community
  new QueryManager('.f-blog', '.f-blog__posts', 'post');
  new QueryManager('.t-events-archive', '.t-events-archive__events', 'tribe_events');
  new QueryManager('.t-search', '.t-search__results', 'all');


})
