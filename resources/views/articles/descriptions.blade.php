@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Descripciones de Articulos</h1>
        <p>Ingrese los tipos de articulos que vendera en su tienda</p>
    </div>

    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Crear descripción</h3>
            </div>
            <div class="panel-body">
		    	{!! Form::open(array('route' => 'salva_descripcion')) !!}
		    	<h3>
		    		{!! Form::label('name', 'Nombre',array('class' => 'label label-default')); !!}
		    		{!! Form::text('name'); !!}
		    		{!! Form::submit('Guardar',array('class' => 'btn btn-lg btn-default')); !!}
		    	</h3>
				{!! Form::close() !!}
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Descripciónes</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>Nombre</th>
		                <th>Edición</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($descriptions as $description)
		              <tr data-id="{{$description->id}}">
		                <td>{{$description->id}}</td>
		                <td>{{$description->name}}</td>
		                <td>
		                	<a class="btn btn-info" href="{{ route('editar_descripcion', [$description->id]) }}">Editar</a>
		                	<a class="btn btn-danger">Borrar</a>
		                </td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>

{!! Form::open(array('route' => ['borra_descripcion',':DESCRIPTION_ID'],'id'=>'form_delete','method'=>'DELETE')) !!}
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