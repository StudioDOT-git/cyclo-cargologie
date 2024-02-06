import Slider from '../../../assets/js/components/slider.js'

const TestimonialsSlider = new Slider('f-testimonials', {
  slidesToScroll: 1,
  slidesToShow: 1,
  variableWidth: false,
  variableHeight: false,
  mobileFirst: true,
  draggable: true,
  dots: true,
  adaptiveHeight: false,
  infinite: false,
  autoplay: false,
  responsive: [
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 3.2,
        slidesToScroll: 1
      }
    }
  ]
})
export default TestimonialsSlider
