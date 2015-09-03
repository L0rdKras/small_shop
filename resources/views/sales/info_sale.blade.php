@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	
    <div class="page-hader">
    	<div class="panel panel-default">
    		<div class="panel-heading">
              <h3 class="panel-title">Datos Venta</h3>
            </div>
            <div class="panel-body">
            	
            	<h3>
            		<span class="label label-default">Fecha Ingreso : </span>
            		<span class="label label-primary">{{date_format($sale->created_at, 'd/m/Y')}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Total : </span>
            		<span class="label label-primary">{{$sale->total}}</span>
            	</h3>
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Articulos Vendidos</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>Descripcion</th>
		                <th>Detalle</th>
		                <th>Cantidad</th>
		                <th>P.Unitario</th>
		                <th>Subtotal</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($sale->saledetails as $saledetail)
		              <tr>
		                <td>{{$saledetail->id}}</td>
		                <td>{{$saledetail->article->article_description->name}}</td>
		                <td>{{$saledetail->article->details}}</td>
		                <td>{{$saledetail->quantity}}</td>
		                <td>{{$saledetail->unit_price()}}</td>
		                <td>{{$saledetail->subtotal}}</td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>