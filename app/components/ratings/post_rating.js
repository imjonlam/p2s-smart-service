$(function() {
  var user_id = $('#history_loader').attr('data-id');
  $.post('../server/get_orders_review.php', {user: user_id, reviewed: 'NO'}).done((data)=> {
    $('#history_body').append(data);

    $("#history_body .btn").click((e) => {
      var target = e.target;
      var tr = $(target).parent().parent();

      var order_number = tr.find('.order_number').text();
      var description = tr.find('.description').text();
      var select_box = tr.find('.rating')
      var rating = select_box.val();

      $.post('../server/post_review.php', {order_number: order_number, desc: description, rating: rating}).done((data) => {
        if (data !== "success") {
          console.log(data);
        } else {
          $.post('../server/update_reviewed.php', {id: order_number, reviewed: 'YES'}).done((data) => {
            if (data !== "success") {
              console.log(data);
            } else {
              $(target).text('Thanks!');
              $(target).attr("disabled", true);
              $(select_box).attr("disabled", true);
            }    
          });
        }
      })
    });
  });
})