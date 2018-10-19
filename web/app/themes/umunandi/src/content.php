<?php
define('IMG_ASSET_PATH', '/app/themes/umunandi/assets/img/');
// define('GOOGLE_ANALYTICS_ID', '');

// Get template type - list copied from src/wp-includes/template-loader.php
function umunandi_get_template_type() {
  $template_type = 'index';
  if     (is_embed()            ) : $template_type = 'embed';
  elseif (is_404()              ) : $template_type = '404';
  elseif (is_search()           ) : $template_type = 'search';
  elseif (is_front_page()       ) : $template_type = 'home';          // prev 'front-page'
  elseif (is_home()             ) : $template_type = 'blog';          // prev 'home'
  elseif (is_post_type_archive()) : $template_type = 'archive';
  elseif (is_tax()              ) : $template_type = 'taxonomy';
  elseif (is_attachment()       ) : $template_type = 'attachment';
  elseif (is_page()             ) : $template_type = 'default-page';  // prev 'page'
  elseif (is_singular()         ) : $template_type = 'singular';
  elseif (is_category()         ) : $template_type = 'category';
  elseif (is_tag()              ) : $template_type = 'tag';
  elseif (is_author()           ) : $template_type = 'author';
  elseif (is_date()             ) : $template_type = 'date';
  elseif (is_archive()          ) : $template_type = 'archive';
  endif;
  return $template_type;
}

function umunandi_get_image_src($attach_id, $size) {
  return ($src = wp_get_attachment_image_src($attach_id, $size, false)) ? $src[0] : '';
}

// Use featured image as css background-image
// Returns 'background-image: url(path/to/image);' if post featured image is set
function umunandi_featured_image_bg_style($isRandom = false) {
  $bg_img_style = 'background-image: url(%s);';
  $bg_pos_style = 'background-position: %s;';
  global $post;

  if ($isRandom) {
    $bg_img = 'http://lorempixel.com/900/500/people';
  }
  elseif ($bg_img = (wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'))) {
    $bg_img = wp_make_link_relative($bg_img[0]);
  }
  else return;

  $bg_style = sprintf($bg_img_style, $bg_img);

  if ($bg_pos = get_post_meta($post->ID, 'umunandi_page_bg_pos', true)) {
    $bg_style .= sprintf($bg_pos_style, $bg_pos);
  }

  return $bg_style;
}

// Add custom page class into body tag classes
add_filter('body_class', 'umunandi_body_class');
function umunandi_body_class($classes) {
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
