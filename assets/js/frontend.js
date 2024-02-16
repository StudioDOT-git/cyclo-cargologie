import { registerGsapPlugins } from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'
import TestimonialsSlider from '../../dotstarter/layouts/testimonials/testimonials.js'
import FullWidthSlider from '../../dotstarter/layouts/slider-full-width/slider-full-width.js'

import { modalAnims, modalForm } from './layouts/modal'
import { dropdownslist, dropdownslistAnims } from '../../dotstarter/layouts/dropdowns-list/dropdowns-list.js'
import { SingleEventsContactSlider, SingleEventsSlider } from './templates/events-single.js'
import { EventsArchiveManager } from './templates/events-archive.js'
import QueryManager from './components/query-manager.js'
import GenericContentSlider from '../../dotstarter/layouts/generic-content/generic-content.js'
import ProjectPartnersSlider from '../../dotstarter/layouts/project-partners-section/project-partners-section.js'

/* eslint-disable */
const Sliders = [
  TestimonialsSlider,
  FullWidthSlider,
  GenericContentSlider,
  ProjectPartnersSlider
]

const sliders = [
  SingleEventsSlider,
  SingleEventsContactSlider,
];


jQuery(function ($) {
  Sliders.forEach((slider) => {
    slider.init();
  });

  registerGsapPlugins()
  Menu();
  Newsletter();

  modalAnims();
  modalForm();

  //faq
  dropdownslist()

  sliders.forEach(slider => slider.init())


  new EventsArchiveManager();

  // QueryFilters : Blog, Community
  new QueryManager('.f-blog', '.f-blog__posts', 'posts');


})
