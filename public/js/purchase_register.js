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

		/*var form = $("#form_insert");

		var url = form.attr('action').replace(':CODE',bar_code);

		url = url.replace(':ID_ARTICLE',id);

		var data = form.serialize();

		alert(url);*/
		if(cantidad>0)
		{
			
			var fila = $("#fila_tabla").html();

			fila = fila.replace("C.I.A",datos.article_id);
			fila = fila.replace("CodigoBarra",bar_code);
			fila = fila.replace("Descripcion",datos.description_article);
			fila = fila.replace("Detalle",datos.details);
			fila = fila.replace("Cantidad",cantidad);
			fila = fila.replace(":id_articulo",datos.article_id);
			fila = fila.replace(":cantidad_compra",cantidad);
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

function function_guarda_compra()
{
	$("#btn_save_purchase").on("click",function(e){
		e.preventDefault();

		var arreglo = [];

		$('#detalle_compra > tr').each(function(index){
			//
			var cantidad = $(this).data("cantidad");
			var articulo = $(this).data("id");
			
			//guarda_detalle(cantidad,articulo);
			arreglo.push({'cantidad':cantidad,'articulo':articulo});

		});
		var jsonString = JSON.stringify(arreglo);

		console.log(jsonString);
	});
}

function guarda_detalle(cantidad,articulo)
{
	var form = $("#form_purchase");

	var url = form.attr('action').replace(':QUANTITY',cantidad);

	url = url.replace(':ID_ARTICLE',articulo);

	var data = form.serialize();

	$.post(url,data,function(result){
		console.log(result);
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

		console.log(id_proveedor);

		//carga datos a la vista general

	});
}