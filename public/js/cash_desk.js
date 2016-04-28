$(document).ready(function() {

    pagar();
});

var pagar = function(){
	$(".btn-paga").on("click",function(event){
		event.preventDefault();

		id = $(this).data('id');

		ruta = $('#ruta-data-venta').val();

		ruta = ruta.replace(':ID',id);

		$.getJSON(ruta,function(response){
			//console.log(response);
			$("#sale_id").val(response.id);
			$("#waiting_id").val(id);
			$("#numeroOrdenPagando").html(id);
			$("#totalPorPagar").html(response.total);
			$("#modal-pagar").modal();
		});

	});
};