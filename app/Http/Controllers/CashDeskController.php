<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\WaitingRoom;
use App\CashDesk;
use App\DeskDetail;
use App\Client;
use App\Debt;

class CashDeskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$waitings = WaitingRoom::where('status','Pendiente')->get();

		return view('cashDesk.principal',compact('waitings'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function saveDetail(Request $request)
	{

		$cashDesk = CashDesk::where('status','activa')->first();

		$input = $request->only(['payment_method','sale_id','document_type','ticket']);

		$input['cash_desk_id'] = $cashDesk->id;

		$rules = [
		'payment_method'=>'required',
		'sale_id'=>'required',
		'document_type'=>'required',
		'ticket'=>'required|numeric',
		'cash_desk_id'=>'required'
		];

		$validation = \Validator::make($input,$rules);

		if($validation->passes())
		{
			$detail = new DeskDetail($input);

			$detail->save();

			//$id_waiting = ;

			$waiting = WaitingRoom::find($request->input('waiting_id'));

			$waiting->status = 'Pagado';

			$waiting->save();

			return response()->json(['respuesta'=>'Guardado','numero'=>$detail->id,'espera'=>$request->input('waiting_id')]);
		}

		$messages = $validation->errors();

        return response()->json($messages);
	}

	public function credit($id){
		$waiting = WaitingRoom::find($id);

		if($waiting->status=="Pendiente"){

			$clients = Client::orderBy('name')->get();

			return view('cashDesk.credit',compact('waiting','clients'));
		}

		return redirect()->route('caja');

	}

	public function saveCredit(Request $request){
		$cashDesk = CashDesk::where('status','activa')->first();

		$input = $request->only(['payment_method','sale_id','document_type','ticket']);

		$input['cash_desk_id'] = $cashDesk->id;

		$rules = [
		'payment_method'=>'required',
		'sale_id'=>'required',
		'document_type'=>'required',
		'ticket'=>'required|numeric',
		'cash_desk_id'=>'required'
		];

		$validation = \Validator::make($input,$rules);

		if($validation->passes())
		{
			if(!empty($request->input('client_id'))){
				//
				$detail = new DeskDetail($input);

				$detail->save();

				//$id_waiting = ;

				$waiting = WaitingRoom::find($request->input('waiting_id'));

				$waiting->status = 'Pagado';

				$waiting->save();

				//deuda
				$today = date("Y-m-d");

				$data_deuda = array(
					'expiration'=>$today,
					'total'=>$waiting->Sale->total,
					'client_id'=>$request->input('client_id'),
					'sale_id'=>$waiting->Sale->id
					);

				$debt = new Debt($data_deuda);

				$debt->save();
				//

				return response()->json(['respuesta'=>'Guardado','numero'=>$detail->id,'espera'=>$request->input('waiting_id'),'ruta'=>route('caja')]);
			}else{
				return response()->json(['respuesta'=>'Error','mensaje'=>'No se indico el cliente']);
			}
		}

		$messages = $validation->errors();

        return response()->json($messages);
	}

	public function issued(){
		$cashDesk = CashDesk::where('status','activa')->first();

		return view('cashDesk.issued',compact('cashDesk'));
	}

	public function close(){
		$cashDesk = CashDesk::where('status','activa')->first();

		$efectivo = $cashDesk->DeskDetail->where('payment_method','Efectivo');
		$credito = $cashDesk->DeskDetail->where('payment_method','Credito');
		$tarjeta = $cashDesk->DeskDetail->where('payment_method','Tarjeta');

		$sumCash = 0;

		foreach ($efectivo as $venta) {
			$sumCash+=$venta->Sale->total;
		}

		$sumCredit = 0;

		foreach ($credito as $venta) {
			$sumCredit+=$venta->Sale->total;
		}

		$sumCreditCard = 0;

		foreach ($tarjeta as $venta) {
			$sumCreditCard+=$venta->Sale->total;
		}

		return view('cashDesk.close',compact('cashDesk','sumCredit','sumCash','sumCreditCard'));
	}

	public function saveClose(Request $request){
		$cashDesk = CashDesk::where('status','activa')->first();

		$cashDesk->status = 'cerrada';

		$cashDesk->user_id = $request->user()->id;

		$cashDesk->save();

		$data = [
		'status'=>'activa',
		'total'=>$request->input('total')
		];

		$new_cashDesk = new CashDesk($data);

		$new_cashDesk->save();

		$ruta = route('caja');

		return response()->json(['respuesta'=>'Guardado','ruta'=>$ruta,'nueva'=>$new_cashDesk->id]);
	}

	public function annul(Request $request,$id){

		$waiting = WaitingRoom::find($id);

		$sale = $waiting->Sale;


		foreach ($sale->saledetails as $detail) {
			$articulo = $detail->article;

			$articulo->modificar_stock('+',$detail->quantity);

			$articulo->save();
		}

		$sale->status="Nula";

		$sale->save();

		$waiting->delete();

		return "Anulado";
	}

}
