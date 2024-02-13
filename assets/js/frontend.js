import { registerGsapPlugins } from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'
import TestimonialsSlider from '../../dotstarter/layouts/testimonials/testimonials.js'
import FullWidthSlider from '../../dotstarter/layouts/slider-full-width/slider-full-width.js'

import { modalAnims, modalForm } from './layouts/modal'
import { SingleEventsContactSlider, SingleEventsSlider } from './templates/events-single.js'

/* eslint-disable */

const sliders = [
  SingleEventsSlider,
  SingleEventsContactSlider,
];


jQuery(function ($) {
  TestimonialsSlider.init();
  FullWidthSlider.init();
  registerGsapPlugins()
  Menu();
  Newsletter();

  modalAnims();
  modalForm();

  sliders.forEach(slider => slider.init())

})
