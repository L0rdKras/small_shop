@extends('template')

@section('content')
<div class="container theme-showcase" role="main">
	
    <div class="page-hader">
    	<div class="panel panel-default">
    		<div class="panel-heading">
              <h3 class="panel-title">Datos Compra</h3>
            </div>
            <div class="panel-body">
            	<h3>
            		<span class="label label-default">Proveedor : </span>
            		<span class="label label-primary">{{$purchase->supplier->name}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">R.U.T. : </span>
            		<span class="label label-primary">{{$purchase->supplier->rut}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Documento : </span>
            		<span class="label label-primary">{{$purchase->document}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Numero : </span>
            		<span class="label label-primary">{{$purchase->number}}</span>
            	</h3>
            	<h3>
            		<span class="label label-default">Fecha Ingreso : </span>
            		<span class="label label-primary">{{date_format($purchase->created_at, 'd/m/Y')}}</span>
            	</h3>
                <h3>
                    <input type="hidden" value="{{$purchase->id}}" id="idCompra">
                    <a id="btn_anular_compra" href="{{ route('anula_compra', [$purchase->id]) }}" class="btn btn-warning btn-lg">Anular</a>
                </h3>
            </div>
        </div>

        <div class="panel panel-default">
        	<div class="panel-heading">
              <h3 class="panel-title">Articulos Comprados</h3>
            </div>
            <div class="panel-body">
            	<table class="table table-striped">
		            <thead>
		              <tr>
		                <th>C.I.</th>
		                <th>Descripcion</th>
		                <th>Detalle</th>
		                <th>Cantidad</th>
                        <th>Precio</th>
		              </tr>
		            </thead>
		            <tbody>
		              @foreach($purchase->purchasedetails as $purchasedetail)
		              <tr>
		                <td>{{$purchasedetail->id}}</td>
		                <td>{{$purchasedetail->article->article_description->name}}</td>
		                <td>{{$purchasedetail->article->details}}</td>
		                <td>{{$purchasedetail->quantity}}</td>
                        <td>{{$purchasedetail->prize}}</td>
		              </tr>
		              @endforeach
		            </tbody>
		        </table>
            </div>
        </div>
    </div>
</div>

{!! Form::open(array('route' => ['anula_compra',':PURCHASE_ID'],'id'=>'form_delete','method'=>'DELETE')) !!}
{!! Form::close() !!}

@endsection

@section('scripts')

<script src="{{ asset('js/info_purchase.js')}}"></script>

@endsection