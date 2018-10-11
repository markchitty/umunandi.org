<?php
/**
 * Roots includes
 */
require_once locate_template('/lib/roots/utils.php');           // Utility functions
require_once locate_template('/lib/roots/init.php');            // Initial theme setup and constants
// require_once locate_template('/lib/roots/wrapper.php');         // Theme wrapper class
require_once locate_template('/lib/roots/sidebar.php');         // Sidebar class
require_once locate_template('/lib/roots/config.php');          // Configuration
require_once locate_template('/lib/roots/activation.php');      // Theme activation
require_once locate_template('/lib/roots/titles.php');          // Page titles
require_once locate_template('/lib/roots/cleanup.php');         // Cleanup
require_once locate_template('/lib/roots/nav.php');             // Custom nav modifications
require_once locate_template('/lib/roots/gallery.php');         // Custom [gallery] modifications
require_once locate_template('/lib/roots/comments.php');        // Custom comments modifications
require_once locate_template('/lib/roots/relative-urls.php');   // Root relative URLs
require_once locate_template('/lib/roots/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/roots/scripts.php');         // Scripts and stylesheets
require_once locate_template('/lib/roots/custom.php');          // Custom functions

// Umunandi theme functions
require_once locate_template('/lib/simple_html_dom.php');
require_once locate_template('/src/admin.php');
require_once locate_template('/src/nav.php');
require_once locate_template('/src/content.php');
require_once locate_template('/src/shortcodes.php');
require_once locate_template('/src/scripts_styles.php');
