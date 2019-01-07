<?php
// Form shortcode

class Umunandi_Form_Shortcode {

	const EMAIL_TO    = 'ruth@umunandi.org';
	const EMAIL_ERR   = "Sorry, there was a problem at our end. Please try again. "
	                  . "If it still doesn't work, send us a quick email at info@umunandi.org.";
	const NONCE_ERR   = "Sorry, that didn't work. Can you try again?";
	const ACTION      = 'umunandi_handle_form';
	const NONCE_ID    = self::ACTION;
	const THANKS_PAGE = 'help/sponsor/thank-you-';

	public function __construct() {
    add_shortcode('form', array($this, 'shortcode'));
		add_action('wp_ajax_nopriv_' . self::ACTION, array($this, 'handle_form'));
		add_action('wp_ajax_' . self::ACTION,        array($this, 'handle_form'));

		// Add 'form' class to body when a page contains a form, to hook form scripts
		add_filter('body_class', array($this, 'body_class'));
	}

  function shortcode($atts, $content) {
	  extract(shortcode_atts(array('type' => 'contact', 'class' => ''), $atts));
		$nonce = wp_create_nonce(self::NONCE_ID);
		$action = self::ACTION;
		$is_sponsor = $type === 'sponsor';
		ob_start();
		include 'form.php';
		return ob_get_clean();
  }

	function body_class($classes) {
    global $post;
    if (isset($post->post_content) && has_shortcode($post->post_content, 'form')) $classes[] = 'form';
    return $classes;
	}

	function handle_form() {
		$data = $_POST;
		if (!check_ajax_referer(self::NONCE_ID, 'nonce', false)) {
			wp_send_json_error(self::NONCE_ERR);
		}

		// TODO - Handle this with mailchimp API
		// https://github.com/drewm/mailchimp-api/
		// https://www.web-development-blog.com/archives/mailchimp-subscribe-contact-form/

		// Email the submitted info
		$name    = $data['firstName'] . ' ' . $data['lastName'];
		$to      = self::EMAIL_TO;
		$subject = "New sponsorship enquiry - $name would like to sponsor {$data['product']}";
		$message = "Yay, we've just received a new sponsorship enquiry!\n\n";
		$headers = array("Reply-to: $name<{$data['email']}>");
		foreach ($data as $key=>$val) $message .= "$key : $val\n";
		$result = wp_mail($to, $subject, $message, $headers);

		if ($result) {
			$response = get_page_by_path(self::THANKS_PAGE . array_pop(explode(' ', $data['product'])));
			$content = apply_filters('the_content', $response->post_content);
			wp_send_json_success($content);
		}
		else {
			wp_send_json_error(self::EMAIL_ERR);
		}
	}
}

new Umunandi_Form_Shortcode();