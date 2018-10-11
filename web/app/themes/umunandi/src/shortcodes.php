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

// [carousel]
add_shortcode('kids_carousel', 'umunandi_shortcode_kids_carousel');
function umunandi_shortcode_kids_carousel($atts) {
  ob_start();
  get_template_part('templates/shortcodes/kids-carousel');
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

// [img_section]
add_shortcode('img_section', 'umunandi_shortcode_img_section');
function umunandi_shortcode_img_section($atts, $content) {
  $html = str_get_html($content);

  // Extract the image out of $content
  $img = $html->find('img', 0);
  $img_tag = $img->outertext;
  $img->outertext = '';

  // Then build an array of all the remaining text
  foreach ($html->find('p') as $s) {
    $s = $s->innertext;
    if (!($s == '' || $s == ' ' || $s == '</p>')) $text[] = "<p>$s</p>";
  }

  // And then recombine it into the DOM structure we want
  $content = sprintf("%s\n<div>%s</div>", $img_tag, join("\n", $text));

  ob_start();
  include(locate_template('templates/shortcodes/img-section.php'));
  return ob_get_clean();
}
