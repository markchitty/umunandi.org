<?php
// [section]
add_shortcode('section', 'umunandi_shortcode_section');
function umunandi_shortcode_section($atts, $content) {
  $atts = shortcode_atts(array('class' => '', 'style' => '', 'header' => null), $atts);
  if ($content !== '') {
    $html = str_get_html(do_shortcode($content));
    if ($html && $img = $html->find('img.bg-img', 0)) {
      $img_src = $img->src;
      $img->outertext = '';
      $atts['style'] .= " background-image: url($img_src);";
    }
    $content = $html->save();
  }

  ob_start();
  include 'section.php';
  return ob_get_clean();
}
