// Sponsor form handler
umunandi.define('sponsor', function () {

	// Construct sponsorship options list
	var $form            = $('.sponsor-form');
	var $sponsorOpts     = $('.sponsor-form .sponsor-options');
	var $sponsorOptRadio = $sponsorOpts.find('input').detach();
	$('.price-box-header').each(function(i, el) {
		$(el).clone()
			.prepend($sponsorOptRadio.clone().val(el.dataset.product))
			.find('h3').remove().end()
			.appendTo($sponsorOpts);
	});

	// Click handlers for selecting the sponsorship product
	// trigger(change) fires the radio change event (should happen implicitly IMO)
	// trigger(blur) is there to hook the form validation for the radio buttons
	$('.price-boxes, .sponsor-options').on('click', '.price-box, .price-box-header', function() {
		$('input[value="' + this.dataset.product + '"]').prop('checked', true).trigger('change').trigger('blur');
	});

	// Sponsor option radio buttons onChange handler - delegated to
	// parent element as radio buttons are dynamically generated
	$sponsorOpts.on('change', 'input', function () {
		$('.sponsor-options-product').text(this.value);
		$('.sponsor-options-price').html('for ').append($(this).nextAll('.price-box-price').clone().children());
		$(document).scrollTo('.sponsor-sign-up', 500, {
			offset: 10,
			onAfter: function () { $('input#firstName').focus(); }
		});
	});

	// Validation - uses HTML5 Constraint Validation API - https://mzl.la/2QHPDzW
	function validateField(elm) {
		function getErrCode(elm) {
			for (key in elm.validity) if (key != 'valid' && elm.validity[key]) return key;
		}
		var isErr = !elm.checkValidity();
		var msgElemId = elm.name + 'InputMsg';
		$('#' + msgElemId).text(isErr ? elm.dataset[getErrCode(elm)] : '');
		$(elm).attr('aria-describedby', isErr ? msgElemId : null);
		$(elm).closest('.form-group').toggleClass('error', isErr);
	}
	$form.on('blur', ':input', function() { validateField(this); });

	// Submission
	$form.on('submit', function(evt) {
		evt.preventDefault();
		$('.form-error').hide();
		$(':input', this).each(function(i, elm) { validateField(elm); });
		if (!this.checkValidity()) return false;
		var formData = {
			action : this.dataset.wpAction,
			nonce  : this.dataset.nonce
		};
		$form.serializeArray().map(function(field) { formData[field['name']] = field['value']; });
		$form.find('button').toggleClass('submitted', true).prop('disabled', true);
		var jqXHR = $.post($form.attr('action'), formData);

		// Response
		jqXHR.done(function(response) {
			if (response.success) $form.css('height', $form.height()).empty().html(response.data);
			else showFormError(response.data);
		});

		// Error handling
		jqXHR.fail(function(jqXHR, status, err) {
			var errReason = jqXHR.status + ' - ' + jqXHR.statusText;
			if (jqXHR.statusText === 'timeout') showFormError($form[0].dataset.errorTimeout, errReason);
			else                                showFormError($form[0].dataset.errorGeneric, errReason);
		});
	});

	function showFormError(msg, reason) {
		$form.find('.form-error').show();
		$form.find('.msg').text(msg);
		$form.find('.reason').text(typeof reason === 'undefined' ? '' : '(' + reason + ')');
		$form.find('button').toggleClass('submitted', false).prop('disabled', false);
	}

});
