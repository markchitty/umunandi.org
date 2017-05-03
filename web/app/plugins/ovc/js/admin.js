// umunandi.org
// WordPress backend javascript

jQuery().ready(function($){

  // Set OVC post title to readonly and then update it based on firstname lastname fields
  $('.wp-admin.post-type-ovc #title').attr('readonly', 'readonly');
  $('#acf-field-first_name, #acf-field-last_name').keyup(function() {
    var title = $('#acf-field-first_name').val() + ' ' + $('#acf-field-last_name').val();
    $('.wp-admin.post-type-ovc #title')
      .toggleClass('new', title == ' ')
      .val(title == ' ' ? 'OVC name' : title);
  }).keyup();
  $('#acf-field-first_name').focus();

});