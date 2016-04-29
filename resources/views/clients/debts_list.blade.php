@extends('template')

@section('content')
<div class="container theme-showcase" role="main">

    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Deudas de {{ $client->name}}</h3>
            </div>    
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Deudas</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>N° Venta</th>
		                <th>Documento</th>
		                <th>Departamento</th>
		                <th>Unidad</th>
		                <th>Monto</th>
		                <th>Estado</th>		                
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($client->debts as $debt)
		              <tr data-id="{{$debt->id}}">
		                <td>{{$debt->sale->id}}</td>
		                <td>{{$debt->sale->DeskDetail->document_type}}-{{$debt->sale->DeskDetail->ticket}}</td>
		                <td>{{$debt->sale->Debt->department}}</td>
		                <td>{{$debt->sale->Debt->unit}}</td>
		                <td>{{$debt->total}}</td>
		                @if($debt->status == 'Pendiente')
			                <td>
			                	<a class="btn btn-success" href="{{ route('pagar_deuda', [$debt->id]) }}">Pagar</a>
			                </td>
		                @else
		                	<td>{{ $debt->status}}</td>
		                @endif
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>


@endsection