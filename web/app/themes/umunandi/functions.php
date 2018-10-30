<?php
/**
 * Roots includes
 */
require_once 'vendor/roots/utils.php';           // Utility functions
require_once 'vendor/roots/init.php';            // Initial theme setup and constants
// require_once 'vendor/roots/wrapper.php';         // Theme wrapper class
require_once 'vendor/roots/sidebar.php';         // Sidebar class
require_once 'vendor/roots/config.php';          // Configuration
require_once 'vendor/roots/activation.php';      // Theme activation
require_once 'vendor/roots/titles.php';          // Page titles
require_once 'vendor/roots/cleanup.php';         // Cleanup
require_once 'vendor/roots/nav.php';             // Custom nav modifications
require_once 'vendor/roots/gallery.php';         // Custom [gallery] modifications
require_once 'vendor/roots/comments.php';        // Custom comments modifications
require_once 'vendor/roots/relative-urls.php';   // Root relative URLs
require_once 'vendor/roots/widgets.php';         // Sidebars and widgets
require_once 'vendor/roots/scripts.php';         // Scripts and stylesheets

// Other PHP libraries
require_once 'vendor/simple_html_dom.php';

// Umunandi theme functions
require_once 'src/admin/admin.php';
require_once 'src/core/content.php';
require_once 'src/core/scripts-styles.php';
require_once 'src/core/shortcodes.php';
require_once 'src/core/template-loader.php';
require_once 'src/layout/nav/nav-walker.php';
