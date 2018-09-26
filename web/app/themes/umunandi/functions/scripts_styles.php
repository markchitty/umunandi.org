<?php
add_action('wp_enqueue_scripts', 'umunandi_scripts_n_styles', 100);

function umunandi_scripts_n_styles() {

  // Google fonts
  wp_enqueue_style(
    'umunandi_fonts',
    '//fonts.googleapis.com/css?family=Raleway:300,400,500,600|Martel:900|Nunito:400,600|Quicksand:300,400,700|Libre+Baskerville:400',
    false, false
  );

  // AddThis scripts
  wp_register_script(
    'addThis',
    '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53e8a2ee11f168c4',
    false, false, true
  );
  wp_enqueue_script('addThis');
}

// Login logo
function umunandi_login_stylesheet() {
  wp_enqueue_style('custom-login', get_template_directory_uri() . '/assets/css/login-style.css');
}
add_action('login_enqueue_scripts', 'umunandi_login_stylesheet');
