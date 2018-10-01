/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * Google CDN, Latest jQuery
 * ======================================================================== */

// Set up Umunandi global to hang everything else off
var Umunandi = Umunandi || {};

(function($) {

  var SCRIPT_UTIL = {
    namespace : Umunandi,

    loadEvents : function() {
      SCRIPT_UTIL.fire('common');
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        SCRIPT_UTIL.fire(classnm);
      });
    },

    fire : function(funcname, args) {
      if (typeof SCRIPT_UTIL.namespace[funcname] === 'function')
        SCRIPT_UTIL.namespace[funcname](args);
    }
  }

  $(document).ready(SCRIPT_UTIL.loadEvents);

})(jQuery);
