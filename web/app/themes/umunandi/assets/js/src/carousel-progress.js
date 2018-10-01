// Extended carousel with All New Progress-o-meters (TM)

// Umunandi global
var Umunandi = Umunandi || {};

(function (Umunandi) {

  // Carousel Progressometer Class
  // Supporting API for svg.progressometer
  var CarouselProgress = function($carousel) {

    // When jQuery calls() the class methods below it passes in a reference to the current 
    // element as 'this'. We want the methods to reference the CarouselProgress class, not
    // the passed-in element, so we create our own '_this' reference that can't be overriden.
    var _this = this;

    _this.$carousel = $carousel;
    _this.carouselData = $carousel.data('bs.carousel');
    _this.T_STATIC = _this.carouselData.options.interval - $carousel.carousel.Constructor.TRANSITION_DURATION;
    _this.curProgress = 0;

    CarouselProgress.prototype.getActiveEl = function(e) {
      var $activeSlide = e ? $(e.relatedTarget) : _this.$carousel.find('.item.active');
      return $activeSlide.find('.radial-progress');
    }

    CarouselProgress.prototype.setCss = function(progress, speed) {
      // svg.progressometer strokeDashoffset range: min = 1000, max = 1315
      _this.$activeEl.css({
        strokeDashoffset: parseInt(1000 + (progress * 315)),
        transitionDuration: speed.toFixed(0) + 'ms'
      });
    }
    
    CarouselProgress.prototype.resetProgress = function(e) {
      _this.$activeEl = _this.getActiveEl(e);
      _this.setCss(0, 0);
      _this.curProgress = 0;
    }
    
    CarouselProgress.prototype.startProgress = function(startFrom) {
      startFrom = startFrom > 1 ? 1 : startFrom < 0 ? 0 : parseFloat(startFrom) || 0;
      var remaining = 1 - startFrom;
      var timeRemaining = _this.T_STATIC * remaining;
      _this.t0 = Date.now() - (_this.T_STATIC * startFrom);
      _this.setCss(startFrom, timeRemaining);
      setTimeout(_this.setCss, 0, 1, timeRemaining);
    }

    CarouselProgress.prototype.startCarousel = function() {
      _this.timeout = clearTimeout(_this.timeout);
      _this.$activeEl = _this.getActiveEl();
      _this.startProgress(_this.curProgress);
      _this.timeout = setTimeout(function() {
        _this.$carousel.carousel('next');
        _this.$carousel.carousel('cycle');
      }, _this.T_STATIC * (1 - _this.curProgress));
    }
    
    CarouselProgress.prototype.pauseCarousel = function() {
      var curProgress = (Date.now() - _this.t0) / _this.T_STATIC;
      _this.curProgress = curProgress > 1 ? 1 : curProgress < 0 ? 0 : curProgress || 0;
      _this.carouselData.interval = clearInterval(_this.carouselData.interval);
      _this.timeout = clearTimeout(_this.timeout);
      _this.setCss(_this.curProgress, 0);
    }
    
    CarouselProgress.prototype.onSlid = function () {
      if (_this.carouselData.interval) _this.startProgress(); 
    }
  }

  // export
  Umunandi.CarouselProgress = CarouselProgress;

})(Umunandi);
