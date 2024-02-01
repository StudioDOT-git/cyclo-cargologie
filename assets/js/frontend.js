import {registerGsapPlugins} from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'

/* eslint-disable */

jQuery(function ($) {
  registerGsapPlugins()
  Menu();
  Newsletter();
})
