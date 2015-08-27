@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	
    <div class="page-hader">
    	<div class="panel panel-default">
    		<div class="panel-heading">
              <h3 class="panel-title">Datos articulo</h3>
            </div>
            <div class="panel-body">
            	<h3>
            		<span class="label label-default">Descripcion : </span>
            		<span class="label label-primary">{{$article->article_description->name}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Detalles : </span>
            		<span class="label label-primary">{{$article->details}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Precio : </span>
            		<span class="label label-primary">${{$article->price}}</span>
            	</h3>
            </div>
            <div class="panel-heading">
              <h3 class="panel-title">Ingreso codigo</h3>
            </div>
            <div class="panel-body">
		    	{!! Form::open(array('route' => ['guarda_codigo'])) !!}
		    	
		    	<h3>
		    		{!! Form::label('code', 'Codigo de Barra',array('class' => 'label label-default')); !!}
		    		{!! Form::text('code'); !!}
		    		{!! Form::hidden('article_id',$article->id); !!}
		    		{!! Form::submit('Guardar',array('class' => 'btn btn-lg btn-default')); !!}
		    	</h3>
				{!! Form::close() !!}
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Codigos asociados</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>Codigo</th>
		                <th>Editar</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($article->barrcodes as $barrcode)
		              <tr data-id="{{$article->id}}">
		                <td>{{$barrcode->id}}</td>
		                <td>{{$barrcode->code}}</td>		                
		                <td>
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

{!! Form::open(array('route' => ['borra_codigo',':DESCRIPTION_ID'],'id'=>'form_delete','method'=>'DELETE')) !!}
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