import { registerGsapPlugins } from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'
import TestimonialsSlider from '../../dotstarter/layouts/testimonials/testimonials.js'
import FullWidthSlider from '../../dotstarter/layouts/slider-full-width/slider-full-width.js'

import { modalAnims, modalForm } from './layouts/modal'
import { dropdownslist, dropdownslistAnims } from '../../dotstarter/layouts/dropdowns-list/dropdowns-list.js'

/* eslint-disable */

jQuery(function ($) {
  TestimonialsSlider.init();
  FullWidthSlider.init();
  registerGsapPlugins()
  Menu();
  Newsletter();

  modalAnims();
  modalForm();

  //faq
  dropdownslist()
})
