@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Ventas</h1>
        <p>Registre sus ventas, y controle el stock de salida</p>
    </div>

    <div class="page-hader">
    	<div class="row">
    		<div class="col-sm-4">
	          <div class="list-group">
	            <a href="#" class="list-group-item active">
	              Opciones
	            </a>
	            <a href="{{route('registro_ventas')}}" class="list-group-item">Registro Ventas</a>
	            	            
	          </div>
	        </div><!-- /.col-sm-4 -->
    	</div>
    </div>
</div>
@endsection