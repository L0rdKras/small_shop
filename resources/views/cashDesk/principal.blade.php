@extends('template')

@section('content')
<input type="hidden" id="ruta-data-venta" value="{{route('data-sale',':ID')}}">
<div class="container theme-showcase" role="main">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Caja</h3>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>TOTAL</th>
						<th>FECHA</th>
						<th></th>
					</tr>
				</thead>
				@foreach($waitings as $waiting)
				<thead>
					<tr id="wait_{{$waiting->id}}">
						<th>{{$waiting->id}}</th>
						<th>{{$waiting->Sale->total}}</th>
						<th>{{$waiting->created_at}}</th>
						<th>
							<a href="" data-id="{{$waiting->id}}" class="btn btn-success btn-paga">
								Pagar
							</a>
							<a href="" data-id="{{$waiting->id}}" class="btn btn-danger btn-anula">
								Anular
							</a>
						</th>
					</tr>
				</thead>
				@endforeach
			</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-pagar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmar Pago Orden N° <span id="numeroOrdenPagando"></span>	</h4>
      </div>

      {!! Form::open(array('route' => ['save-detail-caja'],'id'=>'formSaveSale','method'=>'POST')) !!}
      {!! Form::hidden('sale_id',null,array('id'=>'sale_id'))!!}
	  {!! Form::hidden('waiting_id',null,array('id'=>'waiting_id'))!!}
      <div class="modal-body">
      	<h4 class="row">
      		<label for="" class="label label-default col-md-4">Total Venta</label>
      		<span class="col-md-4" id="totalPorPagar"></span>
      	</h4>
      	<h4 class="row">
			{!! Form::label('documento_type', 'Documento',array('class' => 'label label-default col-md-4')); !!}
			{!! Form::select('documento_type',array('Boleta'=>'Boleta','Factura'=>'Factura'),'Boleta',array('id'=>'documento_type', 'class'=>'col-md-4')); !!}
      	</h4>
      	<h4 class="row">
			{!! Form::label('ticket', 'Numero Documento',array('class' => 'label label-default col-md-4')); !!}
			{!! Form::text('ticket',null,array('id'=>'ticket', 'class'=>'col-md-4')); !!}
      	</h4>
      	<h4 class="row">
			{!! Form::label('payment_method', 'Medio de Pago',array('class' => 'label label-default col-md-4')); !!}
			{!! Form::select('payment_method',array(''=>'','Efectivo'=>'Efectivo','Tarjeta'=>'Tarjeta','Credito'=>'Credito'),null,array('id'=>'payment_method', 'class'=>'col-md-4')); !!}
      	</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-confirma-pago">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
	  {!! Form::close() !!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('scripts')
	<script src="{{ asset('js/cash_desk.js')}}"></script>
@endsection