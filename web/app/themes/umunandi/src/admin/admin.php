<?php
require_once 'editor.php';

// Advanced Custom Forms styles
add_action('acf/input/admin_head', 'umunandi_acf_admin_head');
function umunandi_acf_admin_head() {
  ?>
  <style type="text/css">
    .acf_postbox.no_box > .hndle { display: none; }
    .acf_postbox .field textarea { min-height: 0; }
  </style>
  <?php
}

// Admin favicon
add_action('login_head', 'umunandi_add_favicon');
add_action('admin_head', 'umunandi_add_favicon');
function umunandi_add_favicon() {
 	$favicon_url = get_stylesheet_directory_uri() . '/assets/img/favicon/admin-favicon.png';
	printf('<link rel="shortcut icon" href="%s">', $favicon_url);
}

// Date column format
add_filter('post_date_column_time' , 'umunandi_post_date_column_time', 10, 2);
function umunandi_post_date_column_time($h_time, $post) {
  return get_post_time('j M Y', false, $post);
}

// Admin custom styles
add_action('admin_enqueue_scripts', 'umunandi_admin_scripts');
function umunandi_admin_scripts() {
  wp_enqueue_style('umunandi-admin-css', get_template_directory_uri() . '/assets/css/admin.css', []);
}

// Default metabox visibility - hides admin page elements for new users
add_filter('default_hidden_meta_boxes', 'umunandi_default_hidden_screen_options', 10, 2);
function umunandi_default_hidden_screen_options($hidden, $screen) {
  $hide_these = array(
    'pageparentdiv',
    'categorydiv',
    'tagsdiv',
    'postcustom',
    'commentstatusdiv',
    'commentsdiv',
    'slugdiv',
    'authordiv',
    'trackbacksdiv',
  );
  return array_merge($hidden, $hide_these);
}

// Make internal links relative in posts/pages
add_filter('post_link', 'internal_link_to_relative', 10, 3);
add_filter('page_link', 'internal_link_to_relative', 10, 3);
function internal_link_to_relative($url, $post) {
  $is_page_or_post = is_int($post) || (is_object($post) && $post->post_type === 'post');
  return $is_page_or_post ? wp_make_link_relative($url) : $url;
}

// Custom page attribute field
add_action('page_attributes_misc_attributes', 'umunandi_page_attrs');
function umunandi_page_attrs($post) {
  $page_class  = get_post_meta($post->ID, 'umunandi_page_class', true);
  $page_bg_pos = get_post_meta($post->ID, 'umunandi_page_bg_pos', true);
  wp_nonce_field('umunandi_meta_box_nonce', 'meta_box_nonce');
  ?>
  <p class="post-attributes-label-wrapper">
    <label class="post-attributes-label" for="umunandi_page_class">Class</label>
  </p>
  <input type="text" name="umunandi_page_class" id="umunandi_page_class" value="<?= $page_class ?>">
  <p class="post-attributes-label-wrapper">
    <label class="post-attributes-label" for="umunandi_page_bg_pos">Featured image position</label>
  </p>
  <input type="text" name="umunandi_page_bg_pos" id="umunandi_page_bg_pos" value="<?= $page_bg_pos ?>">
  <?php
}
add_action('save_post', 'umunandi_meta_box_save');
function umunandi_meta_box_save($post_id) {
  // Bail if auto save, user can't edit this post, or invalid/missing nonce
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;
  if (!isset($_POST['meta_box_nonce']) ||
      !wp_verify_nonce($_POST['meta_box_nonce'], 'umunandi_meta_box_nonce')) return;
  if (isset($_POST['umunandi_page_class']))
      update_post_meta($post_id, 'umunandi_page_class', esc_attr($_POST['umunandi_page_class']));
  if (isset($_POST['umunandi_page_bg_pos']))
      update_post_meta($post_id, 'umunandi_page_bg_pos', esc_attr($_POST['umunandi_page_bg_pos']));
}
