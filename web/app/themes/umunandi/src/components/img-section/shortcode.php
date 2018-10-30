<?php

// [img_section] shortcode
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
  include 'img-section.php';
  return ob_get_clean();
}
