@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Proveedores</h1>
        <p>Ingrese cuales son los proveedores de su tienda</p>
    </div>

    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Crear proveedor</h3>
            </div>
            <div class="panel-body">
		    	{!! Form::open(array('route' => 'salva_proveedor')) !!}
		    	<h3>
		    		{!! Form::label('rut', 'RUT',array('class' => 'label label-default')); !!}
		    		{!! Form::text('rut'); !!}
		    		{!! Form::label('name', 'Nombre',array('class' => 'label label-default')); !!}
		    		{!! Form::text('name'); !!}
		    		{!! Form::submit('Guardar',array('class' => 'btn btn-lg btn-default')); !!}
		    	</h3>
				{!! Form::close() !!}
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Proveedores</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>RUT</th>
		                <th>Nombre</th>
		                <th>Edición</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($suppliers as $supplier)
		              <tr data-id="{{$supplier->id}}">
		                <td>{{$supplier->id}}</td>
		                <td>{{$supplier->rut}}</td>
		                <td>{{$supplier->name}}</td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('editar_proveedor', [$supplier->id]) }}">Editar</a>		                	
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

@section('scripts')

<script src="{{ asset('js/suppliers_register.js')}}"></script>

@endsection