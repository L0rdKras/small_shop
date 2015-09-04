@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	
    <div class="page-hader">
    	<div class="panel panel-default">
    		<div class="panel-heading">
              <h3 class="panel-title">Datos articulo</h3>
            </div>
            <div class="panel-body">
            	<h3>
            		<span class="label label-default">Descripcion : </span>
            		<span class="label label-primary">{{$article->article_description->name}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Detalles : </span>
            		<span class="label label-primary">{{$article->details}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Precio : </span>
            		<span class="label label-primary">${{$article->price}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Stock Actual : </span>
            		<span class="label label-primary">{{$article->stock}}</span>
            	</h3>
            </div>
            
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Ventas del articulo</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		              	<th>Numero Venta</th>
		                <th>Fecha</th>
		                <th>Cantidad</th>
		                <th>Subtotal</th>
		                
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($article->saledetails as $saledetails)
		              <tr>
		              	<td>{{$saledetails->sale->id}}</td>
		                <td>{{date_format($saledetails->sale->created_at,'d-m-Y')}}</td>
		                <td>{{$saledetails->quantity}}</td>
		                <td>{{$saledetails->subtotal}}</td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>

@endsection