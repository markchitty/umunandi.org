<?php

// [colgrid]
add_shortcode('colgrid', 'umunandi_shortcode_colgrid');
function umunandi_shortcode_colgrid($atts, $content) {
  $atts = shortcode_atts(array('class' => ''), $atts);
  $content = do_shortcode($content);
  ob_start();
  printf('<div class="col-grid %s">%s</div>', $atts['class'], $content);
  return ob_get_clean();
}

// [col]
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
