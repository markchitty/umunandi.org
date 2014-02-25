<?php
// ===================================================
// Load database info and local development parameters
// ===================================================
if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
	define( 'WP_LOCAL_DEV', true );
	include( dirname( __FILE__ ) . '/local-config.php' );
} else {
	define( 'WP_LOCAL_DEV', false );
	define( 'DB_NAME', 'myfriend_wp_umunandi' );
	define( 'DB_USER', 'myfriend_wpuser' );
	define( 'DB_PASSWORD', 'w]qr5Ia)B1Kt' );
	define( 'DB_HOST', '127.0.0.1' ); // Probably 'localhost'
}

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define('AUTH_KEY',         '|%tTe[-Xti?GLinoWEl.bO3Tef)zYs-!]|OT(JO!|TmLKu60F__q>M]rY$7H,}%+');
define('SECURE_AUTH_KEY',  'e^#G%je{C*@d=a-fetL!-;Lu-RzOhrp_DLu=tJx<V@&ut(S&XZ}BnSL-V^.lO?{J');
define('LOGGED_IN_KEY',    '-vA1i3pytm-+]9JmEut^5]pxoX-[H]s8^PmhPZM=T2z20oJmHv>lnJ4LKj`9Vw:A');
define('NONCE_KEY',        'W1C<Xv:WssSni1C|H{B<QF+<vJyQL-lv|*-smTXX$v)m6Coiy5wT1wv!~H5;-/s&');
define('AUTH_SALT',        'GGp+Ld-%C1t!!N5vYjiLzkVj%4!%:VMsG+x@Tqrq{$yxaMa2|yU+nV21i_qyrxmD');
define('SECURE_AUTH_SALT', 'Bw~SnGs7:,$qG`Wiq&(su=crkeMy+U<Cohne.fu;_V3!gY2EBRB`M8l_~m<U}Twe');
define('LOGGED_IN_SALT',   '|vct901v)ib|bM`HxT@3sQCfzEh!#e*Lnm?yN8qQlM#rUsxdGl1hRxP%<$ab/K[$');
define('NONCE_SALT',       'SPA+vRV;P{o}OrUA>:pBncGGVb=i-ylouQ<&=#%xN%QlCJ.Fv^iTqouyl%iWYWt:');

// ==============================================================
// Table prefix
// Change this if you have multiple installs in the same database
// ==============================================================
$table_prefix  = 'wp_';

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', '' );

// ===========
// Hide errors
// ===========
ini_set( 'display_errors', 0 );
define( 'WP_DEBUG_DISPLAY', false );

// =================================================================
// Debug mode
// Debugging? Enable these. Can also enable them in local-config.php
// =================================================================
// define( 'SAVEQUERIES', true );
// define( 'WP_DEBUG', true );

// ======================================
// Load a Memcached config if we have one
// ======================================
if ( file_exists( dirname( __FILE__ ) . '/memcached.php' ) )
	$memcached_servers = include( dirname( __FILE__ ) . '/memcached.php' );

// ===========================================================================================
// This can be used to programatically set the stage when deploying (e.g. production, staging)
// ===========================================================================================
// define( 'WP_STAGE', '%%WP_STAGE%%' );
// define( 'STAGING_DOMAIN', '%%WP_STAGING_DOMAIN%%' ); // Does magic in WP Stack to handle staging domain rewriting

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );
