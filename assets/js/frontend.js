import { registerGsapPlugins } from './config/gsap'
import Menu from './components/menu'
import Newsletter from './components/newsletter'

/* eslint-disable */
jQuery(function ($) {

  alert('Hello from your JavaScript file!')
  registerGsapPlugins()
  Menu();
  Newsletter();
})
