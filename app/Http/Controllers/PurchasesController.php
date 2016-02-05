<?php namespace App\Http\Controllers;

use App\Supplier;

use App\Article;

use App\Barrcode;

use App\Purchase;

use App\PurchaseDetail;

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
		$this->middleware('auth');
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

	public function suppliers_list()
	{
		$suppliers = Supplier::orderBy('name')->get();

		//crear tabla
		return view('purchases.resource.suppliers_list',compact('suppliers'));
	}

	public function supplier_data($id)
	{
		$supplier = Supplier::find($id);

		return view('purchases.resource.supplier_data',compact('supplier'));
	}

	public function suppliers()
	{
		$suppliers = Supplier::orderBy('name')->get();

		return view('purchases.proveedores',compact('suppliers'));
	}

	public function save_supplier()
	{
		//die($request);
		$data = Request::only('name','rut');

		$rules = [
			'name' => 'required',
			'rut' => 'required'
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$count = Supplier::where('rut','=', $data['rut'])->count();

			if($count == 0)
        	{

				$item = new Supplier($data);

				$item->save();

				//return Redirect::back()->withInput()->withErrors($validation->messages());
				//return redirect()->back();
				return response()->json(["respuesta"=>"Guardado"]);
			}
			return response()->json(["respuesta"=>"Ese rut ya esta registrado"]);
		}
		return response()->json(["respuesta"=>"Falta completar información"]);

		//return redirect()->back()->withInput()->withErrors($validation->messages());
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

	public function purchase_register()
	{
		return view('purchases.register');
	}

	public function load_code($code)
	{
		$cont = Barrcode::where('code','=',$code)->count();

		if($cont>0)
		{
			$item = Barrcode::where('code','=',$code)->first();
			
			$info = array(
				'message' => 'encontrado',
				'description_article' => $item->article->article_description->name,
				'details' => $item->article->details,
				'stock' => $item->article->stock,
				'id' => $item->id,
				'article_id' => $item->article_id,
				'price' => $item->article->price
			);

			return Response::json($info);
		}

		return Response::json(array('message' => "No se encontro el codigo"));
	}

	public function save_purchase($json,$id,$document,$number,$total)
	{
		//$data = Request::only('name');
		$count = Purchase::where('supplier_id','=', $id)->where('document','=',$document)->where('number','=',$number)->count();

		if($count == 0)
		{
			$data = array('number'=>$number,'document'=>$document,'supplier_id'=>$id,'total'=>$total);

			$rules = [
				'number'=>'required',
				'document'=>'required',
				'supplier_id'=>'required',
				'total'=>'required'
			];

			$validation = \Validator::make($data,$rules);

			if($validation->passes())
			{
				$purchase = new Purchase($data);

				$purchase->save();

				$arrayjson = json_decode($json);

				foreach ($arrayjson as $key => $value) {
					//$aux.=$value->cantidad." y ".$value->articulo;

					$data_detail = array('quantity'=>$value->cantidad,'prize'=>$value->precio,'article_id'=>$value->articulo,'purchase_id'=>$purchase->id);

					$detail = new PurchaseDetail($data_detail);

					$detail->save();

					$article = Article::find($value->articulo);

					$article->modificar_stock("+",$value->cantidad);

					$article->save();
				}
				
				return "Compra Guardada";

				//return Redirect::back()->withInput()->withErrors($validation->messages());
				//return redirect()->back();
			}
			return "No Valido $id $number $document";
			//return redirect()->back()->withInput()->withErrors($validation->messages());
		}
		return "Hay una venta guardarda previamente con esos datos $count $number";

	}

	public function purchases_list()
	{
		$purchases = Purchase::orderBy('created_at','desc')->paginate(10);

		return view('purchases.list',compact('purchases'));
	}

	public function purchase_info($id)
	{
		$purchase = Purchase::find($id);

		return view('purchases.info_purchase',compact('purchase'));
	}

}