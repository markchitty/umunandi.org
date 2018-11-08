// Sponsor form handler
umunandi.import('sponsor', function () {

	// Autoresize textareas to fit content
	$('textarea').each(function() {
		this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px; overflow-y:hidden;');
	}).on('input', function() {
		this.style.height = 'auto';
		this.style.height = (this.scrollHeight) + 'px';
	});

	// Construct sponsorship options list
 	var $sponsorOpts     = $('.sponsor-form .sponsor-options');
	var $sponsorOptRadio = $sponsorOpts.find('input').detach();
	$('.price-box-header').each(function(i, el) {
		$(el).clone()
			.prepend($sponsorOptRadio.clone().val(el.dataset.product))
			.find('h3').remove().end()
			.appendTo($sponsorOpts);
	});

	// Add click handlers for selecting the sponsorship product.
	// Note: once we've changed the radio button checked state, we still have to
	// call trigger(change) to actually get the radio change event to fire. Sigh.
	// trigger(blur) is there to hook form validation for the radio buttons.
	$('.price-boxes, .sponsor-options').on('click', '.price-box, .price-box-header', function() {
		$('input[value="' + this.dataset.product + '"]').prop('checked', true).trigger('change').trigger('blur');
	});

	// Sponsor option radio buttons onChange handler - delegated to
	// parent element as radio buttons are dynamically generated
	$sponsorOpts.on('change', 'input', function () {
		$('.sponsor-options-product').text(this.value);
		$('.sponsor-options-price').html('for ').append($(this).nextAll('.price-box-price').clone().children());
		$(document).scrollTo('.sponsor-sign-up', 500, {
			offset: umunandi.screenSize.isAtLeast('sm') && umunandi.globals.isNavFixed ? -50 : 10,
			onAfter: function () { $('input#firstName').focus(); }
		});
	});

	// Validation
	function validateField(el, form) {
		function getErrCode(el) {
			for (key in el.validity) if (key != 'valid' && el.validity[key]) return key;
		}
		var isErr = !el.checkValidity();
		var msgElemId = el.name + 'InputMsg';
		$('#' + msgElemId, form).text(isErr ? el.dataset[getErrCode(el)] : '');
		$(el).attr('aria-describedby', isErr ? msgElemId : null);
		$(el).closest('.form-group').toggleClass('error', isErr);
	}

	var $form = $('.sponsor-form');
	$form.on('blur', ':input', function() { validateField(this, $form); });

	// Submission
	$form.on('submit', function(e) {
		e.preventDefault();
		$(':input', this).each(function(i, el) { validateField(el, $form); });
		if (!this.checkValidity()) return false;

		var formData = {
			action : 'umunandi_sponsor_sign_up',
			nonce  : this.dataset.nonce
		};
		$form.serializeArray().map(function(field) { formData[field['name']] = field['value']; });
		$form.find('button').addClass('submitted').prop('disabled', true);
		var xhr = $.post($form.attr('action'), formData);

		xhr.done(function(response) {
			$form.css('height', $form.height()).empty().html(response.data);
		});

		xhr.fail(function(xhr, status, err) { console.log('XHR error', status, err); });
	});

});
