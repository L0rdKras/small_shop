@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	

    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">

              <h3 class="panel-title">Editar proveedor</h3>
            </div>
            <div class="panel-body">

		    	{!! Form::open(array('route' => ['actualiza_proveedor',$supplier->id], 'method' => 'PATCH')) !!}
		    	<h3>
		    		{!! Form::label('rut', 'RUT',array('class' => 'label label-default')); !!}
		    		{!! Form::text('rut',$supplier->rut); !!}
		    		{!! Form::label('name', 'Nombre',array('class' => 'label label-default')); !!}
		    		{!! Form::text('name',$supplier->name); !!}
		    		{!! Form::submit('Guardar',array('class' => 'btn btn-lg btn-default')); !!}
		    	</h3>
				{!! Form::close() !!}
            </div>
        </div>        
    </div>
</div>

@endsection