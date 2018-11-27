<?php
add_action('widgets_init', 'umunandi_widgets_init');
function umunandi_widgets_init() {
  register_widget('Umunandi_Vcard_Widget');
}

class Umunandi_Vcard_Widget extends WP_Widget {
  private $fields = array(
    'title'          => 'Title (optional)',
    'street_address' => 'Street Address',
    'locality'       => 'City/Locality',
    'region'         => 'State/Region',
    'postal_code'    => 'Zipcode/Postal Code',
    'country'        => 'Country',
    'tel'            => 'Telephone',
    'email'          => 'Email',
    'notes'          => 'Notes',
    'header_link'    => 'Header link',
  );

  function __construct() {
    $widget_options = array('classname' => 'vcard', 'description' => 'It\'s a vCard widget');
    parent::__construct('umunandi_vcard_widget', 'vCard', $widget_options);
    $this->alt_option_name = 'umunandi_vcard_widget';
    add_action('save_post', array(&$this, 'flush_widget_cache'));
    add_action('deleted_post', array(&$this, 'flush_widget_cache'));
    add_action('switch_theme', array(&$this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $cache = wp_cache_get('umunandi_vcard_widget', 'widget');
    if (!is_array($cache)) $cache = array();
    if (!isset($args['widget_id'])) $args['widget_id'] = null;
    if (isset($cache[$args['widget_id']])) {
      echo $cache[$args['widget_id']];
      return;
    }

    foreach($this->fields as $name => $label) {
      if (!isset($instance[$name])) { $instance[$name] = ''; }
    }

    ob_start();
    extract($args, EXTR_SKIP);
    echo $before_widget;

    $title = empty($instance['title']) ? 'vCard' : $instance['title'];
    $title = apply_filters('widget_title', $title, $instance, $this->id_base);
    if ($instance['title']) {
      $before_title .= "<a href=\"{$instance['title']}\">";
      $after_title = '</a>' . $after_title;
    }
    if ($title) echo $before_title, $title, $after_title;

    include('vcard.php');

    echo $after_widget;
    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('umunandi_vcard_widget', $cache, 'widget');
  }

  function update($new_instance, $old_instance) {
    $instance = array_map('strip_tags', $new_instance);
    $this->flush_widget_cache();
    $alloptions = wp_cache_get('alloptions', 'options');
    if (isset($alloptions['umunandi_vcard_widget'])) {
      delete_option('umunandi_vcard_widget');
    }
    return $instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('umunandi_vcard_widget', 'widget');
  }

  function form($instance) {
    foreach($this->fields as $name => $label) {
      ${$name} = isset($instance[$name]) ? esc_attr($instance[$name]) : '';
      include('widget-form.php');
    }
  }
}
