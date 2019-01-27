<?php
use \DrewM\MailChimp\MailChimp;

/**
 * Form shortcode : [form]
 * @param form_name        : One of the forms defined in forms-config.ini
 * @param button_text      : Submit button text
 * @param button_icon      : Submit button icon
 * @param class            : CSS classes

 * Every form must have an entry in forms.ini specifying:
 * - template      - the form fields that make up the form
 * - response_page - shown to the user after the form is succesfully submitted
 * - user_email    - sent to the user when the form is submitted
 * - admin_email   - sent to the admin when the form is submitted
 */

class Umunandi_Form_Shortcode {

  const ACTION   = 'umunandi_handle_form';
  const NONCE_ID = self::ACTION;
  private static $config;

  public function __construct() {
    // Read in forms.ini config
    self::$config = new Config_Lite(__DIR__ . '/forms.ini');
  
    add_shortcode('form', array($this, 'shortcode'));
    add_action('wp_ajax_nopriv_' . self::ACTION, array($this, 'handle_form'));
    add_action('wp_ajax_' . self::ACTION,        array($this, 'handle_form'));

    // Add 'form' class to body when a page contains a form, to hook form scripts
    add_filter('body_class', function($classes) {
      global $post;
      if (isset($post->post_content) && has_shortcode($post->post_content, 'form')) $classes[] = 'form';
      return $classes;
    });
  }

  function shortcode($atts, $content) {
    extract(shortcode_atts(array(
      'form_name' => 'contact',
      'button_text' => 'Submit',
      'button_icon' => '▸',
      'class' => ''
    ), $atts));

    // Read this form's config
    $form_config = $this->get_form_config($form_name);
    if (!$form_config) return $this->err_msg('form_not_defined', $form_name);

    // Write out the form
    $template = get_template_directory() . "/" . $form_config['template'];
    $nonce = wp_create_nonce(self::NONCE_ID);
    $action = self::ACTION;

    ob_start();
    include 'form.tpl.php';
    return ob_get_clean();
  }

  function handle_form() {
    $data = array_map('stripslashes', $_POST);
    $data['fullName'] = "{$data['firstName']} {$data['lastName']}";
    if ($data['message'] === '') $data['message'] = $this->err_msg('no_message');

    // Get the form config, using the formName from the POST request
    $form_config = $this->get_form_config($data['formName'], $data);

    // Check errors
    $default_err = $this->err_msg('default', get_option('admin_email'));
    if (!$form_config) return $this->send_err($default_err, "Unknown form: {$data['formName']}");
    if (!check_ajax_referer(self::NONCE_ID, 'nonce', false)) $this->send_err($default_err, 'Mismatched nonce');

    // Email the user and the admin
    try {
      $this->send_email('admin', $form_config, $data);
      $this->send_email('user',  $form_config, $data);
    }
    catch (Exception $e) {
      $this->send_err($default_err, $e->getMessage());
      return;
    }

    // Send a response back to the web page
    $response = get_page_by_path(umunandi_substitute_params($form_config['response_page'], $data));
    $content = apply_filters('the_content', $response->post_content);
    wp_send_json_success($content);

    // TODO - Handle this with mailchimp API
    // https://github.com/drewm/mailchimp-api/
    // https://www.web-development-blog.com/archives/mailchimp-subscribe-contact-form/
  }

  function get_form_config($form_name, $data = []) {
    if (!self::$config->hasSection($form_name)) return false;
    $config = self::$config->getSection($form_name);
    return umunandi_substitute_params($config, $data);
  }

  function send_email($to, $form_config, $data) {
    $email_config = Umunandi_Email_Template::get_template($form_config["{$to}_email"]);
    $email_config['from'] = get_option('blogname') . ' <' . get_option('admin_email') . '>';
    $mailer = new Umunandi_Mailer(array_merge($email_config, $data));
    $mailer->send();
  }

  function err_msg($err, $params = null) {
    $err_msg = self::$config['errors'][$err];
    return umunandi_substitute_params($err_msg, $params);
  }

  function send_err($msg, $code) {
    wp_send_json_error(json_encode(['msg' => $msg, 'code' => $code]));
    return false;
  }

}

new Umunandi_Form_Shortcode();