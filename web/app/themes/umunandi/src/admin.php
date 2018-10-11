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
add_action('page_attributes_misc_attributes', 'umunandi_page_class');
function umunandi_page_class($post) {
  $page_class = get_post_meta($post->ID, 'umunandi_page_class', true);
  wp_nonce_field('umunandi_meta_box_nonce', 'meta_box_nonce');
  ?>
  <p class="post-attributes-label-wrapper">
    <label class="post-attributes-label" for="umunandi_page_class">Class</label>
  </p>
  <input type="text" name="umunandi_page_class" id="umunandi_page_class" value="<?= $page_class ?>">
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
}

// Add Formats dropdown to TinyMCE editor (row 2), for custom styles
// add_filter('mce_buttons_2', 'add_mce_formats');
// function add_mce_formats($buttons) {
//   array_unshift($buttons, 'styleselect');
//   return $buttons;
// }
// // Custom TinyMCE styles
// add_filter( 'tiny_mce_before_init', 'mce_styles');
// function mce_styles( $init_array ) {
//   $style_formats = array(
//     array(
//       'title'   => 'Parallax section',
//       'block'   => 'div',
//       'classes' => 'parallax-section',
//       'wrapper' => true
//     )
//   );  
//   $init_array['style_formats'] = json_encode($style_formats);
//   return $init_array;
// }


// WP only makes excerpts available on Posts. This turns on excerpts for Pages too.
// function umunandi_add_excerpts_to_pages() {
//   add_post_type_support('page', 'excerpt');
// }
// add_action('init', 'umunandi_add_excerpts_to_pages');
