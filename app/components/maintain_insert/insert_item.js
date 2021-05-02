$(function() {
	$("#tbl").change(()=> {
		getData($("#tbl").val());
	});
	getData($("#tbl").val());
})

function getData(table) {
  $.post('../server/select_from_table.php', {table: $("#tbl").val(), insert: true}).done((data)=>{
	$("#products").html(data);
    $('#products .form-control').keyup((e)=>{
        var key = e.key || e.which || e.keyCode || 0;
        if(key == 13 || key == 'Enter')
          insertItem();
    });
    $("#products .btn").click((e)=>{
      insertItem();
    });
  })
}

function insertItem() {
  var obj = {};
  var und = 0;
  $.each($('td .form-control'), function(){
    if($(this).val() == "") {
      und = 1;
      return false;
    }
    obj[$(this).attr('id')] = $(this).val();
  })
  obj['table'] = $('#tbl').val();
  if(und == 0) {
    $.post('../server/insert_product.php', obj).done((data)=>{
      if (data !== "success")
          console.log(data);
      else
          getData($("#tbl").val());
    })
  }
}