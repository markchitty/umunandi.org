// Home page scripts
umunandi.define('home', function () {

  // Carousel
  var carouselOptions = { interval: false, pause: '' };
  var $carousel = $('.js-kids-carousel').carousel(carouselOptions);

  // Normalise carousel slide heights
  $(window).on('resize orientationchange', function () {
    var items = $('.js-kids-carousel .item'), maxH = 0;
    items.css('min-height', '');
    items.each(function() { if ($(this).height() > maxH) maxH = $(this).height(); });
    items.each(function() { $(this).css('min-height', maxH + 'px'); });
  }).resize();

});
