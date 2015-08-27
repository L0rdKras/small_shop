<?php namespace App\Http\Controllers;

use App\Supplier;

use Request;

use Response;

class PurchasesController extends Controller {

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
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('purchases.inicio');
	}

	public function suppliers()
	{
		$suppliers = Supplier::orderBy('name')->get();

		return view('purchases.proveedores',compact('suppliers'));
	}

	public function save_supplier()
	{
		$data = Request::only('name','rut');

		$rules = [
			'name' => 'required',
			'rut' => 'required'
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$item = new Supplier($data);

			$item->save();

			//return Redirect::back()->withInput()->withErrors($validation->messages());
			return redirect()->back();
		}
		return redirect()->back()->withInput()->withErrors($validation->messages());
	}

	public function edit_supplier($id)
	{
		$supplier = Supplier::find($id);

		return view('purchases.edit_supplier',compact('supplier'));
	}

	public function update_supplier($id)
	{
		$data = Request::only('rut','name');

		$rules = [
			'rut' => 'required',
			'name' => 'required'
		];

		$validation = \Validator::make($data,$rules);

		if($validation->passes())
		{
			$item = Supplier::find($id);

			$item->name = $data['name'];

			$item->rut = $data['rut'];

			$item->save();

			return redirect()->route('proveedores');
		}

		return redirect()->back()->withInput();
	}

}
