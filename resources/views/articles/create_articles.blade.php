@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Articulos Tienda</h1>
        <p>Ingrese los articulos que vendera en su tienda</p>
    </div>

    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Crear articulo</h3>
            </div>
            <div class="panel-body">
		    	{!! Form::open(array('route' => 'guarda_articulo')) !!}
		    	<h3>
		    		{!! Form::label('article_description_id', 'Descripcion',array('class' => 'label label-default')); !!}
		    		{!! Form::select('article_description_id', $descriptions); !!}
		    	</h3>
		    	<h3>
		    		{!! Form::label('details', 'Detalles',array('class' => 'label label-default')); !!}
		    		{!! Form::text('details'); !!}		    		
		    	</h3>
		    	<h3>
		    		{!! Form::label('price', 'Precio',array('class' => 'label label-default')); !!}
		    		{!! Form::text('price'); !!}
		    		{!! Form::submit('Guardar',array('class' => 'btn btn-lg btn-default')); !!}
		    	</h3>
				{!! Form::close() !!}
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
		                <th>Descipción</th>
		                <th>Detalles</th>
		                <th>Precio</th>
		                <th>Editar</th>
		                <th>Info</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($articles as $article)
		              <tr data-id="{{$article->id}}">
		                <td>{{$article->id}}</td>
		                <td>{{$article->article_description->name}}</td>
		                <td>{{$article->details}}</td>
		                <td>{{$article->price}}</td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('editar_articulo', [$article->id]) }}">Editar</a>
		                	<a class="btn btn-success" href="{{ route('codigo_de_barra', [$article->id]) }}">Bar Code</a>
		                	<a class="btn btn-danger">Borrar</a>
		                </td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('compras_articulo', [$article->id]) }}">Compras</a>
		                	<a class="btn btn-success" href="{{ route('ventas_articulo', [$article->id]) }}">Ventas</a>
		                </td>
		              </tr>
		              @endforeach
		              {!! $articles->render() !!}
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>

{!! Form::open(array('route' => ['borra_articulo',':DESCRIPTION_ID'],'id'=>'form_delete','method'=>'DELETE')) !!}
{!! Form::close() !!}

@endsection

@section('scripts')

<script>
	$(document).ready(function() {
    
	    function_delete_description();	    
	});

	function function_delete_description()
	{
		$(".btn-danger").on("click",function(e){
			e.preventDefault();

			var fila = $(this).parents("tr");

			var id_borrar = fila.data("id");

			var form = $("#form_delete");

			var url = form.attr('action').replace(':DESCRIPTION_ID',id_borrar);

			var data = form.serialize();

			$.post(url,data,function(result){
				fila.fadeOut("slow");
				alert(result.message);
			}).fail(function(){
				alert("Ocurrio un error al intentar ejecutar la funcion");
			});
		});
	}

</script>

@endsection