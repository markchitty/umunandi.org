// Home page scripts
umunandi.import('home', function () {

  // Carousel
  var carouselSlideInterval = 12000;
  var carouselOptions = { interval: carouselSlideInterval, pause: '' };
  var $carousel = $('.js-kids-carousel').carousel(carouselOptions).carousel('pause');
  var carouselProgress = new umunandi.CarouselProgress($carousel);

  $('.js-kids-carousel')
    .on('slide.bs.carousel', carouselProgress.resetProgress)
    .on('slid.bs.carousel',  carouselProgress.onSlid)
    .hover(carouselProgress.onHover)
    .fadeOnScroll({ dontFade : true })
    .on('enteredView.fadeOnScroll', carouselProgress.startCarousel)
    .on('exitedView.fadeOnScroll',  carouselProgress.pauseCarousel)
  ;

  // Normalise carousel slide heights
  $(window).on('resize orientationchange', function () {
    var items = $('.js-kids-carousel .item'), maxH = 0;
    items.css('min-height', '');
    items.each(function() { if ($(this).height() > maxH) maxH = $(this).height(); });
    items.each(function() { $(this).css('min-height', maxH + 'px'); });
  }).resize();

});
