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

}