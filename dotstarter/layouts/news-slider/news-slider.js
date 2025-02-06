import Slider from '../../../assets/js/components/slider.js'

const NewsSlider = new Slider('f-news-slider', {
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
      breakpoint: 992,
      settings: {
        slidesToShow: 3.2,
        slidesToScroll: 1
      }
    }
  ]
})
export default NewsSlider
