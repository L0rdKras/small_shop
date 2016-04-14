@extends('print_template')

@section('content')
<div class="" style="font-size:10px" role="main">
	
        <h3>Presupuesto N° {{$budget->id}}</h3>
    
    <div style="padding: 0px; margin: 0px;">
        <div class="">
            <b class="">Datos Presupuesto</b>
        </div>
            <div style="padding: 0px; margin: 0px;">
            <p>
	            <b>
	            	Cliente : {{$budget->client->name}}
	            </b>
            </p>
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
              <b class="">Articulos Presupuestados</b>
            </div>
            <div style="width:200px">
              <table border="1" style="font-size:7px; width:100%">
                <thead>
                  <tr>
                    <th>Descripcion</th>
                    
                    <th>Cantidad</th>
                    <th>P.Unitario</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                  @foreach($budget->budgetDetails as $saledetail)
                <tbody>
                    <tr>
                      <td>{{$saledetail->article->article_description->name}} {{$saledetail->article->details}}</td>
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