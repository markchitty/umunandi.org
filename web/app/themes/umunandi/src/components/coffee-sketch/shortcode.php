<?php

// [coffee_sketch]
add_shortcode('coffee_sketch', 'umunandi_shortcode_coffee_sketch');
function umunandi_shortcode_coffee_sketch($atts, $content) {
  ob_start();
  include 'coffee-sketch.php';
  return ob_get_clean();
}
