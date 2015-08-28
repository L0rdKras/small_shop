@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="page-hader">
    	<div class="row">
    		
	          <div class="panel panel-default">
		        <div class="panel-heading">
		          <h3 class="panel-title">Proveedor</h3>
		        </div>
		        <div class="panel-body">
		          Datos Proveedor
		        </div>
		      </div>
		      <div id="panel_articulo" class="panel panel-default">
		        <div class="panel-heading">
		          <h3 class="panel-title">Articulo</h3>
		        </div>
		        <div class="panel-body">
		          	{!! Form::open(array('route' => ['actualiza_descripcion'])) !!}
			    	<h3>
			    		{!! Form::label('code', 'Codigo',array('class' => 'label label-default')); !!}
			    		{!! Form::text('code',null,array('id'=>'bar_code')); !!}
			    		{!! Form::submit('Cargar',array('class' => 'btn btn-lg btn-default','id'=>'btn_load_code')); !!}
			    	</h3>
					{!! Form::close() !!}
		        </div>
		        <div id="datos_articulo"></div>
		      </div>

		      <div class="panel panel-default">
		        	<div class="panel-heading">
		              <h3 class="panel-title">Detalle compra</h3>
		            </div>
		            <div class="panel-body">
		            	<table class="table table-striped">
				            <thead>
				              <tr>
				                <th>C.I.A</th>
				                <th>Codigo de barra</th>
				                <th>Descripcion</th>
				                <th>Detalle</th>
				                <th>Cantidad</th>
				                <th>Editar</th>
				              </tr>
				            </thead>
				            <tbody id="detalle_compra">
				              
				            </tbody>
				        </table>
		            </div>
		      </div>

		    <div class="panel-body" id="save_area" style="display: none;">
				{!! Form::open(array('route' => ['actualiza_descripcion'])) !!}
			    	<h3>
			    		{!! Form::submit('Guardar Compra',array('class' => 'btn btn-lg btn-default','id'=>'btn_save_purchase')); !!}
			    	</h3>
				{!! Form::close() !!}
		    </div>
	        
    	</div>
    </div>
</div>

{!! Form::open(array('route' => ['load_code',':CODE'],'id'=>'form_load','method'=>'GET')) !!}
{!! Form::close() !!}
{!! Form::open(array('route' => ['insert_article',':CODE',':ID_ARTICLE'],'id'=>'form_insert','method'=>'POST')) !!}
{!! Form::close() !!}
{!! Form::open(array('route' => ['save_purchase',':QUANTITY',':ID_ARTICLE'],'id'=>'form_purchase','method'=>'POST')) !!}
{!! Form::close() !!}

<template id="template_datos_articulo">
	<div class="panel-body">
		{!! Form::open(array('route' => ['actualiza_descripcion'])) !!}
	    	<h3>
	    		{!! Form::label('descripcion_cargada', 'Descripción',array('class' => 'label label-default')); !!}
	    		{!! Form::text('descripcion_cargada',null,array('id'=>'descripcion_cargada','readonly'=>'readonly')); !!}
	    	</h3>
	    	<h3>
	    		{!! Form::label('detalle_cargado', 'Detalle',array('class' => 'label label-default')); !!}
	    		{!! Form::text('detalle_cargado',null,array('id'=>'detalle_cargado','readonly'=>'readonly')); !!}
	    	</h3>
	    	<h3>
	    		{!! Form::label('stock_cargado', 'Stock',array('class' => 'label label-default')); !!}
	    		{!! Form::text('stock_cargado',null,array('id'=>'stock_cargado','readonly'=>'readonly')); !!}
	    	</h3>
	    	<h3>	
	    		{!! Form::label('cantidad', 'Cantidad Compra',array('class' => 'label label-default')); !!}
	    		{!! Form::text('cantidad',null,array('id'=>'cantidad')); !!}
	    		{!! Form::submit('Agregar',array('class' => 'btn btn-lg btn-default','id'=>'btn_load_article')); !!}
	    	</h3>
		{!! Form::close() !!}
    </div>
</template>

<template id="fila_tabla">
	<tr class="fila_detalle" data-id=":id_articulo" data-cantidad=":cantidad_compra" id=":id_fila">
		<td>C.I.A</td>
		<td>CodigoBarra</td>
		<td>Descripcion</td>
		<td>Detalle</td>
		<td>Cantidad</td>
		<td><a class="btn btn-danger">Borrar</a></td>
	</tr>
</template>

@endsection

@section('scripts')

<script>
	var id_global = 0;
	$(document).ready(function() {
    
	    function_delete_description();
	    function_load_article();
	    function_guarda_compra();
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

</script>

@endsection