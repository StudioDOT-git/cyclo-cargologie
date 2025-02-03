import Slider from '../../../assets/js/components/slider.js'

const GenericContentSlider = new Slider('f-generic-content', {
  slidesToScroll: 1,
  slidesToShow: 1,
  mobileFirst: true,
  draggable: true,
  dots: true
})
export default GenericContentSlider
