<?php
/**************************** [modal] shortcode ****************************
Parameters:
- id       : modal id - used to target js actions.
- backdrop : boolean or 'static'. Default = true.

Example:   [modal id="products-modal"]
             <div>Modal content ... </div>
           [/modal]
*/

// Override the Bootstrap Shortcodes version of [modal]
add_action('init', 'add_umunandi_modal_shortcode', 100);
function add_umunandi_modal_shortcode() {
  add_shortcode('modal', 'umunandi_shortcode_modal');
}

function umunandi_shortcode_modal($atts, $content) {
  $atts = shortcode_atts(array(
    'class'    => '',
    'id'       => 'modal-' . substr(bin2hex(random_bytes(16)), 0, 6),
    'backdrop' => true,
  ), $atts);
  if ($atts['backdrop'] === 'false' || !$atts['backdrop']) $atts['backdrop'] = '';

  ob_start();
  include 'modal.php';
  return ob_get_clean();
}
