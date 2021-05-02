$(function() {
	$("#tbl").change(()=> {
		getData($("#tbl").val());
	});
	$('form').submit((e)=>{
		e.preventDefault();
	});
	$('#id').keyup((e)=> {
		getData($("#tbl").val());
	});
	getData($("#tbl").val());
})

function getData(table) {
  $.post('../server/select_from_table.php', {table: $("#tbl").val(), id: $('#id').val()}).done((data)=>{
	$("#products").html(data);
  })
}