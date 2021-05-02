$(function() {
	$("#tbl").change(()=> {
		getData($("#tbl").val());
	});
	getData($("#tbl").val());
})

function getData(table) {
  $.post('../server/select_from_table.php', {table: $("#tbl").val(), del_btn: true}).done((data)=>{
	$("#products").html(data);
	$("#products .btn").click((e)=>{
		$.post('../server/del_item_from_table.php', {table: $("#tbl").val(), id: $(e.target).attr('data-id')}).done((data) => {
			if(data !== 'success') {
				console.log(data);
			}
			else
				getData($("#tbl").val());
		})
	});
  })
}