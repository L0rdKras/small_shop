@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Clientes</h1>
        <p>Ingrese cuales son los clientes de su tienda</p>
    </div>

    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Registrar cliente</h3>
            </div>
            <div class="panel-body">
		    	{!! Form::open(array('route' => 'guardar_cliente')) !!}
		    	<h3>
		    		<p>{!! Form::label('rut', 'RUT',array('class' => 'label label-default')); !!}
		    		{!! Form::text('rut'); !!}</p>
		    		<p>{!! Form::label('name', 'Nombre',array('class' => 'label label-default')); !!}
		    		{!! Form::text('name'); !!}</p>
		    		<p>{!! Form::label('phone', 'Telefono',array('class' => 'label label-default')); !!}
		    		{!! Form::text('phone'); !!}</p>
		    		{!! Form::submit('Guardar',array('class' => 'btn btn-lg btn-default')); !!}
		    	</h3>
				{!! Form::close() !!}
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Clientes</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>RUT</th>
		                <th>Nombre</th>
		                <th>Teléfono</th>
		                <th>Edición</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($clients as $client)
		              <tr data-id="{{$client->id}}">
		                <td>{{$client->id}}</td>
		                <td>{{$client->rut}}</td>
		                <td>{{$client->name}}</td>
		                <td>{{$client->phone}}</td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('editar_cliente', [$client->id]) }}">Editar</a>
		                	<a class="btn btn-warning" href="{{ route('deudas_cliente', [$client->id]) }}">Deudas</a>
		                </td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>


@endsection