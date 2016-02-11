$(document).ready(function() {
	var idCompra = $("#idCompra").val();
    anularCompra(idCompra);
});

var anularCompra = function(id){
	$("#btn_anular_compra").on("click",function(e){
		e.preventDefault();
		prosesarAnulacion(id);
	});
};

var prosesarAnulacion = function(id){
	var form = $("#form_delete");

	var url = form.attr('action');
	url = url.replace(':PURCHASE_ID',id);

	var data = form.serialize();

	//console.log(url);
	//console.log(data);

	$.post(url,data,function(response){
		alert(response.message);
		if(response.response==="ready")
		{
			location.href="/compras/historial";
		}
	},'json');
};