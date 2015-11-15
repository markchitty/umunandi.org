// @codekit-prepend 'plugins/bootstrap/transition.js';
// @codekit-prepend 'plugins/bootstrap/collapse.js';
// @codekit-prepend 'plugins/bootstrap/affix.js';
// @codekit-prepend 'plugins/bootstrap/carousel.js',
// @codekit-prepend 'plugins/jquery.fadeOnScroll.js';
// @codekit-prepend 'plugins/jquery.scrollTo.js';
// @codekit-prepend 'plugins/jquery.stellar.js';

// 'assets/js/plugins/bootstrap/alert.js',
// 'assets/js/plugins/bootstrap/button.js',
// 'assets/js/plugins/bootstrap/dropdown.js',
// 'assets/js/plugins/bootstrap/modal.js',
// 'assets/js/plugins/bootstrap/tooltip.js',
// 'assets/js/plugins/bootstrap/popover.js',
// 'assets/js/plugins/bootstrap/scrollspy.js',
// 'assets/js/plugins/bootstrap/tab.js',

/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Umunandi = {

  // All pages
  common: {
    init: function() {
      $('a[href="#"]').click(function(e) { e.preventDefault(); });               // Globally limit javascript click actions
      $.scrollTo(0);                                                             // Reset the screen to (0,0)
    }
  },

  // Home page
  home: {
    init: function() {

      // ScrollTo behaviour
      $('[data-scrollto]').off().on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        $.scrollTo($this.attr('href'), $this.data().scrollto);
      });

      // Stellar parallax behaviour
      $('.parallax-bg-img').not('.fullpage-img').height(function(i,h) {
        var $this      = $(this),
            pllxOffset = $this.data('stellar-vertical-offset'),
            pllxRatio  = $this.data('stellar-ratio'),
            pageH      = $('body').height() - pllxOffset,
            sectH      = $this.closest('.parallax-container').outerHeight();
        return pageH - ((pageH - sectH) * pllxRatio);
        return pageH - ((pageH - sectH) * pllxRatio);
      })
      $.stellar({ horizontalScrolling: false });

      // Fade in/out main nav
      $('.js-fadeOnScroll').fadeOnScroll({
        elemToWatch  : '.wrap',
        fadeOutStart : 1,
        fadeOutEnd   : 33
      });

      // Animate progress bar when carousel slides
      var $bar = $('.carousel-progress-bar .progress'),
          $crsl = $('#carousel-ovcs'),
          transCss = 'transition: width ' + ($crsl.data('interval') - 600) + 'ms linear; ';
      $('<style />').text('.carousel-progress-bar .progress.max { -webkit-' + transCss + transCss + '}').appendTo('head');
      $crsl
        .on('slide.bs.carousel', function () { $bar.removeClass('max'); })
        .on('slid.bs.carousel',  function () { $bar.addClass('max'); })
        .hover(
          function() { $crsl.trigger('slide.bs.carousel') },
          function() { $crsl.trigger('slid.bs.carousel') }
        )
        .fadeOnScroll({ dontFade : true })
        .on('enteredView.fadeOnScroll', function() { $(this).carousel('cycle').trigger('slid.bs.carousel'); })
        .on('exitedView.fadeOnScroll',  function() { $(this).carousel('pause').trigger('slide.bs.carousel'); });

      // Normalise carousel slide heights
      $(window).on('resize orientationchange', function () {
        var items = $('#carousel-ovcs .item'), maxH = 0;
        items.css('min-height', '');
        items.each(function() { if ($(this).height() > maxH) maxH = $(this).height(); });
        items.each(function() { $(this).css('min-height', maxH + 'px'); });
      }).resize();

      // $crsl.hover(
      //   function() { clearInterval(barInterval); },
      //   function() { barInterval = setInterval(progressBarCarousel, 10); }
      // );
      // $crsl.carousel()
      // function progressBarCarousel() {
      //   $bar.css({ width: percent+'%' });
      //   percent += 1 / time;
      //   if (percent >= 100) {
      //     percent = 0;
      //     $crsl.carousel('next');
      //   }      
      // }
      // var barInterval = setInterval(progressBarCarousel, 10);

    }
  },

  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Umunandi;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
