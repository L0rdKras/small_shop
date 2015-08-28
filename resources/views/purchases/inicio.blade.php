@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Compras</h1>
        <p>Ingrese las compras de mercaderia y mantenga actualizado su stock</p>
    </div>

    <div class="page-hader">
    	<div class="row">
    		<div class="col-sm-4">
	          <div class="list-group">
	            <a href="#" class="list-group-item active">
	              Opciones
	            </a>
	            <a href="{{route('proveedores')}}" class="list-group-item">Registro Proveedores</a>
	            <a href="{{route('registro_compras')}}" class="list-group-item">Registro Compra</a>
	            	            
	          </div>
	        </div><!-- /.col-sm-4 -->
    	</div>
    </div>
</div>
@endsection