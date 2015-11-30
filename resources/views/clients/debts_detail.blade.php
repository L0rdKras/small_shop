@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	
    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Datos cliente</h3>
            </div>
            <div class="panel-body">
		    	//data cliente
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Datos venta</h3>
            </div>
            <div class="panel-body">
		    	//data venta
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Detalle Venta</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>Articulo</th>
		                <th>Detalle</th>
		                <th>Precio</th>
		                <th>Cantidad</th>
		                <th>Subtotal</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($debt->sale->saledetails as $detail)
		              <tr>
		                <td>{{$detail->article->article_description->name}}</td>
		                <td>{{$detail->article->details}}</td>
		                <td>{{$detail->article->prize}}</td>
		                <td>{{$detail->quantity}}</td>
		                <td>{{$detail->subtotal}}</td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>


@endsection