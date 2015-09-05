@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Lista de Ventas.</h1>
        <p>Historial de las ventas de la tienda</p>
    </div>

    <div class="page-hader">
    	

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Ventas</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>Total</th>
		                <th>Fecha</th>
		                <th>Ver</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($sales as $sale)
		              <tr data-id="{{$sale->id}}">
		                <td>{{$sale->id}}</td>
		                <td>{{$sale->total}}</td>
		                <td>{{date_format($sale->created_at, 'd/m/Y')}}</td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('info_venta', [$sale->id]) }}">Ver</a>
		                	<a class="btn btn-info" href="{{ route('imp_venta', [$sale->id]) }}">Impr.</a>
		                </td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
		        {!! $sales->render() !!}
            </div>
        </div>
    </div>
</div>