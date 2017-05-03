<?php
// Prepend base template path so base.php can live at templates/layout/base.php
function umunandi_roots_template_path($templates) {
  return array_map(function($t) { return 'templates/layout/' . $t; }, $templates);
}
add_filter('roots_wrap_base', 'umunandi_roots_template_path');

// Image tag without dimensions
function wp_get_image_tag($attach_id, $size, $icon, $alt = '') {
  if ($src = wp_get_attachment_image_src($attach_id, $size, $icon)) {
    return sprintf('<img src="%s" alt="%s" />', $src[0], $alt);
  }
}

// Use featured image as css background-image
// Returns 'style="background-image: url(path/to/image);"' if post featured image is set
function umunandi_featured_image_bg_style($isRandom = false) {
  $bg_style = 'style="background-image: url(%s);"';
  if ($isRandom) {
    return sprintf($bg_style, 'http://lorempixel.com/900/500/people');
  }
  if ($bg_img = (wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'))) {
    return sprintf($bg_style, wp_make_link_relative($bg_img[0]));
  }
}

// Force 404 on hidden pages
function umunandi_force_404() {
  global $post;
  if ($post->post_parent && get_post_meta($post->post_parent, 'hide_child_pages')) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
  }
}
add_action('wp', 'umunandi_force_404');

function umunandi_split_sentence($sentence, $position = null) {
  $words = explode(" ", $sentence);
  $position = $position ?: count($words)/2;
  $start = array_slice($words, 0, $position);
  $end = array_slice($words, -($position + 1));
  return [ join(' ', $start), join(' ', $end) ];
}
