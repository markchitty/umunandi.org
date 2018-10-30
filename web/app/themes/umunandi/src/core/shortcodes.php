<?php
require_once dirname(__DIR__) . '/components/carousel/shortcode.php';
require_once dirname(__DIR__) . '/components/coffee-sketch/shortcode.php';
require_once dirname(__DIR__) . '/components/colgrid/shortcode.php';
require_once dirname(__DIR__) . '/components/img-section/shortcode.php';
require_once dirname(__DIR__) . '/components/key-point/shortcode.php';
require_once dirname(__DIR__) . '/components/mailchimp/shortcode.php';
require_once dirname(__DIR__) . '/components/price-box/shortcode.php';
require_once dirname(__DIR__) . '/components/section/shortcode.php';
require_once dirname(__DIR__) . '/components/share-icons/shortcode.php';

// Enable shortcodes in text widget
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
