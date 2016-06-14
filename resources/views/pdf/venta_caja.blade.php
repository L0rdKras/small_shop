@extends('print_template')

@section('content')
<div class="container theme-showcase" role="main">
	<div class="jumbotron">
        <h1>Venta N° {{$sale->id}}</h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
              <h3 class="panel-title">Datos Venta</h3>
            </div>
            <div class="panel-body">
              <h3>
                Documento : {{$deskDetail->document_type}}
              </h3>
              <h3>
                Numero Documento : {{$deskDetail->ticket}}
              </h3>
              <h3>
                Medio de Pago : {{$deskDetail->payment_method}}
              </h3>

              <h3>
               Fecha Ingreso : {{date_format($sale->created_at, 'd/m/Y')}}
              </h3>
              <h3>
                Total : {{$sale->total}}
              </h3>
            </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">Articulos Vendidos</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th>Descripcion</th>
                    <th>Detalle</th>
                    <th>Cantidad</th>
                    <th>P.Unitario</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                  @foreach($sale->saledetails as $saledetail)
                <tbody>
                    <tr>
                      <td>{{$saledetail->article->article_description->name}}</td>
                      <td>{{$saledetail->article->details}}</td>
                      <td>{{$saledetail->quantity}}</td>
                      <td>{{$saledetail->unit_price()}}</td>
                      <td>{{$saledetail->subtotal}}</td>
                    </tr>
                </tbody>
                  @endforeach
              </table>
            </div>
        </div>
    </div>

</div>
@endsection
