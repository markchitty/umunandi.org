// Extended carousel with All New Progress-o-meters (TM)
umunandi.define('home', 5, function () {

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
    _this.isPaused = false;
    _this.pausedProgress = 0;

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
      _this.pausedProgress = 0;
      _this.$activeEl = _this.getActiveEl(e);
      _this.setCss(0, 0);
    }
    
    CarouselProgress.prototype.startProgress = function(startFrom) {
      startFrom = startFrom > 1 ? 1 : startFrom < 0 ? 0 : parseFloat(startFrom) || 0;
      var timeRemaining = _this.T_STATIC * (1 - startFrom);
      _this.isPaused = false;
      _this.t0 = Date.now() - (_this.T_STATIC * startFrom);
      _this.setCss(startFrom, timeRemaining);
      setTimeout(_this.setCss, 0, 1, timeRemaining);
    }

    CarouselProgress.prototype.startCarousel = function() {
      _this.$activeEl = _this.getActiveEl();
      _this.startProgress(_this.pausedProgress);
      _this.timeout = clearTimeout(_this.timeout);
      _this.timeout = setTimeout(function() {
        _this.$carousel.carousel('next');
        _this.$carousel.carousel('cycle');
      }, _this.T_STATIC * (1 - _this.pausedProgress));
    }
    
    CarouselProgress.prototype.pauseCarousel = function() {
      var pausedProgress = (Date.now() - _this.t0) / _this.T_STATIC;
      _this.pausedProgress = pausedProgress > 1 ? 1 : pausedProgress < 0 ? 0 : pausedProgress || 0;
      _this.isPaused = true;
      _this.carouselData.interval = clearInterval(_this.carouselData.interval);
      _this.timeout = clearTimeout(_this.timeout);
      _this.setCss(_this.pausedProgress, 0);
    }
    
    CarouselProgress.prototype.onHover = function () {
      _this.isPaused ? _this.startCarousel() : _this.pauseCarousel();
    }
    
    CarouselProgress.prototype.onSlid = function () {
      if (_this.carouselData.interval) _this.startProgress(); 
    }
  }

  umunandi.CarouselProgress = CarouselProgress;

});
