{!! Form::open() !!}
<h3>
	{!! Form::label('nombre_prov', 'Proveedor',array('class' => 'label label-default')); !!}
	{!! Form::text('nombre_prov',$supplier->name,array('id'=>'nombre_prov','readonly'=>'readonly')); !!}
	{!! Form::hidden('supplier_id',$supplier->id,array('id'=>'supplier_id')); !!}
</h3>

<h3>
	{!! Form::label('document', 'Documento',array('class' => 'label label-default')); !!}
	{!! Form::text('document',null,array('id'=>'document')); !!}
	{!! Form::label('number', 'Numero',array('class' => 'label label-default')); !!}
	{!! Form::text('number',null,array('id'=>'number')); !!}
</h3>
{!! Form::close() !!}