@extends('template')

@section('content')
<input type="hidden" id="ruta-data-venta" value="{{route('data-sale',':ID')}}">

<div class="container theme-showcase" role="main">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Monto Inicial</h3>
		</div>
		<div class="panel-body">
			<h4 class="row">
				<label for="" class="label label-default col-md-4">
					Total(sencillo)
				</label>
				<span class="col-md-4">
					${{$cashDesk->total}}
				</span>
				<span class="col-md-4"></span>
			</h4>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Ventas al credito</h3>
		</div>
		<div class="panel-body">
			<h4 class="row">
				<label for="" class="label label-default col-md-4">
					Total
				</label>
				<span class="col-md-4">
					${{$sumCredit}}
				</span>
				<span class="col-md-4"></span>
			</h4>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Ventas efectivo</h3>
		</div>
		<div class="panel-body">
			<h4 class="row">
				<label for="" class="label label-default col-md-4">
					Total
				</label>
				<span class="col-md-4">
					${{$sumCash}}
				</span>
				<span class="col-md-4"></span>
			</h4>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Ventas tarjeta de credito</h3>
		</div>
		<div class="panel-body">
			<h4 class="row">
				<label for="" class="label label-default col-md-4">
					Total
				</label>
				<span class="col-md-4">
					${{$sumCreditCard}}
				</span>
				<span class="col-md-4"></span>
			</h4>
		</div>
	</div>	

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Confirmar Cierre</h3>
		</div>
		<div class="panel-body">
			{!! Form::open(array('route' => ['save-close'],'method'=>'POST','id'=>'formSaveClose')) !!}
			<h4 class="row">
				<label for="" class="label label-default col-md-4">
					Total Ventas
				</label>
				<span class="col-md-4">
					${{$sumCreditCard+$sumCredit+$sumCash}}
				</span>
				<span class="col-md-2"></span>
				<a href="" class="btn btn-warning col-md-2" id="btnCierre">Cerrar</a>
			</h4>

	      	<h4 class="row">
				{!! Form::label('total', 'Monto Inicial',array('class' => 'label label-default col-md-4')); !!}
				{!! Form::text('total',null,array('id'=>'total', 'class'=>'col-md-4')); !!}
			</h4>
			{!! Form::close() !!}
		</div>
	</div>	

</div>

@endsection

@section('scripts')
	<script src="{{ asset('js/close.js')}}"></script>
@endsection