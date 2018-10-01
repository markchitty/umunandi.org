// Common scripts that run on all pages

// Umunandi global
var Umunandi = Umunandi || {};

(function (Umunandi) {

  function init() {
    // Globally limit javascript click actions
    $('a[href="#"]').click(function(e) { e.preventDefault(); });  

    // Reset the screen to (0,0)
    $.scrollTo(0);
    
    // Track navbar position to control floating/fixed state
    var $navBar = $('.js-main-nav');
    var $navBarRef = $('.js-main-nav-position-ref');
    var navBarRefTop;

    function getNavBarRefTop() { navBarRefTop = $navBarRef.offset().top; }
    getNavBarRefTop();

    $(window).on('resize orientationchange', $.debounce(100, getNavBarRefTop));
    $(document).scroll(function() {
      $navBar.toggleClass('fixed', $(this).scrollTop() > navBarRefTop); }
    );
  }

  // export
  Umunandi.common = init;

})(Umunandi);
