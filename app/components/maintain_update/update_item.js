var setBtn = 0;
$(function() {
	$("#tbl").change(()=> {
		getData($("#tbl").val());
	});
	getData($("#tbl").val());
})

function getData(table) {
  $.post('../server/select_from_table.php', {table: $("#tbl").val(), update: true}).done((data)=>{
	$("#products").html(data);
    $("#products td").dblclick((e)=>{
        var sameParent = $(e.target).siblings().is($('#products .form-control').parent());
        var id = $(e.target).is(':first-child');
        var salt = $(e.target).is(':nth-child(8)');
        var len = $('#products .form-control').length;
        if((len < 1 || sameParent) && !id && ($("#tbl").val() !== 'users' && !salt)) {
            var html = $(e.target).html();
            if($('#products .btn').length < 1) {
                $(e.target).parent().append("<td><a id='#upd-btn' type='button' target='_blank' class='btn btn-primary'>Update</a></td>");
                $("#products .btn").click((e)=>{
                  updateItem();
                });
            }
            if(html.match(/\d{10}/) !== null || html.match(/^\d{3}-\d{3}-\d{4}$/g) !== null)
                  $(e.target).replaceWith("<td class='col-md-2'><input type='text' class='form-control' value='" + html + "' pattern='([0-9]{3}-[0-9]{3}-[0-9]{4})|([0-9]{10})' maxlength='12' required></td>");
            else if(html.match(/^\d+$/g) !== null)
                $(e.target).replaceWith("<td class='col-md-2'><input type='number' class='form-control' value='" + html + "' min='0' required></td>");
            else if(html.match(/^\d+\.\d+$/g) !== null)
                $(e.target).replaceWith("<td><input type='number' class='form-control' min='0' step='0.01' value='" + html + "' required></td>");
            else
                $(e.target).replaceWith("<td class='col-md-2'><input type='text' class='form-control' value='" + html + "' required></td>");
        }
    });
  })
}

function updateItem() {
  var obj = {};
  var row = $('#products .form-control').parent().parent();
  var cols = $('#cols').val().split(',');
  var q = 0;
  obj['id'] = $('#products .form-control').parent().siblings().first().html();
  obj['table'] = $('#tbl').val();

  $.each($(row).children(), function(i){
    if(i > 0 && $(this).children('input').length > 0) {
        var a = $(this).children('input').attr('type') == 'text';
        var p = $(this).children('input').attr('pattern');
        if(a && p !== undefined) {
          var re = new RegExp(p);
          var val = $(this).children('input').val();
          if(re.test(val)) {
            console.log(re.test(val))
            obj[cols[i-1]] = $(this).children('input').val()
          }
          else {
            q = 1;
            console.log('quit');
            return false;
          }
        }
        else
          obj[cols[i-1]] = $(this).children('input').val();
    }
  })
  if(q == 0) {
    $.post('../server/update_product.php', obj).done((data)=>{
      if (data !== "success")
          console.log(data);
      else
          getData($("#tbl").val());
    })
  }
}