<?php
// Load title font css from Google fonts
wp_enqueue_style('umunandi_fonts', 'http://fonts.googleapis.com/css?family=Roboto+Slab:400', false, false);

// Inject AddThis scripts into the page
add_action('wp_enqueue_scripts', 'addThis_scripts');
function addThis_scripts() {
    wp_register_script('addThis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53e8a2ee11f168c4', false, false, true);
    wp_enqueue_script('addThis');
}

// Change home link behaviour on home page to scroll instead of reload
add_action('roots_wp_nav_menu_item', 'home_link_scroll_to_top');
function home_link_scroll_to_top($item_html) {
  if (is_front_page() && stristr($item_html, 'menu-home')) {
    $item_html = preg_replace('/href="(.*)"/iU', 'href="#top" data-scrollto="750"', $item_html);
  }
  return $item_html;
}

// Image tag without dimensions
function wp_get_image_tag($attach_id, $size, $icon, $alt = '') {
  if ($src = wp_get_attachment_image_src($attach_id, $size, $icon)) {
    return sprintf('<img src="%s" alt="%s" />', $src[0], $alt);
  }
}

// =============== Admin functions =================

// Shortcodes
// Clean up wpautop crap
function remove_wpautop_markup($string) {
  return preg_replace(array('#^\s*</p>#', '#<p>\s*$#'), '', $string);
}

// Shortcode: [parallax_container]
add_shortcode('parallax_container', 'sc_parallax_container');
function sc_parallax_container($atts, $content = null) {
  $content = remove_wpautop_markup($content);
  $args    = shortcode_atts(array(
    'img_class'       => '',
    'container_class' => '',
    'parallax_ratio'  => '0.66',
    'img_pos_x'       => '50%',
    'img_pos_y'       => '50%',
  ), $atts, 'parallax_container');
  preg_match('/<img[^>]*>/i', $content, $matches);   // replace first <img>
  if ($matches) {
    preg_match('/src="([^"]*)"/i', $matches[0], $src);
    $content = preg_replace('#(<p>)?<img[^>]*>(</p>)?#i', '', $content);
    $plx_div = '<div class="parallax-bg-img %s" data-stellar-vertical-offset="50" '
             . 'data-stellar-ratio="%s" style="background-image: url(%s); background-position: %s %s"></div>';
    $plx_div = sprintf($plx_div, $args['img_class'], $args['parallax_ratio'], $src[1], $args['img_pos_x'], $args['img_pos_y']);
  }
  ob_start();
  ?>
  <div class="section parallax-container <?= $args['container_class'] ?>">
    <?= $plx_div ?>

    <div class="container">
      <?= $content ?>
    </div><!-- /.container -->
  </div><!-- /.section -->
  <?php
  return ob_get_clean();
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
