<?php
// Force text edit mode on certain pages
add_filter('user_can_richedit', 'disable_rich_editing');
function disable_rich_editing($default) {
  $disabled_page_slugs = [];
  global $post;
  foreach ($disabled_page_slugs as $slug) {
    if ($post->ID == get_page_by_title($slug)->ID) return false;
  }
  return $default;
}

// Debug util
function ulog() {
  $formatted_args = array_map(function($arg) { return print_r($arg, true); }, func_get_args());
  error_log(join(', ', $formatted_args));
}

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

// Add Formats dropdown to TinyMCE editor (row 2), for custom styles
add_filter('mce_buttons_2', 'add_mce_formats');
function add_mce_formats($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}
add_filter('tiny_mce_before_init', 'mce_styles');
function mce_styles($init_array) {
  $style_formats = array(
    array('title' => 'intro', 'block' => 'p', 'classes' => 'intro')
  );
  $init_array['style_formats'] = json_encode($style_formats);
  // $init_array['cache_suffix'] = 'v=' . date('Ymd-His');  // Uncomment to refresh editor-styles.css 
  return $init_array;
}

// WP only makes excerpts available on Posts. This turns on excerpts for Pages too.
// function umunandi_add_excerpts_to_pages() {
//   add_post_type_support('page', 'excerpt');
// }
// add_action('init', 'umunandi_add_excerpts_to_pages');


// Disable emoji images and use native emojis instead
// https://goedemorgenwp.com/do-you-really-need-emoji-on-your-wordpress-site/
add_action('init', 'umunandi_disable_emojis');
function umunandi_disable_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'umunandi_disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'umunandi_disable_emojis_remove_dns_prefetch', 10, 2);
}

function umunandi_disable_emojis_tinymce($plugins) {
  return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : array();
}

function umunandi_disable_emojis_remove_dns_prefetch($urls, $relation_type) {
	if ('dns-prefetch' == $relation_type) {
		$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
		foreach ($urls as $key => $url) {
			if (strpos($url, $emoji_svg_url_bit) !== false) unset($urls[$key]);
		}
	}
	return $urls;
}
