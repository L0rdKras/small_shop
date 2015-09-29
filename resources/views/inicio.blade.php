@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        
        <img style="width 100%;" src="{{ asset('images/tebada.jpg') }}" alt="">
    </div>

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h2>Articulos</h2>
          <p>Ingrese y modifique los datos de los articulos que ofrecera en su negocio.</p>
          <p>También podra agregar códigos de barra a modo de identificación</p>
          <p><a class="btn btn-default" href="{{route('articulos')}}" role="button">Ir &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h2>Compras</h2>
          <p>Registre las compras de mercaderia que efectua en su negocio, asi su stock reflejara los nuevos ingresos.</p>
          <p><a class="btn btn-default" href="{{route('compras')}}" role="button">Ir &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h2>Ventas</h2>
          <p>Ingrese las ventas realizadas, controle asi eficazmente su inventario.</p>
          <p><a class="btn btn-default" href="{{route('ventas')}}" role="button">Ir &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div>
    </div>
</div>
@endsection