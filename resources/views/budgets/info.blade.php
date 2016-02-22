@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	
    <div class="page-hader">
    	<div class="panel panel-default">
    		<div class="panel-heading">
              <h3 class="panel-title">Datos Presupuesto</h3>
            </div>
            <div class="panel-body">
            	<h3>
            		<span class="label label-default">Cliente : </span>
            		<span class="label label-primary">{{$budget->client->name}}</span>
            	</h3>            	
            	<h3>
            		<span class="label label-default">Fecha Ingreso : </span>
            		<span class="label label-primary">{{date_format($budget->created_at, 'd/m/Y')}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Total : </span>
            		<span class="label label-primary">{{$budget->total}}</span>
            	</h3>
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Articulos</h3>
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
		              @foreach($budget->budgetDetails as $budgetdetail)
		              <tr>
		                <td>{{$budgetdetail->id}}</td>
		                <td>{{$budgetdetail->article->article_description->name}}</td>
		                <td>{{$budgetdetail->article->details}}</td>
		                <td>{{$budgetdetail->quantity}}</td>
		                <td>{{$budgetdetail->unit_price()}}</td>
		                <td>{{$budgetdetail->subtotal}}</td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>