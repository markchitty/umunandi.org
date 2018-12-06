// Common scripts that run on all pages

umunandi.define('common', function() {

  // Normalise child heights, limited to < this elem's height
  // Use min-height to work out which item is tallest, then use height to fix the item
  // heights as .prev and .next are absolutely positioned and therefore need abs height.
  umunandi.normaliseHeights = function(elems) {
    $(elems).each(function() {
      var params = $(this).data('normaliseHeights');
      var selector = typeof params === 'object' ? params.elements : params;
      var items = $(selector, this);
      if (items.length === 0 || $(this).height() === 0) return; // Bail if no items or elem height = 0

      var maxH = 0;
      items.css({ 'min-height': '', 'height': '' }); // reset all heights
      items.each(function () { maxH = Math.max(maxH, $(this).outerHeight()); });
      if (maxH > 0) {
        items.css(params.minHeight ? 'min-height' : 'height', maxH + 'px');
        items.css(params.minHeight ? 'min-height' : 'height', $(this).innerHeight() + 'px');
      }
    });
  }

  // Show that a container is scrollable
  umunandi.isScrollable = function(selector) {
    $(selector).each(function() {
      $(this).toggleClass('can-scroll', this.scrollHeight - $(this).innerHeight() > 2);
    });
  }

  $(window).on('resize orientationchange', function () {
    umunandi.normaliseHeights('[data-normalise-heights]');
    umunandi.isScrollable('[data-is-scrollable]');
  }).resize();

  // TODO : IE image cover fit polyfill
  // https://medium.com/@primozcigler/neat-trick-for-css-object-fit-fallback-on-edge-and-other-browsers-afbc53bbb2c3

});
