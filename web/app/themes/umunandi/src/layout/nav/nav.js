// Navigation related scripts

umunandi.define('common', function() {

  // Track navbar position to control floating/fixed state
  var navBar = {};
  navBar.el = $('.js-main-nav');
  navBar.refEl = $('.js-main-nav-position-ref');
  navBar.height = navBar.el.height();

  function onResize() {
    umunandi.screenSize.updateSizes();
    navBar.refElTop = navBar.refEl.offset().top;
  }
  $(window).on('resize orientationchange', $.debounce(100, onResize));
  onResize();

  function onScroll() {
    navBar.el.toggleClass('fixed', $(this).scrollTop() > navBar.refElTop);
  }
  $(document).on('scroll.umunandi', onScroll);
  onScroll();

  // Intercept scrollTo() calls - adjust the scroll end point to account for fixed navBar
  $.Animation.prefilter(function(el, props, opts) {
    if (el === window && 'scrollTop' in props && umunandi.screenSize.isAtLeastSm)
      props.scrollTop -= navBar.height;
  });

  // ScrollTo behaviour
  $('[data-scrollto]').off().on('click', function (e) {
    e.preventDefault();
    $('.nav-toggle-checkbox').prop('checked', false); // Close mobile menu
    var scrollOpts = {
      duration: parseInt(this.dataset.scrollto),
      offset: parseInt(this.dataset.scrolloffset)
    };
    $.scrollTo(this.dataset.scrollhref || $(this).attr('href'), scrollOpts);
  });

  // Globally limit javascript click actions
  $('a[href="#"]').click(function(e) { e.preventDefault(); });  

});
