var id_global = 0;
$(document).ready(function() {

    function_delete_description();
    function_load_article();
    function_guarda_compra();

    function_search_suppliers();
});

function function_delete_description(id)
{
	$("#"+id+" .btn-danger").on("click",function(e){
		e.preventDefault();

		/*var fila = $(this).parents("tr");

		var id_articulo = fila.data("id");

		var cantidad = fila.data("cantidad");

		alert(id_articulo+" "+cantidad);*/

		var fila = $(this).parents("tr");

		fila.fadeOut("slow",function(){
			fila.remove();
			calcularTotal();
			if($('#detalle_compra > tr').length == 0){
				//oculta boton compra
				$("#save_area").fadeOut();

			}
		});

		/*var form = $("#form_delete");

		var url = form.attr('action').replace(':DESCRIPTION_ID',id_borrar);

		var data = form.serialize();

		$.post(url,data,function(result){
			fila.fadeOut("slow");
			alert(result.message);
		}).fail(function(){
			alert("Ocurrio un error al intentar ejecutar la funcion");
		});*/
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

function add_detalle(bar_code,datos)
{
	$("#btn_load_article").on("click",function(e){
		e.preventDefault();
		var cantidad = $("#cantidad").val();
		var precio = $("#precio_cargado").val();

		/*var form = $("#form_insert");

		var url = form.attr('action').replace(':CODE',bar_code);

		url = url.replace(':ID_ARTICLE',id);

		var data = form.serialize();

		alert(url);*/
		if(cantidad>0 && precio>0)
		{
			
			var fila = $("#fila_tabla").html();

			fila = fila.replace("C.I.A",datos.article_id);
			fila = fila.replace("CodigoBarra",bar_code);
			fila = fila.replace("Descripcion",datos.description_article);
			fila = fila.replace("Detalle",datos.details);
			fila = fila.replace("Cantidad",cantidad);
			fila = fila.replace("Precio",precio);
			fila = fila.replace(":id_articulo",datos.article_id);
			fila = fila.replace(":cantidad_compra",cantidad);
			fila = fila.replace(":precio_compra",precio);
			fila = fila.replace(":id_fila",id_global);

			id_global++;

			$("#detalle_compra").append(fila).promise().done(function(){
				$("#datos_articulo").fadeOut("slow",function(){
					$(this).html("");
					$("#bar_code").val("");
					$("#bar_code").focus();
					//if($('#detalle_compra > tr').length-1 == 0){
					var id_aux = id_global-1;
						
					function_delete_description(id_aux);
					calcularTotal();
					//}
					if($('#detalle_compra > tr').length == 1){
						muestra_boton_compra();
					}
				});
			});
		}

	});

}
function muestra_boton_compra()
{
	$("#save_area").fadeIn();
}

var calcularTotal = function(){
	var sumatoria = 0;

	$('#detalle_compra > tr').each(function(index){
		//
		var cantidad = $(this).data("cantidad");
		
		var precio = $(this).data("precio");

		sumatoria += (cantidad*precio);

	});

	$("#totalCompra").val(sumatoria);
}

function function_guarda_compra()
{
	$("#btn_save_purchase").on("click",function(e){
		e.preventDefault();

		var supplier_id = $("#supplier_id").val();
		var documento = $("#document").val();
		var number = $("#number").val();
		var total = $("#totalCompra").val();

		var arreglo = [];

		$('#detalle_compra > tr').each(function(index){
			//
			var cantidad = $(this).data("cantidad");
			var articulo = $(this).data("id");
			var precio = $(this).data("precio");
			
			//guarda_detalle(cantidad,articulo);
			arreglo.push({'cantidad':cantidad,'articulo':articulo,'precio':precio});

		});
		var jsonString = JSON.stringify(arreglo);

		//console.log(jsonString);

		var form = $("#form_purchase");

		var url = form.attr('action').replace(':JSON',jsonString);

		url = url.replace(':ID_SUPPLIER',supplier_id);
		url = url.replace(':DOCUMENT',documento);
		url = url.replace(':NUMBER',number);
		url = url.replace(':TOTAL',total);

		var data = form.serialize();

		$.post(url,data,function(result){
			alert(result);
			if(result == "Compra Guardada")
			{
				location.reload();
			}
		});
	});
}

function function_search_suppliers()
{
	$("#btn_busca_prov").on("click",function(e){
		e.preventDefault();
		var form = $("#form_suppliers_list");

		var url = form.attr('action');

		$.get(url,function(result){
			$("#ver_proveedores").html(result).promise().done(function(){
				$('#id_modal').modal();
				supplier_selection();
			});
		});
	});
}

function supplier_selection()
{
	$(".btn_add_supplier").on('click',function(e){
		e.preventDefault();
		var fila = $(this).parents("tr");

		var id_proveedor = fila.data("id");

		//carga datos a la vista general

		var form = $("#form_suppliers_data");

		var url = form.attr('action').replace(':ID',id_proveedor);

		$.get(url,function(result){
			$("#datos_proveedor").html(result).promise().done(function(){
				//cerrar modal
				$('#id_modal').modal('hide');
			});
		});

	});
}