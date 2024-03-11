import Slider from '../../../assets/js/components/slider.js'

const cardsSliderSwiper = new Slider('f-cards-slider', {
  slidesToScroll: 1,
  slidesToShow: 1.2,
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
      breakpoint: 992,
      settings: {
        slidesToShow: 4.1,
        slidesToScroll: 1
      }
    }
  ]
})

export default cardsSliderSwiper
