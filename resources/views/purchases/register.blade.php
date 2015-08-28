@extends('template')

@section('content')
<div class="modal fade" id="id_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Seleccion de Proveedores</h4>
      </div>
      <div class="modal-body" id="ver_proveedores">
        <p>Tabla proveedores&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="container theme-showcase" role="main">
	<div class="page-hader">
    	<div class="row">
    		
	          <div class="panel panel-default">
		        <div class="panel-heading">
		          <h3 class="panel-title">Proveedor</h3>
		        </div>
		        <div class="panel-body">
		          <button id="btn_busca_prov" type="button" class="btn btn-lg btn-success">
		          	Seleccionar Proveedor
		          </button>
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
{!! Form::open(array('route' => ['show_list_suppliers'],'id'=>'form_suppliers_list','method'=>'GET')) !!}
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

<script src="{{ asset('js/purchase_register.js')}}"></script>

@endsection