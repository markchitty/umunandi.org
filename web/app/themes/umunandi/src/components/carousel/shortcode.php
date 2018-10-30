<?php

// [carousel] shortcode
add_shortcode('kids_carousel', 'umunandi_shortcode_kids_carousel');
function umunandi_shortcode_kids_carousel($atts) {
  ob_start();
  include 'kids-carousel.php';
  return ob_get_clean();
}
