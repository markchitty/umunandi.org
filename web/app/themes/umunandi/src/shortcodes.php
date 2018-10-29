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
  $html = str_get_html(do_shortcode($content));
  if ($img = $html->find('img', 0)) {
    $atts['img_src'] = $img->src;
    $img->parent()->outertext = '';
  }
  $content = $html->save();
  ob_start();
  include(locate_template('templates/shortcodes/key-point.php'));
  return ob_get_clean();
}

// [price_box]
add_shortcode('price_box', 'umunandi_shortcode_price_box');
function umunandi_shortcode_price_box($atts, $content) {
  $atts = shortcode_atts(array('class' => ''), $atts);
  ob_start();
  printf('<div class="price-box %s">%s</div>', $atts['class'], $content);
  return ob_get_clean();
}
add_shortcode('price', 'umunandi_shortcode_price');
function umunandi_shortcode_price($atts, $content) {
  $atts = shortcode_atts(array('currency' => '£', 'price' => 5, 'period' => 'month'), $atts);
  ob_start();
  include(locate_template('templates/shortcodes/price.php'));
  return ob_get_clean();
}

// [section]
add_shortcode('section', 'umunandi_shortcode_section');
function umunandi_shortcode_section($atts, $content) {
  $atts = shortcode_atts(array('class' => '', 'style' => '', 'header' => null), $atts);
  $html = str_get_html(do_shortcode($content));
  if ($img = $html->find('img.bg-img', 0)) {
    $img_src = $img->src;
    $img->outertext = '';
    $atts['style'] .= " background-image: url($img_src);";
  }
  $content = $html->save();

  ob_start();
  include(locate_template('templates/shortcodes/section.php'));
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
  $atts['class'] .= ' col-grid-' . $atts['valign'] . ($atts['object_fit'] === 'cover' ? ' object-fit' : '');
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
    $t = $s->innertext;
    if (!($t == '' || $t == ' ' || $t == '</p>')) $text[] = $s;
  }
  $content = join("\n", $text);

  ob_start();
  include(locate_template('templates/shortcodes/img-section.php'));
  return ob_get_clean();
}

// [coffee_sketch]
add_shortcode('coffee_sketch', 'umunandi_shortcode_coffee_sketch');
function umunandi_shortcode_coffee_sketch($atts, $content) {
  ob_start();
  include(locate_template('templates/shortcodes/coffee-sketch.php'));
  return ob_get_clean();
}

// [colgrid]
add_shortcode('colgrid', 'umunandi_shortcode_colgrid');
function umunandi_shortcode_colgrid($atts, $content) {
  $atts = shortcode_atts(array('class' => ''), $atts);
  $content = do_shortcode($content);
  ob_start();
  printf('<div class="col-grid %s">%s</div>', $atts['class'], $content);
  return ob_get_clean();
}
add_shortcode('col', 'umunandi_shortcode_col');
function umunandi_shortcode_col($atts, $content) {
  $atts = shortcode_atts(array('class' => '', 'container-class' => ''), $atts);
  $content = do_shortcode($content);
  if ($atts['container-class']) {
    $content = sprintf('<div class="%s">%s</div>', $atts['container-class'], $content);
  }
  ob_start();
  printf('<div class="col %s">%s</div>', $atts['class'], $content);
  return ob_get_clean();
}
