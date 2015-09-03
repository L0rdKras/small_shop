var id_global = 0;
$(document).ready(function() {

    function_delete_description();
    function_load_article();
    function_guarda_venta();
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
	$("#save_area").fadeIn();
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

		//console.log(jsonString);

		var form = $("#form_sale");

		var url = form.attr('action').replace(':JSON',jsonString);

		url = url.replace(':TOTAL',total);

		var data = form.serialize();

		$.post(url,data,function(result){
			alert(result);
			if(result == "Venta Guardada")
			{
				location.reload();
			}
		});
	});
}