$(document).ready(function() {

    pagar();

    anularPago();

    confirmaPago();
});

var pagar = function(){
	$(".btn-paga").on("click",function(event){
		event.preventDefault();

		var id = $(this).data('id');

		var ruta = $('#ruta-data-venta').val();

		var ruta = ruta.replace(':ID',id);

		$.getJSON(ruta,function(response){
			//console.log(response);
			$("#sale_id").val(response.id);
			$("#waiting_id").val(id);
			$("#numeroOrdenPagando").html(id);
			$("#totalPorPagar").html(response.total);
			$("#payment_method").val("");
			$("#ticket").val("");
			$("#modal-pagar").modal();
		});

	});
};

var anularPago = function(){
	$(".btn-anula").on("click",function(event){
		event.preventDefault();

		var id = $(this).data('id');

		if(confirm("Anular la orden de venta implica devolver los stock de los articulos al sistema")){
			var form = $("#formAnnul");

			var data = form.serialize();

			var url = form.attr('action');

			url = url.replace(':ID',id);

			$.post(url,data,function(response){
				if(response==="Anulado"){
					location.reload();
				}
			});
		}

	});
};

var confirmaPago = function(){
	$("#btn-confirma-pago").on('click',function(event){
		event.preventDefault();

		var form = $("#formSaveSale");

		var data = form.serialize();

		var url = form.attr('action');

		payment_method = $("#payment_method").val();

		if(payment_method !='Credito'){
			$.post(url,data,function(response){
				if(response.respuesta!=undefined){
					//paso
					if(response.respuesta === "Guardado"){
						alert("Registro de venta guardado");
						$("#modal-pagar").modal('hide');
						$("#wait_"+response.espera).fadeOut();
					}else{
						alert("Ocurrio un error inesperado, contactese con soporte");
					}
				}else{
					//faltan datos
					alert("Errores en la informacion proporcionada, revise los datos");
					console.log(response);
				}
			},'json').fail(function(){
				alert("Ocurrio un error al intentar guardar la informacion");
			});
		}else{
			if(confirm("Una venta a credito necesita mas información, tendremos que pasar a otra ventana")){
				//abrir en ventana de llenado de datos
				//cliente
				var rutaCredito = $("#rutaCredito").val();

				var id_waiting = $("#waiting_id").val();

				rutaCredito = rutaCredito.replace(':ID',id_waiting);

				location.href=rutaCredito;
			}
		}

	});
};