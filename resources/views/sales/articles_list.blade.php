<table class="table table-striped">
    <thead>
      <tr>
        <th>Articulo</th>
        <th>Descripcion</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Cargar</th>
      </tr>
    </thead>
    
	<tbody>
	  @foreach($description->articles as $article)
	  <tr data-id="{{$article->id}}">
	    <td>{{$name}}</td>
	    <td>{{$article->details}}</td>
	    <td>{{$article->price}}</td>
	    <td>{{$article->stock}}</td>
	    <td>
	    <button class="btn btn-info" onclick="cargarCodigo('{{$article->firstBarcode()}}')">Carga</button>
	    </td>
	  </tr>
	  @endforeach
	</tbody>
</table>
