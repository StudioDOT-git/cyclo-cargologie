import Slider from '../../../assets/js/components/slider.js'

const singleBibliothequeMediaSlider = new Slider('t-media-single-slider', {
  slidesToScroll: 1,
  slidesToShow: 1,
  mobileFirst: true,
  draggable: true,
  dots: true
})

export default singleBibliothequeMediaSlider
