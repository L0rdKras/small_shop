var id_global = 0;
$(document).ready(function() {

    function_delete_description();
    function_load_article();
    function_guarda_venta();
    selecciona_medio();
});

function function_delete_description(id)
{
	$("#"+id+" .btn-danger").on("click",function(e){
		e.preventDefault();

		var fila = $(this).parents("tr");

		fila.fadeOut("slow",function(){
			fila.remove();
			actualiza_total();
			if($('#detalle_venta > tr').length == 0){
				//oculta boton compra
				$("#save_area").fadeOut();

			}
		});

	});
}

function function_load_article()
{
	$("#btn_load_code").on('click',function(e){
		e.preventDefault();
		var bar_code = $("#bar_code").val();
		var form = $("#form_load");

		var url = form.attr('action').replace(':CODE',bar_code);

		//var data = form.serialize();
		$.get(url,function(result){
			if(result.message == "encontrado")
			{
				$("#datos_articulo").html($("#template_datos_articulo").html()).promise().done(function(){
					$(this).fadeIn();
					$("#descripcion_cargada").val(result.description_article);
					$("#detalle_cargado").val(result.details);
					$("#stock_cargado").val(result.stock);
					$("#precio").val(result.price);
					calculate_subtotal(result.price,result.stock);
					add_detalle(bar_code,result);						
				});
			}else{
				alert(result.message);
				$("#datos_articulo").fadeOut("slow",function(){
					$(this).html("");
				});
			}
		}).fail(function(){
			alert("Ocurrio un error al intentar cargar la informacion");
		});
	});
}

function calculate_subtotal(precio,stock)
{
	$("#cantidad").on("keypress",function(e){
		if(e.which == 13)
		{
			e.preventDefault();
			var cantidad = $(this).val();

			if(parseInt(cantidad)<=parseInt(stock))
			{
				var subtotal = cantidad*precio;

				$("#subtotal").val(subtotal);
			}else{
				alert("La cantidad a vender no puede ser superior al stock en sistema");
				//
				$(this).val("");

				$("#subtotal").val("");
			}

		}
	});
}

function add_detalle(bar_code,datos)
{
	$("#btn_load_article").on("click",function(e){
		e.preventDefault();
		var cantidad = $("#cantidad").val();

		if(cantidad>0)
		{
			if(parseInt(cantidad)<=parseInt(datos.stock))
			{
				var subtotal = cantidad*datos.price;

				$("#subtotal").val(subtotal);
				var fila = $("#fila_tabla").html();

				fila = fila.replace("C.I.A",datos.article_id);
				fila = fila.replace("CodigoBarra",bar_code);
				fila = fila.replace("Descripcion",datos.description_article);
				fila = fila.replace("Detalle",datos.details);
				fila = fila.replace("Cantidad",cantidad);
				fila = fila.replace("Precio",datos.price);
				fila = fila.replace("Subtotal",subtotal);
				fila = fila.replace(":id_articulo",datos.article_id);
				fila = fila.replace(":cantidad_venta",cantidad);
				fila = fila.replace(":id_fila",id_global);
				fila = fila.replace(":subtotal",subtotal);

				id_global++;

				$("#detalle_venta").append(fila).promise().done(function(){
					$("#datos_articulo").fadeOut("slow",function(){
						$(this).html("");
						$("#bar_code").val("");
						$("#bar_code").focus();
						//if($('#detalle_compra > tr').length-1 == 0){
						var id_aux = id_global-1;
							
						function_delete_description(id_aux);

						actualiza_total();
						//}
						if($('#detalle_venta > tr').length == 1){
							muestra_boton_venta();
						}
					});
				});
			}else{
				alert("La cantidad a vender no puede ser superior al stock en sistema");
				//
				$(this).val("");

				$("#subtotal").val("");
			}
			
		}

	});

}

function muestra_boton_venta()
{
	$("#medio_pago").val("");
	$("#id_client_sell").val("0");
	$("#cliente_venta").remove();
	$("#save_area").fadeIn('slow');
}

function selecciona_medio()
{
	$("#medio_pago").on('change',function(){
		if($(this).val() == "Credito")
		{
			//muesta boton seleccionar cliente
			$("#save_area").append("<div id='cliente_venta'><button id='btn_busca_client' class='btn btn-lg btn-default'>Cliente</button></div>").promise().done(function(){
				function_search_clients();
			});
		}else{
			//oculta boton seleccionar cliente
			$("#cliente_venta").remove();
			$("#id_client_sell").val("0");
		}
	});
}

function actualiza_total()
{
	var arreglo = [];

	$('#detalle_venta > tr').each(function(index){
		//
		var subtotal = $(this).data("subtotal");

		arreglo.push(subtotal);

	});

	var sumatoria = 0;

	for (var i = 0; i < arreglo.length; i++) {
		sumatoria += arreglo[i];
	};

	$("#total_venta").val(sumatoria);
}

function function_guarda_venta()
{
	$("#btn_save_sale").on("click",function(e){
		e.preventDefault();

		var arreglo = [];

		$('#detalle_venta > tr').each(function(index){
			//
			var cantidad = $(this).data("cantidad");
			var articulo = $(this).data("id");
			var subtotal = $(this).data("subtotal");
			
			//guarda_detalle(cantidad,articulo);
			arreglo.push({'cantidad':cantidad,'articulo':articulo,'subtotal':subtotal});

		});
		var jsonString = JSON.stringify(arreglo);

		var total = $("#total_venta").val();

		var medio = $("#medio_pago").val();

		var id_cliente = $("#id_client_sell").val();

		//console.log(jsonString);

		var form = $("#form_sale");

		var url = form.attr('action').replace(':JSON',jsonString);

		url = url.replace(':TOTAL',total);

		url = url.replace(':MEDIO',medio);

		url = url.replace(':ID_CLIENT',id_cliente);

		var data = form.serialize();

		if(medio==="Credito"){
			if(id_cliente.length>0 && id_cliente>0){
				alert(id_cliente);
				$.post(url,data,function(result){
					alert(result);
					//console.log(result);
					if(result == "Venta Guardada")
					{
						location.reload();
					}
				});
			}else{
				alert("Debe indicar el cliente que esta comprando al credito");
			}
		}else{
			
			$.post(url,data,function(result){
				alert(result);
				//console.log(result);
				if(result == "Venta Guardada")
				{
					location.reload();
				}
			});
		}

	});
}

function function_search_clients()
{
	$("#btn_busca_client").on("click",function(e){
		e.preventDefault();
		var form = $("#form_clients_list");

		var url = form.attr('action');

		$.get(url,function(result){
			$("#ver_clientes").html(result).promise().done(function(){
				$('#id_modal').modal();
				client_selection();
			});
		});
	});
}

function client_selection()
{
	$(".btn_add_client").on('click',function(e){
		e.preventDefault();
		var fila = $(this).parents("tr");

		var id_cliente = fila.data("id");

		//carga datos a la vista general

		var form = $("#form_clients_data");

		var url = form.attr('action').replace(':ID',id_cliente);

		$.get(url,function(result){
			//console.log(result["vista"]);
			//var data = JSON.parse(result);
			$("#cliente_venta").append(result["vista"]).promise().done(function(){
				//cerrar modal
				$('#id_modal').modal('hide');
				$("#id_client_sell").val(result["id_cliente"]);
			});
		});

	});
}