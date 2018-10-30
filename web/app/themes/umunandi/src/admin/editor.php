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

// Add Formats dropdown to TinyMCE editor (row 2), for custom styles
add_filter('mce_buttons_2', 'add_mce_formats');
function add_mce_formats($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}
add_filter('tiny_mce_before_init', 'mce_styles');
function mce_styles($init_array) {
  $style_formats = array(
    array('title' => 'intro',          'block' => 'p',     'classes' => 'intro'),
    array('title' => 'small',          'block' => 'p',     'classes' => 'smaller-text'),
    array('title' => 'smallest',       'block' => 'p',     'classes' => 'smallest-text'),
    array('title' => 'big',            'block' => 'p',     'classes' => 'bigger-text'),
    array('title' => 'biggest',        'block' => 'p',     'classes' => 'biggest-text'),
    array('title' => 'div',            'block' => 'div',   'classes' => 'div', 'wrapper' => true),
    array('title' => 'round-img',      'block' => 'div',   'classes' => 'round-img'),
    array('title' => 'sketch-circle',  'block' => 'div',   'classes' => 'sketch-circle'),
    array('title' => 'special-block',  'block' => 'p',     'classes' => 'special'),
    array('title' => 'special-inline', 'inline' => 'span', 'classes' => 'special'),
  );
  $init_array['style_formats'] = json_encode($style_formats);
  $init_array['cache_suffix'] = 'v=' . date('Ymd-His');  // Uncomment to refresh editor-styles.css 
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
