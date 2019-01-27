<?php
class Umunandi_Email_Template_Part_Shortcode {

  public function __construct() {
    add_shortcode('email_template_part', array($this, 'shortcode'));
  }

  public function shortcode($atts, $content) {
    extract(shortcode_atts(['id' => 'text_block'], $atts));
    $template = __DIR__ . "/partials/{$atts['id']}.tpl.php";
    ob_start();
    include $template;
    return ob_get_clean();
  }
}

new Umunandi_Email_Template_Part_Shortcode();
