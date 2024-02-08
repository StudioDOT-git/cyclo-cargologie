import Slider from '../../../assets/js/components/slider.js'

const FullWidthSlider = new Slider('f-slider-full-width', {
  slidesToScroll: 1,
  slidesToShow: 1,
  mobileFirst: true,
  draggable: true,
  dots: true
})
export default FullWidthSlider
