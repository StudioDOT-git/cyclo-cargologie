import { registerGsapPlugins } from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'
import TestimonialsSlider from '../../dotstarter/layouts/testimonials/testimonials.js'
import FullWidthSlider from '../../dotstarter/layouts/slider-full-width/slider-full-width.js'

import { modalAnims, modalForm } from './layouts/modal'
import { EventsArchiveManager } from './templates/events-archive.js'
import QueryManager from './components/query-manager.js'

/* eslint-disable */

jQuery(function ($) {
  TestimonialsSlider.init();
  FullWidthSlider.init();
  registerGsapPlugins()
  Menu();
  Newsletter();

  modalAnims();
  modalForm();

  new EventsArchiveManager();

  // QueryFilters : Blog, Community
  new QueryManager('.f-blog', '.f-blog__posts', 'posts');


})
