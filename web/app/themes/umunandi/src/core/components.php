<?php
// Load shortcodes
$shortcode_files = dirname(__DIR__) . '/components/*/shortcode.php';
foreach (glob($shortcode_files) as $file) require_once $file;

// Load widgets
$widget_files = dirname(__DIR__) . '/components/*/widget.php';
foreach (glob($widget_files) as $file) require_once $file;

// Enable shortcodes in text widget
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

// Footer sidebars
add_action('widgets_init', 'umunandi_sidebars');
function umunandi_sidebars() {
  register_sidebar(array(
    'name'          => 'Footer nav',
    'id'            => 'footer-nav',
    'before_widget' => '<div class="%1$s %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h6>',
    'after_title'   => '</h6>',
  ));
  register_sidebar(array(
    'name'          => 'Footer contact',
    'id'            => 'footer-contact',
    'before_widget' => '<div class="%1$s %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h6>',
    'after_title'   => '</h6>',
  ));
}
