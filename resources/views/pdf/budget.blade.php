@extends('print_template')

@section('content')
<div class="" style="font-size:7 px" role="main">
	
        <h3>Presupuesto N° {{$budget->id}}</h3>
    
    <div class="">
        <div class="">
            <b class="">Datos Presupuesto</b>
        </div>
            <div class="">
              
              <b>
               Fecha Ingreso : {{date_format($budget->created_at, 'd/m/Y')}}
              </b>
              <b>
                Total : {{$budget->total}}
              </b>
            </div>
        </div>

        <div class="">
          <div class="">
              <b class="">Articulos Vendidos</b>
            </div>
            <div class="">
              <table border="1" class="">
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
                  @foreach($budget->budgetDetails as $saledetail)
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