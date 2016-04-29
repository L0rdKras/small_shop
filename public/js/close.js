$(document).ready(function() {

    closeCashDesk();

});

var closeCashDesk = function(){
	$("#btnCierre").on('click',function(event){
		event.preventDefault();
		if(confirm("Aviso:El cierre de caja implica que los documentos pendientes quedaran en la siguiente")){
			var form = $("#formSaveClose");

			var data = form.serialize();

			var url = form.attr('action');

			$.post(url,data,function(response){
				if(response.respuesta!=undefined){
					//paso
					if(response.respuesta === "Guardado"){
						alert("Caja Cerrada");
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
		}
	});
};