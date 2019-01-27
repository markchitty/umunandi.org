<?php
/*
Plugin Name: OVC
Plugin URI: http://umunandi.org/blog/ovc-wordpress-plugin
Description: Custom post type for OVCs = Orphans & Vulnerable Children
Version: 0.1
Author: Mark Chitty
Author URI: http://you-i.com/mark
License: GPLv2
*/

class OVC {

  function __construct() {

    // Head shot image size - 300 x 300 cropped
    add_image_size('square-300', 300, 300, true);

    // ======== OVC Custom Post Type =======
    // http://www.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/
    add_action('init', 'ovc_custom_post');
    function ovc_custom_post() {
      $labels = array(
        'name'               => _x('OVCs', 'post type general name'),
        'singular_name'      => _x('OVC', 'post type singular name'),
        'add_new'            => _x('Add New', 'thing'),
        'add_new_item'       => __('Add New OVC'),
        'edit_item'          => __('Edit OVC'),
        'new_item'           => __('New OVC'),
        'all_items'          => __('All OVCs'),
        'view_item'          => __('View OVC'),
        'search_items'       => __('Search OVCs'),
        'not_found'          => __('No OVCs found'),
        'not_found_in_trash' => __('No OVCs found in trash'),
        'parent_item_colon'  => '',
        'menu_name'          => 'OVCs'
      );
      $args = array(
        'labels'              => $labels,
        'description'         => 'Holds our OVCs and OVC specific data',
        'public'              => true,
        'exclude_from_search' => true,
        'show_in_nav_menus'   => false,
        'menu_position'       => 3,
        'menu_icon'           => 'dashicons-universal-access',
        'supports'            => array('title', 'custom-fields', 'comments'),
        'has_archive'         => true
      );
      register_post_type('OVC', $args); 
    }

    if (is_admin()) {
      
      // Set OVC title to Firstname Lastname
      add_filter('wp_insert_post_data', 'ovc_set_title', '99', 2);
      function ovc_set_title($data, $postarr) {
        if ($data['post_type'] == 'ovc') {
          if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
          if (defined('DOING_AJAX') && DOING_AJAX) return;
          if ($data['post_status'] == 'auto-draft') return $data;
          // ACF custom field keys: first_name = field_53eca02ad7a58, last_name = field_53eca050d7a59
          $data['post_title'] = $postarr['acf']['field_53eca02ad7a58'] . ' ' . $postarr['acf']['field_53eca050d7a59'];
          if ($data['post_status'] !== 'trash') $data['post_status'] = 'publish';
        }
        return $data;
      }

      // Remove quick edit from OVCs list
      add_filter('post_row_actions', 'ovc_remove_quick_edit', 10, 2);
      function ovc_remove_quick_edit($actions) {
        global $post;
        if ($post->post_type == 'ovc') unset($actions['inline hide-if-no-js']);
        return $actions;
      }

      // Force OVC edit screen to single column layout
      add_filter('get_user_option_screen_layout_ovc', function() { return 1; });
      add_filter('screen_layout_columns', function($columns) {
        $columns['ovc'] = 1;
        return $columns;
      });

      // Inject admin page custom styles
      add_action('admin_enqueue_scripts', 'ovc_admin_css');
      function ovc_admin_css() {
        wp_enqueue_style('ovc-admin-css', plugins_url('css/admin.css', __FILE__));
        wp_enqueue_script('ovc-admin-js', plugins_url('js/admin.js', __FILE__));
      }

    }
  }

  private static $featured_kids;

  // Return a Loop of featured OVCs
  public static function featured_kids() {
    if (isset(self::$featured_kids)) {
      self::$featured_kids->rewind_posts();
    }
    else {
      self::$featured_kids = new WP_Query(array(
        'post_type'    => 'ovc',
        'meta_key'     => 'featured',
        'meta_value'   => '1'
      ));
    }
    return self::$featured_kids;
  }

}

new OVC();
