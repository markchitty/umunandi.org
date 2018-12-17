// Form related scripts

umunandi.define('form', function() {

  var $form = $('.umunandi-form');

  // Autoresize textareas to fit content
  $('textarea').each(function () {
    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px; overflow-y:hidden;');
  }).on('input', function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
  });

  // Validation - uses HTML5 Constraint Validation API - https://mzl.la/2QHPDzW
  function validateField(elem) {
    function getErrCode(elem) {
      for (key in elem.validity) if (key != 'valid' && elem.validity[key]) return key;
    }
    var isErr = !elem.checkValidity();
    var msgElemId = elem.name + 'InputMsg';
    $('#' + msgElemId).text(isErr ? elem.dataset[getErrCode(elem)] : '');
    $(elem).attr('aria-describedby', isErr ? msgElemId : null);
    $(elem).closest('.form-group').toggleClass('error', isErr);
  }
  $form.on('blur', ':input', function () { validateField(this); });

  // Submission
  $form.on('submit', function (evt) {
    evt.preventDefault();
    $('.form-error').hide();
    $(':input', this).each(function (i, elem) { validateField(elem); });
    if (!this.checkValidity()) return false;
    var formData = {
      name: this.name,
      action: this.dataset.wpAction,
      nonce: this.dataset.nonce
    };
    $form.serializeArray().map(function (field) { formData[field['name']] = field['value']; });
    $form.find('button').toggleClass('submitted', true).prop('disabled', true);
    var jqXHR = $.post($form.attr('action'), formData);

    // Response
    jqXHR.done(function (response) {
      if (response.success) $form.css('height', $form.height()).empty().html(response.data);
      else showFormError(response.data);
    });

    // Error handling
    jqXHR.fail(function (jqXHR, status, err) {
      var errReason = jqXHR.status + ' - ' + jqXHR.statusText;
      if (jqXHR.statusText === 'timeout') showFormError($form[0].dataset.errorTimeout, errReason);
      else showFormError($form[0].dataset.errorGeneric, errReason);
    });
  });

  function showFormError(msg, reason) {
    $form.find('.form-error').show();
    $form.find('.msg').text(msg);
    $form.find('.reason').text(typeof reason === 'undefined' ? '' : '(' + reason + ')');
    $form.find('button').toggleClass('submitted', false).prop('disabled', false);
  }

});
