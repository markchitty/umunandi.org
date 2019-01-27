<?php

// Wrapper class for wp_mail()
Class Umunandi_Mailer {

  // $email_config contains the parameters for building and sending the email:
  //
  // to            - (Required) Array or comma separated list of email addresses
  // subject       - (Required) Email subject
  // body          - (Required) Email body
  // cc, bcc       - Array or comma separated list of email addresses
  // from,reply_to - Single email address
  // headers       - Array|String additional headers
  // attachments   - Array|String Absolute path to file(s) to attach
  // templates     - Array|String Absolute path to template(s) to use for the email.
  //                 Valid keys = footer|body|header. If String, template file = body.
  // ...other data - key=>value pairs to be used for {{field}} substitution
  // 
  // Email address format can be 'fred@acme.com' or 'Fred Bloggs <fred@acme.com>'

  private $email_config = [];
  private $required = ['to', 'subject', 'body'];

  // Default templates
  private $templates = [
    'header' => __DIR__ . '/partials/header.tpl.php',
    'body'   => __DIR__ . '/partials/body.tpl.php',
    'footer' => __DIR__ . '/partials/footer.tpl.php',
  ];

  private $plaintext = '';
  private $phpmailer;

  public function __construct(array $config) {
    foreach ($this->required as $setting) {
      if (!array_key_exists($setting, $config) || empty($config[$setting])) {
        throw new Exception("Required email setting missing: '{$setting}'");
      }
    }

    // Substitute {{field}} values ($config is both source and dest)
    $config = $this->parseAsMustache($config, $config);

    $plaintext = strip_tags($config['body']);
    $config['message_preview'] = substr($plaintext, 0, 250);
    $config['body'] = wpautop(wptexturize(convert_chars($config['body'])));

    $this->plaintext = $plaintext;
    $this->email_config = $config;

    // Override the default templates
    $templates = $this->get_config('templates', 'body');
    foreach ($this->templates as $name => $file) {
      if (array_key_exists($name, $templates)) {
        if (!file_exists($file)) throw new Exception("File not found: $file");
        $this->templates[$name] = $file;
      }
    }

    // phpmailer_init action is called just before email is sent
    add_action('phpmailer_init', array($this, 'phpmailer_init'));
  }

  public function render() {
    return
      $this->renderTemplate('header') .
      $this->renderTemplate('body') .
      $this->renderTemplate('footer');
  }

  private function renderTemplate($template_name) {
    ob_start();
    include $this->templates[$template_name];
    $html = ob_get_clean();

    $html = do_shortcode($html);
    $html = $this->parseAsMustache($html, $this->email_config);
    $html = preg_replace('/[ \t]+/', ' ', $html);
    return $html;
  }

  /**
   * Substitute {{fields}} with parameter values
   * @param String|Array $templates - If array, function returns array of substituted strings.
   * @param Array        $params - If string, this string is substituted into all fields. If
   *                     array, keys = param name. If no matching key, {{field}} is left in place.
   */
  public function parseAsMustache($templates, $params = array()) {
    if (is_array($params) && empty($params)) return $templates;

    // recurse
    if (is_array($templates)) {
      foreach($templates as $template) {
        if (is_array($template)) $this->parseAsMustache($template, $params);
      }
    }

    return preg_replace_callback(
      '|{{(.*?)}}|',
      function($match) use ($params) {
        if (!is_array($params)) return $params;
        if (array_key_exists(trim($match[1]), $params)) return $params[trim($match[1])];
        return $match[0];
      },
      $templates
    );
  }

  private function buildHeaders() {
    $headers = join("\r\n", $this->get_config('headers')) . "\r\n";
    foreach ($this->get_config('cc')       as $cc)   $headers .= sprintf("Cc: %s \r\n", $cc);
    foreach ($this->get_config('bcc')      as $bcc)  $headers .= sprintf("Bcc: %s \r\n", $bcc);
    foreach ($this->get_config('from')     as $from) $headers .= sprintf("From: %s \r\n", $from);
    foreach ($this->get_config('reply_to') as $rt)   $headers .= sprintf("Reply-to: %s \r\n", $rt);
    return $headers;
  }
  
  /**
   * get_config - Returns the requested config setting as an array
   * @param  String $item - Config setting to return
   * @param  String|Int $key - (Optional) Array key of returned setting
   */
  private function get_config(string $item, $key = 0) {
    $arr = $this->email_config;
    if (!array_key_exists($item, $arr) || empty($arr[$item])) return [];
    return (is_array($arr[$item])) ? $arr[$item] : [$key => $arr[$item]];
  }

  public function phpmailer_init(&$phpmailer) {
    // Store a reference to $phpmailer so we can read ErrorInfo if things go wrong
    $this->phpmailer = $phpmailer;

    // Set the Sender: header to be the same as the From: address
    $phpmailer->Sender = $phpmailer->From;

    // Set the plain text message - phpmailer then also conveniently takes care
    // of the whole Content-Type: multipart/alternative; boundary thing for us
    $phpmailer->AltBody = $this->plaintext;
  }

  public function send() {
    $result = wp_mail(
      $this->email_config['to'],
      $this->email_config['subject'],
      $this->render(), 
      $this->buildHeaders(),
      $this->get_config('attachments')
    );
    if (!$result) {
      $to = join(', ', $this->get_config('to'));
      $err = $this->phpmailer->ErrorInfo;
      throw new Exception("Email to '{$to}' failed to send: {$err}");
    }
  }

}