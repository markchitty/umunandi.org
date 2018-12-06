// People scripts
umunandi.define('people', function () {

  var $modal    = $('#people-modal');
  var $carousel = $('#people-carousel');

  // Initialise the modal: show it (off-screen), normalise carousel heights,
  // set scrollable class, then hide it again.
  function modalInit() {
    $modal.addClass('modal-init');
    umunandi.normaliseHeights($carousel.find('.carousel-inner'));
    $curItem = $carousel.find('.item.active');
    $carousel.find('.item').removeClass('active').each(function() {
      $(this).addClass('active');
      umunandi.isScrollable($(this).find('[data-is-scrollable]'));
      $(this).removeClass('active');
    });
    $curItem.addClass('active');
    $modal.removeClass('modal-init');
  }

  function getIndexById($items, id) {
    return $items.map(function (idx) { if (this.id === id) return idx; }).get(0);
  }

  function onModalShow(e) {
    if (e.relatedTarget) {
      var slideIndex = getIndexById($carousel.find('.item'), e.relatedTarget.dataset.carouselId);
      $carousel.carousel(slideIndex);
    }
  }

  function onModalShown() {
    $carousel.find('.carousel-control.right').focus();
  }

  $modal
    .on('show.bs.modal', onModalShow)
    .on('shown.bs.modal', onModalShown);

  $(window).on('resize orientationchange', function () { modalInit(); }).resize();

});
