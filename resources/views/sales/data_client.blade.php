<h3>
	{!! Form::label('nombre_cliente', 'Nombre Cliente',array('class' => 'label label-default')); !!}
	{!! Form::text('nombre_cliente',$client->name,array('id'=>'nombre_cliente','readonly'=>'readonly')); !!}
</h3>