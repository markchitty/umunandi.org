<?php
/**************************** [carousel] shortcode ****************************
Parameters:
- id             : carousel id - used to target js actions like prev, next, etc
- post_type      : post_type of carousel items. Default = attachment.
- items          : comma/space separated list of item ids, or
                   keyword for special item lists, e.g. 'featured-ovcs'
- item_template  : html template for the carousel item content. Default = image.
- indicator_     : template-name to use a special template for the indicators,
  template         or false to hide the default slide indicators (o x o o).
- autoplay       : true to autoplay the carousel. Default = false.

Example:         [carousel
                   id="related-products-carousel"
                   post-type="product"
                   item_template="related-product"
                   items="13 17 23 123 294"
                 ]
*/

// Override the Bootstrap Shortcodes version of [carousel]
add_action('init', 'add_umunandi_carousel_shortcode', 100);
function add_umunandi_carousel_shortcode() {
  add_shortcode('carousel', 'umunandi_shortcode_carousel');
}

function umunandi_shortcode_carousel($atts) {
  $atts = shortcode_atts(array(
    'class'              => '',
    'id'                 => 'carousel-' . substr(bin2hex(random_bytes(16)), 0, 6),
    'post_type'          => 'attachment',
    'items'              => null,
    'item_template'      => 'item-image.php',
    'indicator_template' => 'indicators.php',
    'autoplay'           => '',
  ), $atts);
  $atts['indicator_template'] = $atts['indicator_template'] === 'false' || !$atts['indicator_template']
                              ? false
                              : $atts['indicator_template'];

  switch ($atts['items']) {

    // No items - barf
    case null: return 'Carousel error: no items';

    // Special case - featured OVCs
    case 'featured-ovcs':
      $carousel_items = OVC::featured_kids();
      break;

    // Special case - people biogs
    case 'umunandi_people':
      global $umunandi_people;
      $carousel_items = $umunandi_people->get_people();
      break;

    // Default behaviour - list of ids
    default:
      $query_args = array(
        'post_type'      => $atts['post_type'],
        'post__in'       => array_filter(explode(',', str_replace(' ', ',', $atts['items']))),
        'posts_per_page' => -1,
      );
      $carousel_items = new WP_Query($query_args);
  }

  // Using 'eval()' here (shock, horror) to avoid repeatedly
  // include-ing item_template inside the carousel loop
  $item_template_file_path = file_exists($atts['item_template']) ? '' : get_template_directory() . '/';
  $item_template_file = file_get_contents($item_template_file_path . $atts['item_template']);
  $item_template = function () use ($item_template_file) {
    eval(' ?>' . $item_template_file . '<?php ');
  };

  ob_start();
  include 'carousel.php';
  return ob_get_clean();
}
