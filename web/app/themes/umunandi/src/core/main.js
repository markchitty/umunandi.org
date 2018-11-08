/* ========================================================================
 * umunandi.org main.js - Entry point script and module manager.
 *
 * We create a global 'umunandi' object which provides a namespace for all
 * other script modules hang off. Modules are imported using the
 * umunandi.import(pagename, func) method. This adds them to the umunandi
 * namespace and associates them with the name of a specific site page.
 * 
 * When a page loads, loadEvents() calls all modules that are registered
 * with a module name that matches any class in the <body> tag (dashes in
 * class names are replaced by underscores). Based on http://goo.gl/EUTi53.
 * 
 * Grunt is responsible for concat'ing all the scripts in /src.
 * 
 * Example
 * -------
 * - In home.js
 *   umunandi.import('home', function() { useful js stuff });
 * 
 * - In animations.js
 *   umunandi.import('home', function() { cool animations });
 * 
 * - In home.php
 *   <body class="page blue home"> ... </body>
 * 
 * When home.php loads, the script will run any functions with a module id
 * of 'page', 'blue' or 'home'. This means the 'home' modules imported in 
 * home.js and animations.js will both be called.
 * ======================================================================== */

var Umunandi = function() {
  this.globals = {};
};

Umunandi.prototype.import = function(moduleId, func) {
  if (this.hasOwnProperty(moduleId)) {
    var prevFunc = this[moduleId];
    this[moduleId] = function() {
      prevFunc();
      func();
    };
  }
  else this[moduleId] = func;
}

Umunandi.prototype.loadEvents = function() {
  this.run('common');
  var pageClasses = document.body.className.replace(/-/g, '_').split(/\s+/);
  pageClasses.forEach(function(className) {
    this.run(className);
  }.bind(this));
}

Umunandi.prototype.run = function(moduleId) {
  if (typeof this[moduleId] === 'function') this[moduleId]();
};

var umunandi = new Umunandi();

(function($) { $(document).ready(umunandi.loadEvents.bind(umunandi)); })(jQuery);
