<?php

// [price_box]
add_shortcode('price_box', 'umunandi_shortcode_price_box');
function umunandi_shortcode_price_box($atts, $content) {
  $defaults = array(
    'class' => '',
    'title' => 'a child',
    'currency' => '£',
    'price' => 5,
    'period' => 'month',
  );
  $atts = shortcode_atts($defaults, $atts);
  $html = str_get_html(do_shortcode($content));
  
  // Extract all images out of $content
  $imgs = array();
  foreach ($html->find('img') as $img) {
    $imgs[] = array('class' => $img->class, 'tag' => $img->outertext);
    $img->outertext = '';
  }
  $atts['imgs'] = $imgs;
  $content = $html->save();

  ob_start();
  include 'price-box.php';
  return ob_get_clean();
}
