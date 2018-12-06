/* ========================================================================
 * umunandi.org main.js - Entry point script and module manager.
 *
 * A global 'umunandi' object provides a namespace for all other script
 * modules hang off. Modules are defined using the method
 * umunandi.define(pagename, [priority], func). This adds them to the
 * umunandi namespace and associates them with the name of a specific page.
 * 
 * When a page loads, load() calls all modules that are registered
 * with a module name that matches any class in the <body> tag (dashes in
 * class names are replaced by underscores). Based on http://goo.gl/EUTi53.
 * 
 * Modules are loaded in order of ascending priority. Default priority = 10.
 * e.g. a module with priority 2 is loaded before a module of priority 1000.
 * 
 * Grunt is responsible for concat'ing all the scripts in /src.
 * 
 * Example
 * -------
 * - In home.js
 *   umunandi.define('home', function() { useful js stuff });
 * 
 * - In anims.js
 *   umunandi.define('home', 5, function() { cool animations });
 * 
 * - In home.php
 *   <body class="page blue home"> ... </body>
 * 
 * When home.php loads, the script will run any functions with a module id
 * of 'page', 'blue' or 'home'. This means the 'home' modules defined in 
 * home.js and anims.js will both be loaded - anims.js will load first.
 * ======================================================================== */

var Umunandi = function() {
  this.globals = {};
  this.pageScripts = {};
};

Umunandi.prototype.define = function(moduleId, priority, func) {
  func = typeof priority === 'function' ? priority : func;
  priority = isNaN(priority) ? 10 : priority;
  this.pageScripts[moduleId] = this.pageScripts[moduleId] || [];
  this.pageScripts[moduleId].push({ priority: priority, func: func });
  this.pageScripts[moduleId].sort(function(a, b) { return a.priority - b.priority; });
}

Umunandi.prototype.load = function() {
  this.run('common');
  var pageClasses = document.body.className.replace(/-/g, '_').split(/\s+/);
  pageClasses.forEach(function(className) {
    this.run(className);
  }.bind(this));
}

Umunandi.prototype.run = function(moduleId) {
  if (!Array.isArray(this.pageScripts[moduleId])) return;
  // console.log('Running modules', moduleId, this.pageScripts[moduleId]);
  this.pageScripts[moduleId].forEach(function(module) { module.func(); });
};

var umunandi = new Umunandi();

(function($) { $(document).ready(umunandi.load.bind(umunandi)); })(jQuery);
