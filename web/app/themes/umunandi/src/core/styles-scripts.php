<?php
class Umunandi_Styles_n_Scripts {
  const UMUNANDI_STYLES     = '/assets/css/main.min.css';
  const CUSTOM_LOGIN_STYLES = '/assets/css/login-style.css';
  const GOOGLE_FONTS_API    = '//fonts.googleapis.com/css?family=';

  const GOOGLE_JQUERY       = '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js';
  const ADD_THIS_JS         = '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53e8a2ee11f168c4';
  const MODERNIZR           = '/vendor/js/modernizr-custom.js';
  const UMUNANDI_JS         = '/assets/js/scripts.min.js';
  const GOOGLE_ANALYTICS_ID = 'UA-135437972-1';

  const FONT_LIST = array(
    'Quicksand:300,400,700',
    'Raleway:300,400,500,600',
    'Nunito:400,600',
    // 'Martel:900',
    // 'Libre+Baskerville:400',
  );

  function styles_n_scripts() {
    $dir = get_template_directory_uri();

    // args: id, path, deps (array), ver, in-footer
    wp_enqueue_style('google_fonts', self::GOOGLE_FONTS_API . join('|', self::FONT_LIST));
    wp_enqueue_style('umunandi_css', $dir . self::UMUNANDI_STYLES, false, '65df6aeb');

    // Use jQuery from Google CDN
    if (!is_admin()) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', self::GOOGLE_JQUERY, null, null, false);
    }
    wp_enqueue_script('modernizr', $dir . self::MODERNIZR);
    wp_enqueue_script('jquery');
    wp_enqueue_script('umunandi_js', $dir . self::UMUNANDI_JS, null, 'fdc7b3c5', true);
    wp_enqueue_script('add_this', self::ADD_THIS_JS, false, false, true);
  }

  function login_stylesheet() {
    $dir = get_template_directory_uri();
    wp_enqueue_style('custom-login', $dir . self::CUSTOM_LOGIN_STYLES);
  }

  function google_analytics() {
    if (!current_user_can('manage_options')) { ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= self::GOOGLE_ANALYTICS_ID ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag('js', new Date());
      gtag('config', '<?= self::GOOGLE_ANALYTICS_ID ?>');
    </script>
    <?php }
  }

  public function __construct() {
    add_action('wp_enqueue_scripts',    array($this, 'styles_n_scripts'), 100);
    add_action('login_enqueue_scripts', array($this, 'login_stylesheet'));
    add_action('wp_footer',             array($this, 'google_analytics'), 20);
  }
};
new Umunandi_Styles_n_Scripts();
