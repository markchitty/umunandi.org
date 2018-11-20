<?php
/** Staging */
define('SAVEQUERIES', false);
define('SCRIPT_DEBUG', false);
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);      // Log debug messages in /wp-content/debug.log
define('WP_DEBUG_DISPLAY', false); // Don't show debug messages in the html

/** Disable all file modifications including updates and update notifications */
define('DISALLOW_FILE_MODS', true);

ini_set('display_errors', 0);
