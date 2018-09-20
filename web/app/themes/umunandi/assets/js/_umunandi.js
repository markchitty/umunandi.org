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
      $('a[href="#"]').click(function(e) { e.preventDefault(); });  // Globally limit javascript click actions
      $.scrollTo(0);                                                // Reset the screen to (0,0)

      var lastScrollTop = 0;
      var $navBar = $('.js-main-nav');

      // Show navbar when scrolling back up
      function toggleNavOnScroll() {
        var curScrollTop = $(window).scrollTop();
        if (Math.abs(lastScrollTop - curScrollTop) <= 5) return;
        var isPageScrolledBackUp = (curScrollTop < lastScrollTop && curScrollTop != 0);
        $navBar.toggleClass('page-scrolled-up', isPageScrolledBackUp);
        lastScrollTop = curScrollTop;
      }
      $(window).scroll($.debounce(10, toggleNavOnScroll));

      // Track navbar position to control floating/fixed state
      var navBarTopY = $navBar.offset().top;
      $(document).scroll(function() {
        $navBar.toggleClass('fixed', $(this).scrollTop() > navBarTopY);
      });
    }
  },

  // Home page
  home: {
    init: function() {

      // ScrollTo behaviour
      $('[data-scrollto]').off().on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var scrollOpts = { duration: $this.data().scrollto };
        $.scrollTo($this.attr('href'), scrollOpts);
      });

      // Animate progress bar when carousel slides
      var progressBarSelector = '.js-carouselProgressBar .progress',
          $bar = $(progressBarSelector),
          $crsl = $('.js-carouselOvcs'),
          transitionCss = progressBarSelector + '.max { transition: width '
                        + ($crsl.data('interval') - 600) + 'ms linear; }';
      $('<style />').text(transitionCss).appendTo('head');
      $crsl
        .on('slide.bs.carousel', function () { $bar.removeClass('max'); })
        .on('slid.bs.carousel',  function () { $bar.addClass('max'); })
        .hover(
          function() { $crsl.trigger('slide.bs.carousel'); },
          function() { $crsl.trigger('slid.bs.carousel'); }
        )
        .fadeOnScroll({ dontFade : true })
        .on('enteredView.fadeOnScroll', function() { $(this).carousel('cycle').trigger('slid.bs.carousel'); })
        .on('exitedView.fadeOnScroll',  function() { $(this).carousel('pause').trigger('slide.bs.carousel'); });

      // Normalise carousel slide heights
      $(window).on('resize orientationchange', function () {
        var items = $('.js-carouselOvcs .item'), maxH = 0;
        items.css('min-height', '');
        items.each(function() { if ($(this).height() > maxH) maxH = $(this).height(); });
        items.each(function() { $(this).css('min-height', maxH + 'px'); });
      }).resize();

    }
  },

  // About us page, note the change from about-us to about_us.
  test_page: {
    init: function() {
      dimsum.configure({
        format: 'text',
        flavor: 'jabberwocky',
        sentences_per_paragraph: [4, 10],
        words_per_sentence: [4, 12],
        commas_per_sentence: [0, 2]
      });
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
