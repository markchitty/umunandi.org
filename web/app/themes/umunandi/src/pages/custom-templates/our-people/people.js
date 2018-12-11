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

  function showPerson() {
    if (!location.hash) return;
    $carousel.carousel($(location.hash).index());
    if (!($modal.data('bs.modal') && $modal.data('bs.modal').isShown)) $modal.modal('show');
  }

  function clearPerson() {
    history.replaceState("", document.title, location.pathname + location.search);
  }

  $modal
    .on('shown.bs.modal', function() { $('.carousel-control.right').focus(); })
    .on('hidden.bs.modal', clearPerson);

  $(window)
    .on('resize orientationchange', modalInit)
    .on('hashchange', showPerson)
    .trigger('resize')
    .trigger('hashchange');

});
