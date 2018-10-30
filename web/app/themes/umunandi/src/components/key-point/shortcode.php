<?php

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
  include 'key-point.php';
  return ob_get_clean();
}
