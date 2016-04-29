$(document).ready(function() {

    selectClient();

    confirmPay();
});

var selectClient = function(){
	$(".btn-select-client").on("click",function(event){
		event.preventDefault();

		var id = $(this).data('id');

		var ruta = $("#ruta-client-data").val();

		ruta = ruta.replace(':ID',id);

		//cargar data
		$.getJSON(ruta,function(response){
			var template = $("#template-data-client").html();
			template = template.replace(':NOMBRE',response.name);
			$("#DataCliente").html(template);
			$("#client_id").val(id);
		});

	});
};

var confirmPay = function(){
	$("#btn-confirmar").on('click',function(e){
		e.preventDefault();

		var form = $("#formSaveSale");

		var data = form.serialize();

		var url = form.attr('action');

		$.post(url,data,function(response){
			if(response.respuesta!=undefined){
				//paso
				if(response.respuesta === "Guardado"){
					alert("Registro de venta guardado");
					//redireccionar caja
					location.href=response.ruta;
				}else{
					alert(response.mensaje);
				}
			}else{
				//faltan datos
				alert("Errores en la informacion proporcionada, revise los datos");
				console.log(response);
			}
		},'json').fail(function(){
			alert("Ocurrio un error al intentar guardar la informacion");
		});
		
	});
};