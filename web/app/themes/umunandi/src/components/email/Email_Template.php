<?php
class Umunandi_Email_Template {

  const POST_TYPE = 'email_template';

  public function __construct() {

    // ======== Custom Post Type =======
    // http://www.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/
    add_action('init', function() {
      $labels = array(
        'name'               => _x('Email templates', 'post type general name'),
        'singular_name'      => _x('Email template', 'post type singular name'),
        'add_new'            => _x('Add new', 'thing'),
        'add_new_item'       => __('Add new email template'),
        'edit_item'          => __('Edit email template'),
        'new_item'           => __('New email template'),
        'all_items'          => __('All emails'),
        'view_item'          => __('View email'),
        'search_items'       => __('Search templates'),
        'not_found'          => __('No email templates found'),
        'not_found_in_trash' => __('No email templates found in trash'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Emails'
      );
      $args = array(
        'labels'              => $labels,
        'description'         => 'Email templates - for sending out html emails',
        'public'              => true,
        'exclude_from_search' => true,
        'show_in_nav_menus'   => false,
        'menu_icon'           => 'dashicons-email-alt',
        'supports'            => array('title', 'editor', 'custom-fields'),
        'has_archive'         => true
      );
      register_post_type(self::POST_TYPE, $args);
    });

    add_filter('ac/column/value', [$this, 'title_col'], 10, 3);
    add_action('transition_post_status', [$this, 'set_private'], 10, 3);
  }

  public function set_private($new_status, $old_status, $post) {
    if ($post->post_type === self::POST_TYPE && $new_status === 'publish') {
      $post->post_status = 'private';
      wp_update_post($post);
    }
  }

  public function title_col($value, $id, $column) {
    if ($column->get_option('field') === 'email_title') {
      global $post;
      $title = get_field('email_title', $post->ID);
      $subtitle = get_field('email_subtitle', $post->ID);
      $value = "<b>{$title}</b><br>{$subtitle}";
    }
    return $value;
  }

  public static function get_template($slug) {
    $args = ['name' => $slug, 'post_type' => self::POST_TYPE, 'post_status' => 'any'];
    $templates = get_posts($args);

    if (!$templates) throw new Exception("Email template not found: '{$slug}'");

    $template = $templates[0];
    $fields = get_fields($template->ID);
    $fields = array_map_assoc(function($key, $val) {
      return [str_replace('email_', '', $key), $val];
    }, $fields);
    $fields['body'] = $template->post_content;
    return $fields;
  }
}

new Umunandi_Email_Template();
