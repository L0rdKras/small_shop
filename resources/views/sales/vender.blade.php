@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="page-hader">
    	<div class="row">
    		
	          
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
		              <h3 class="panel-title">Detalle venta</h3>
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
				                <th>Precio</th>
				                <th>Subtotal</th>
				                <th>Editar</th>
				              </tr>
				            </thead>
				            <tbody id="detalle_venta">
				              
				            </tbody>
				        </table>
		            </div>
		      </div>

		    <div class="panel-body" id="save_area" style="display: none;">
				{!! Form::open(array('route' => ['save_purchase'])) !!}
			    	<h3>
			    		{!! Form::label('total_venta', 'Total Venta',array('class' => 'label label-default')); !!}
	    				{!! Form::text('total_venta',null,array('id'=>'total_venta','readonly'=>'readonly')); !!}
			    		{!! Form::submit('Guardar Venta',array('class' => 'btn btn-lg btn-default','id'=>'btn_save_sale')); !!}
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
{!! Form::open(array('route' => ['save_sale',':JSON',':TOTAL'],'id'=>'form_sale','method'=>'POST')) !!}
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
	    		{!! Form::label('cantidad', 'Cantidad',array('class' => 'label label-default')); !!}
	    		{!! Form::text('cantidad',null,array('id'=>'cantidad','size'=>'4')); !!}
	    		{!! Form::label('precio', 'Precio',array('class' => 'label label-default')); !!}
	    		{!! Form::text('precio',null,array('id'=>'precio','readonly'=>'readonly')); !!}
	    		{!! Form::label('subtotal', 'Subtotal',array('class' => 'label label-default')); !!}
	    		{!! Form::text('subtotal',null,array('id'=>'subtotal','readonly'=>'readonly')); !!}
	    		{!! Form::submit('Agregar',array('class' => 'btn btn-lg btn-default','id'=>'btn_load_article')); !!}
	    	</h3>
		{!! Form::close() !!}
    </div>
</template>

<template id="fila_tabla">
	<tr class="fila_detalle" data-subtotal=":subtotal" data-id=":id_articulo" data-cantidad=":cantidad_venta" id=":id_fila">
		<td>C.I.A</td>
		<td>CodigoBarra</td>
		<td>Descripcion</td>
		<td>Detalle</td>
		<td>Cantidad</td>
		<td>Precio</td>
		<td>Subtotal</td>
		<td><a class="btn btn-danger">Borrar</a></td>
	</tr>
</template>

@endsection

@section('scripts')

<script src="{{ asset('js/sell_register.js')}}"></script>

@endsection