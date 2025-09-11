import Slider from '../../../assets/js/components/slider.js'

const singleBibliothequeMediaSlider = new Slider('t-media-single-slider', {
  slidesToScroll: 1,
  slidesToShow: 1,
  // mobileFirst: true,
  draggable: true,
  adaptiveHeight: true,
  dots: true
  // cssEase: 'ease',
  // speed: 400,
  // centerMode: false,
  // variableWidth: false
})

export default singleBibliothequeMediaSlider
