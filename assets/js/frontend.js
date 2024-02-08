import {registerGsapPlugins} from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'
import TestimonialsSlider from "../../dotstarter/layouts/testimonials/testimonials.js";

/* eslint-disable */

jQuery(function ($) {
  TestimonialsSlider.init();
  registerGsapPlugins()
  Menu();
  Newsletter();
})
