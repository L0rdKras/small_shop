@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	

    <div class="page-hader">
    	<div class="panel panel-default">
            <div class="panel-heading">

              <h3 class="panel-title">Editar articulo</h3>
            </div>
            <div class="panel-body">

		    	{!! Form::open(array('route' => ['actualiza_articulo',$article->id], 'method' => 'PATCH')) !!}
		    	<h3>
		    		{!! Form::label('article_description_id', 'Descripcion',array('class' => 'label label-default')); !!}
		    		{!! Form::select('article_description_id', $descriptions,$article->article_description->name); !!}
		    	</h3>
		    	<h3>
		    		{!! Form::label('details', 'Detalles',array('class' => 'label label-default')); !!}
		    		{!! Form::text('details',$article->details); !!}		    		
		    	</h3>
		    	<h3>
		    		{!! Form::label('price', 'Precio',array('class' => 'label label-default')); !!}
		    		{!! Form::text('price',$article->price); !!}
		    		{!! Form::submit('Guardar',array('class' => 'btn btn-lg btn-default')); !!}
		    	</h3>
				{!! Form::close() !!}
            </div>
        </div>        
    </div>
</div>

@endsection