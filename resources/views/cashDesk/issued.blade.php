@extends('template')

@section('content')
<input type="hidden" id="ruta-data-venta" value="{{route('data-sale',':ID')}}">
<div class="container theme-showcase" role="main">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>Caja: Documentos Emitidos</h3>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>DOCUMENTO</th>
						<th>NUMERO DOCUMENTO</th>
						<th>MEDIO PAGO</th>
						<th>TOTAL</th>
						<th>FECHA</th>
						<th></th>
					</tr>
				</thead>
				@foreach($cashDesk->DeskDetail as $detail)
				<thead>
					<tr id="wait_{{$detail->id}}">
						<th>{{$detail->id}}</th>
						<th>{{$detail->document_type}}</th>
						<th>{{$detail->ticket}}</th>
						<th>{{$detail->payment_method}}</th>
						<th>{{$detail->Sale->total}}</th>
						<th>{{$detail->created_at}}</th>
						<th>

						</th>
					</tr>
				</thead>
				@endforeach
			</table>
		</div>
	</div>
</div>

@endsection

@section('scripts')
	<script src="{{ asset('js/cash_desk.js')}}"></script>
@endsection