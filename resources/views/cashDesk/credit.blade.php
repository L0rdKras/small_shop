@extends('template')

@section('content')
<input type="hidden" id="ruta-data-venta" value="{{route('data-sale',':ID')}}">
<input type="hidden" id="ruta-client-data" value="{{route('client-data',':ID')}}">
<div class="container theme-showcase" role="main">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Pago al credito</h3>
		</div>
		<div class="panel-body">
			<h4 class="row">
				<label for="" class="label label-default col-md-4">
					Total Venta
				</label>
				<span class="col-md-4">
					${{$waiting->Sale->total}}
				</span>
			</h4>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Cliente <a href="" id="btn-buscar-cliente" class="btn btn-success" data-toggle="modal" data-target="#modal-clientes">Buscar</a></h3>
		</div>
		<div class="panel-body" id="DataCliente">
			<!--data venta-->
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Datos Documento</h3>
		</div>
		<div class="panel-body" id="DataCliente">
		{!! Form::open(array('route' => ['save-credit-sale'],'method'=>'POST','id'=>'formSaveSale')) !!}
		{!! Form::hidden('client_id',null,array('id'=>'client_id')); !!}
		{!! Form::hidden('waiting_id',$waiting->id,array('id'=>'waiting_id')); !!}
		{!! Form::hidden('sale_id',$waiting->Sale->id,array('id'=>'sale_id')); !!}
		{!! Form::hidden('payment_method','Credito',array('id'=>'payment_method')); !!}
		<h4 class="row">
			{!! Form::label('document_type', 'Documento',array('class' => 'label label-default col-md-4')); !!}
			{!! Form::select('document_type',array('Boleta'=>'Boleta','Factura'=>'Factura'),'Boleta',array('id'=>'document_type', 'class'=>'col-md-4')); !!}
      	</h4>
      	<h4 class="row">
			{!! Form::label('ticket', 'Numero Documento',array('class' => 'label label-default col-md-4')); !!}
			{!! Form::text('ticket',null,array('id'=>'ticket', 'class'=>'col-md-4')); !!}
		</h4>
		<h4 class="row">
			{!! Form::label('department', 'Departamento',array('class' => 'label label-default col-md-4')); !!}
			{!! Form::text('department',null,array('id'=>'department', 'class'=>'col-md-4')); !!}
      	</h4>
      	<h4 class="row">
			{!! Form::label('unit', 'Unidad',array('class' => 'label label-default col-md-4')); !!}
			{!! Form::text('unit',null,array('id'=>'unit', 'class'=>'col-md-4')); !!}
		</h4>
		<h4>
			{!! Form::submit('Confirmar',array('id'=>'btn-confirmar','class'=>'btn btn-success'))!!}
		</h4>
		{!! Form::close() !!}
		</div>
	</div>
</div>

<template id="template-data-client">
	<h4 class="row">
		<label for="" class="label label-default col-md-4">
			Nombre
		</label>
		<span class="col-md-4">
			:NOMBRE
		</span>
	</h4>
</template>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-clientes">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Clientes</h4>
      </div>

      <div class="modal-body" style="height:400px;overflow:auto;">
      	<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>RUT</th>
					<th>NOMBRE</th>
					<th></th>
				</tr>
			</thead>
			@foreach($clients as $client)
			<thead>
				<tr id="wait_{{$client->id}}">
					<th>{{$client->id}}</th>
					<th>{{$client->rut}}</th>
					<th>{{$client->name}}</th>
					<th>
						<a href="" data-id="{{$client->id}}" class="btn btn-success btn-select-client" data-dismiss="modal">
							Seleccionar
						</a>
					</th>
				</tr>
			</thead>
			@endforeach
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('scripts')
	<script src="{{ asset('js/credit_pay.js')}}"></script>
@endsection