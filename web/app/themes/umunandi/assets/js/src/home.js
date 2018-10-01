// Home page scripts

// Umunandi global
var Umunandi = Umunandi || {};

(function (Umunandi) {

  function homePage() {

    // ScrollTo behaviour
    $('[data-scrollto]').off().on('click', function(e) {
      e.preventDefault();
      $('.nav-toggle-checkbox').prop('checked', false); // Close the mobile menu
      var $this = $(this);
      var scrollOpts = {
        duration: $this.data().scrollto,
        offset: $this.data().scrolloffset
      };
      $.scrollTo($this.attr('href'), scrollOpts);
    });

    // Carousel
    var carouselSlideInterval = 12000;
    var carouselOptions = { interval: carouselSlideInterval, pause: '' };
    var $carousel = $('.js-kids-carousel').carousel(carouselOptions).carousel('pause');
    var carouselProgress = new Umunandi.CarouselProgress($carousel);

    $('.js-kids-carousel')
      .on('slide.bs.carousel', carouselProgress.resetProgress)
      .on('slid.bs.carousel',  carouselProgress.onSlid)
      .hover(carouselProgress.pauseCarousel, carouselProgress.startCarousel)
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

  }

  // export
  Umunandi.home = homePage;

})(Umunandi);
