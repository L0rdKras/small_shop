<table class="table table-striped">
	<thead>
	  <tr>
	    
	    <th>RUT</th>
	    <th>Nombre</th>
	    <th>Sel.</th>
	  </tr>
	</thead>
	<tbody>
		@foreach($clients as $client)
	  <tr data-id="{{$client->id}}">
	    
	    <td>{{$client->rut}}</td>
	    <td>{{$client->name}}</td>
	    <td><a href="#" class="btn btn-info btn_add_client">Agrega</a></td>
	  </tr>
	  	@endforeach
	</tbody>
</table>