function submit_suggestions() {
  business = $('#business_input').val();
  address = $('#address_input').val();

  $('#business_input').val('');
  $('#address_input').val('');
  $('#btn_submit').text('Thanks!');

  $.post('../server/post_suggestion.php', {business: business, address: address}).done((data) => {
    if (data !== "success") {
      console.log(data);
    } else {
      $('#business_input').val('');
      $('#address_input').val('');
      $('#btn_submit').text('Thanks!');
    }
  })
}