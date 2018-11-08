// Common scripts that run on all pages

umunandi.import('common', function() {

  // Globally limit javascript click actions
  $('a[href="#"]').click(function(e) { e.preventDefault(); });  

  // Reset the screen to (0,0)
  $.scrollTo(0);

  // ScrollTo behaviour
  $('[data-scrollto]').off().on('click', function (e) {
    e.preventDefault();
    $('.nav-toggle-checkbox').prop('checked', false); // Close the mobile menu
    var $this = $(this);
    var isNavBarVisible = umunandi.screenSize.isAtLeast('sm') && umunandi.globals.isNavFixed;
    var scrollOpts = {
      duration: $this.data().scrollto,
      offset: ($this.data().scrolloffset || 0) + (isNavBarVisible ? -60 : 0)
    };
    $.scrollTo($this.data().scrollhref || $this.attr('href'), scrollOpts);
  });

  // JS media queries
  umunandi.screenSize = {
    sizes: {  // copied from src/core/less/variables.less
      xs: 480,
      sm: 768,
      md: 992,
      lg: 1200
    },
    getSize: function(size) {
      if (size in umunandi.screenSize.sizes) return umunandi.screenSize.sizes[size];
      if (isNaN(size)) return 1;
      return size;
    },
    isAtLeast: function(size) {
      return window.matchMedia('(min-width: ' + this.getSize(size) + 'px)').matches;
    },
    isUpTo: function(size) {
      return window.matchMedia('(max-width: ' + (this.getSize(size) - 1) + 'px)').matches;
    },
  };
  
  // Track navbar position to control floating/fixed state
  var $navBar = $('.js-main-nav');
  var $navBarRef = $('.js-main-nav-position-ref');
  var navBarRefTop;
  var onResize = function() { navBarRefTop = $navBarRef.offset().top; }
  onResize();

  $(window).on('resize orientationchange', $.debounce(100, onResize));
  $(document).scroll(function() {
    umunandi.globals.isNavFixed = $(this).scrollTop() > navBarRefTop;
    $navBar.toggleClass('fixed', umunandi.globals.isNavFixed); }
  );

  // TODO : IE image cover fit polyfill
  // https://medium.com/@primozcigler/neat-trick-for-css-object-fit-fallback-on-edge-and-other-browsers-afbc53bbb2c3

});
