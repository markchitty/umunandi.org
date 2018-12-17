umunandi.define('sponsor', function () {

	// Construct sponsorship options list
	var $sponsorOpts     = $('.sponsor-options');
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

});
