<?php

// [loader]
add_shortcode('loader', 'umunandi_shortcode_loader');
function umunandi_shortcode_loader($atts, $content) {
  $atts = shortcode_atts(array('class' => '', 'type' => 'spinner'), $atts);
  $atts['class'] .= ' ' . $atts['type'];
  ob_start();
  printf('<span class="loader %s">%s</span>', $atts['class'], str_repeat('<span></span>', 12));
  return ob_get_clean();
}
