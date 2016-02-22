@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Presupuestos.</h1>
        <p>Presupuestos registrados</p>
    </div>

    <div class="page-hader">
    	

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Presupuestos</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>Cliente</th>
		                <th>Total</th>
		                <th>Fecha</th>
		                <th>Ver</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($budgets as $budget)
		              <tr data-id="{{$budget->id}}">
		                <td>{{$budget->id}}</td>
		                <td>{{$budget->client->name}}</td>
		                <td>{{$budget->total}}</td>
		                <td>{{date_format($budget->created_at, 'd/m/Y')}}</td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('info_budget', [$budget->id]) }}">Ver</a>
		                	<a class="btn btn-info" href="{{ route('print_budget', [$budget->id]) }}">Impr.</a>
		                </td>
		              </tr>
		              @endforeach
		        		{!! $budgets->render() !!}
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>