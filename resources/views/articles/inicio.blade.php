@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Articulos</h1>
        <p>Defina los tipos de articulos que vendera, y cree su propio inventario personalizado</p>
    </div>

    <div class="page-hader">
    	<div class="row">
    		<div class="col-sm-4">
	          <div class="list-group">
	            <a href="#" class="list-group-item active">
	              Opciones
	            </a>
	            <a href="{{route('descripciones')}}" class="list-group-item">Definir descripciones de articulos</a>
	            <a href="{{route('crear_articulos')}}" class="list-group-item">Crear articulos de la tienda</a>
	            <a href="#" class="list-group-item">Agregar códigos de barra</a>
	            
	          </div>
	        </div><!-- /.col-sm-4 -->
    	</div>
    </div>
</div>
@endsection