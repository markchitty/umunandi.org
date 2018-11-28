<?php
define('IMG_ASSET_PATH', '/app/themes/umunandi/assets/img/');

function umunandi_get_image_src($attach_id, $size) {
  return ($src = wp_get_attachment_image_src($attach_id, $size, false)) ? $src[0] : '';
}

// Use featured image as css background-image
// Returns 'background-image: url(path/to/image);' if post featured image is set
function umunandi_featured_image_bg_style($skipRandom = false) {
  global $post;
  $bg_img_style = 'background-image: url(%s);';
  $bg_pos_style = 'background-position: %s;';
  $random_img   = $skipRandom ? '' : '//source.unsplash.com/1200x675/?people';

  $bg_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
  $bg_img = $bg_img ? wp_make_link_relative($bg_img[0]) : $random_img;
  $bg_style = sprintf($bg_img_style, $bg_img);
  $bg_pos = get_post_meta($post->ID, 'umunandi_page_bg_pos', true);
  if ($bg_pos) $bg_style .= sprintf($bg_pos_style, $bg_pos);
  return $bg_style;
}

// Add custom page class into body tag classes
// and remove the bazillion 'page-template*' classes
add_filter('body_class', 'umunandi_body_class', 99);
function umunandi_body_class($classes) {
  $classes = array_filter($classes, function($cls) { return strpos($cls, 'page-template') !== 0; });
  global $post;
  $classes[] = get_post_meta($post->ID, 'umunandi_page_class', true);
  return $classes;
}

// Force 404 on hidden pages
add_action('wp', 'umunandi_force_404');
function umunandi_force_404() {
  global $post;
  if ($post->post_parent && get_post_meta($post->post_parent, 'hide_child_pages')) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
  }
}

function umunandi_split_sentence($sentence, $line_count = 2) {
  $words = explode(" ", $sentence);
  $av_word_length = strlen($sentence) / count($words);
  $max_line_length = (strlen($sentence) / $line_count) + $av_word_length / 2;
  return explode("\n", wordwrap($sentence, $max_line_length));
}

// Add featured image sizes
add_image_size('small', 300, 300, true); // width, height, crop
add_filter('image_size_names_choose', 'umunandi_custom_img_sizes');
function umunandi_custom_img_sizes($sizes) {
  return array_merge($sizes, array('small' => 'Small'));
}

// Remove 'Private:' and 'Protected:' from private/protected pages and posts
add_filter('private_title_format', 'simple_title_format');
add_filter('protected_title_format', 'simple_title_format');
function simple_title_format($content) { return '%s'; }

function svg_icon($name) {
  return file_get_contents(locate_template("src/components/icons/$name.svg"));
}
