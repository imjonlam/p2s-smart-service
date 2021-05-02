$(document).ready(function() {
  var user_id = $('#history_loader').attr('data-id');
  
  $.post('../server/get_order_history.php', {user: user_id}).done(
    function(data) {
      $('#history_body').append(data);
    }
  );
});