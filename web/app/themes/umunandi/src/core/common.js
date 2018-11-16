// Common scripts that run on all pages

umunandi.define('common', function() {

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
  // Autoresize textareas to fit content
  $('textarea').each(function () {
    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px; overflow-y:hidden;');
  }).on('input', function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
  });

  // TODO : IE image cover fit polyfill
  // https://medium.com/@primozcigler/neat-trick-for-css-object-fit-fallback-on-edge-and-other-browsers-afbc53bbb2c3

});
