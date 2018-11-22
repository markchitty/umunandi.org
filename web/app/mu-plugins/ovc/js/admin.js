// umunandi.org
// WordPress backend javascript

jQuery().ready(function($){

  // Set OVC post title to readonly and then update it based on firstname lastname fields
  $('.wp-admin.post-type-ovc #title').attr('readonly', 'readonly');
  $('#acf-field_53eca02ad7a58, #acf-field_53eca050d7a59').keyup(function() {
    var title = $('#acf-field_53eca02ad7a58').val() + ' ' + $('#acf-field_53eca050d7a59').val();
    $('.wp-admin.post-type-ovc #title')
      .toggleClass('new', title == ' ')
      .val(title == ' ' ? 'OVC name' : title);
  }).keyup();
  $('#acf-field_53eca02ad7a58').focus();

});