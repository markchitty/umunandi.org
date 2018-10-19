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
  $atts = shortcode_atts(array(
    'class' => '',
    'valign' => 'center',
    'object_fit' => ''
  ), $atts);
  $atts['class'] .= ' valign-' . $atts['valign'] . ($atts['object_fit'] === 'cover' ? ' object-fit' : '');
  $html = str_get_html(do_shortcode($content));
  
  // Extract the image (or <figure>) out of $content
  $fig = $html->find('figure', 0);
  $img = $fig ? $fig : $html->find('img', 0);
  $atts['img_class'] = $img->class;
  $atts['img_tag'] = $img->outertext;
  $img->outertext = '';

  // Then extract and clean up the remaining text
  $text = array();
  foreach ($html->find('p') as $s) {
    $s = $s->innertext;
    if (!($s == '' || $s == ' ' || $s == '</p>')) $text[] = "<p>$s</p>";
  }
  $content = join("\n", $text);

  ob_start();
  include(locate_template('templates/shortcodes/img-section.php'));
  return ob_get_clean();
}
