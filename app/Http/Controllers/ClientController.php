<?php namespace App\Http\Controllers;

use App\Client;
use App\Debt;

use Request;

use Response;


class ClientController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */

	public function register_form()
	{
		$clients = Client::orderBy('name')->get();

		return view('clients.register',compact('clients'));
	}

	public function save_client()
	{
		$data = Request::only('rut','name','phone');

		$rules = [
			'name' => 'required',
			'rut' => 'required',
			'phone' => 'required',
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$item = new Client($data);

			$item->save();

			//return Redirect::back()->withInput()->withErrors($validation->messages());
			return redirect()->back();
		}
		return redirect()->back()->withInput()->withErrors($validation->messages());
	}

	public function edit_client($id)
	{
		$client = Client::find($id);

		return view('clients.edit_client',compact('client'));
	}

	public function update_client($id)
	{
		$data = Request::only('rut','name','phone');

		$rules = [
			'name' => 'required',
			'rut' => 'required',
			'phone' => 'required',
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$item = Client::find($id);

			$item->name = $data['name'];

			$item->rut = $data['rut'];

			$item->phone = $data['phone'];

			$item->save();

			//return Redirect::back()->withInput()->withErrors($validation->messages());
			return redirect()->route("registro_cliente");
		}
		return redirect()->back()->withInput()->withErrors($validation->messages());
	}

	public function client_debts($id)
	{
		$client = Client::find($id);

		return view('clients.debts_list',compact('client'));
	}

	public function pay_debt($id)
	{
		$debt = Debt::find($id);

		return view('clients.debts_detail',compact('debt'));
	}


}
