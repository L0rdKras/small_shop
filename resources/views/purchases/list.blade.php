@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Lista de Compras</h1>
        <p>Historial de las compras de la tienda</p>
    </div>

    <div class="page-hader">
    	

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Compras</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>Proveedor</th>
		                <th>Fecha</th>
		                <th>Ver</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($purchases as $purchase)
		              <tr data-id="{{$purchase->id}}">
		                <td>{{$purchase->id}}</td>
		                <td>{{$purchase->supplier->name}}</td>
		                <td>{{date_format($purchase->created_at, 'd/m/Y')}}</td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('info_compra', [$purchase->id]) }}">Ver</a>
		                </td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
		        {!! $purchases->render() !!}
            </div>
        </div>
    </div>
</div>