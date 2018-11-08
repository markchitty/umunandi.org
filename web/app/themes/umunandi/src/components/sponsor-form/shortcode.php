<?php 
class Sponsor_Form_Shortcode {

	const EMAIL_TO    = 'ruth@umunandi.org';
	const EMAIL_ERR   = "Sorry, there was a problem at our end. Please try again. "
	                  . "If it still doesn't work, send us a quick email at info@umunandi.org.";
	const NONCE_ERR   = "Hmm, your request seems to have got a bit mangled. Can you try that again?";
	const NONCE_ID    = 'umunandi_sponsor_sign_up';
	const THANKS_PAGE = 'help/sponsor/thank-you-';

	public function __construct() {
    add_shortcode('sponsor_form', array($this, 'shortcode'));
		add_action('wp_ajax_nopriv_umunandi_sponsor_sign_up', array($this, 'sponsor_sign_up'));
		add_action('wp_ajax_umunandi_sponsor_sign_up',        array($this, 'sponsor_sign_up'));
	}

  function shortcode($atts, $content) {
		$nonce = wp_create_nonce(self::NONCE_ID);
    ob_start();
    include 'form.php';
    return ob_get_clean();
  }

	function sponsor_sign_up() {
		$data = $_POST;
		if (!check_ajax_referer(self::NONCE_ID, 'nonce', false)) {
			wp_send_json_error(self::NONCE_ERR);
		}

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

new Sponsor_Form_Shortcode();