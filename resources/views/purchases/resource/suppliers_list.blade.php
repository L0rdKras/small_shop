<table class="table table-striped">
	<thead>
	  <tr>
	    
	    <th>RUT</th>
	    <th>Nombre</th>
	    <th>Sel.</th>
	  </tr>
	</thead>
	<tbody>
		@foreach($suppliers as $supplier)
	  <tr data-id="{{$supplier->id}}">
	    
	    <td>{{$supplier->rut}}</td>
	    <td>{{$supplier->name}}</td>
	    <td><a href="#" class="btn btn-info btn_add_supplier">Agrega</a></td>
	  </tr>
	  	@endforeach
	</tbody>
</table>