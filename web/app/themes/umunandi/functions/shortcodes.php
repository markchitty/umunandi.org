<?php
// Enable shortcodes in text widget
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

// Move bloody wpautop filter to AFTER shortcode is processed
// remove_filter('the_content', 'wpautop');
// add_filter('the_content', 'wpautop', 99);
// add_filter('the_content', 'shortcode_unautop', 100);

// [mailchimp_subscribe]
// MailChimp email sign up form
// Based on form generated at MailChimp > Lists > Signup forms > Classic
add_shortcode('mailchimp_subscribe', 'umunandi_shortcode_mailchimp_subscribe');
function umunandi_shortcode_mailchimp_subscribe($atts) {
  ob_start();
  get_template_part('templates/shortcodes/mailchimp');
  return ob_get_clean();
}

// [share_icons]
add_shortcode('share_icons', 'umunandi_shortcode_share_icons');
function umunandi_shortcode_share_icons($atts) {
  ob_start();
  get_template_part('templates/shortcodes/share-icons');
  return ob_get_clean();
}

// [key_point]
add_shortcode('key_point', 'umunandi_shortcode_key_point');
function umunandi_shortcode_key_point($atts, $content) {
  ob_start();

  // Using include() rather than get_template_part()
  // keeps the shortcode params ($atts, $content) in scope
  include(locate_template('templates/shortcodes/key-point.php'));
  return ob_get_clean();
}
