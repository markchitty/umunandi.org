<?php
add_action('wp_enqueue_scripts', 'umunandi_scripts_n_styles', 100);
function umunandi_scripts_n_styles() {
  $font_list = array(
    'Quicksand:300,400,700',
    'Raleway:300,400,500,600',
    'Nunito:400,600',
    // 'Martel:900',
    // 'Libre+Baskerville:400',
  );
  $fonts = '//fonts.googleapis.com/css?family=' . join('|', $font_list);
  $add_this = '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53e8a2ee11f168c4';

  wp_enqueue_style('umunandi_fonts', $fonts, false, false);
  wp_register_script('addThis', $add_this, false, false, true);
  wp_enqueue_script('addThis');
}

// Login logo
add_action('login_enqueue_scripts', 'umunandi_login_stylesheet');
function umunandi_login_stylesheet() {
  wp_enqueue_style('custom-login', get_template_directory_uri() . '/assets/css/login-style.css');
}
