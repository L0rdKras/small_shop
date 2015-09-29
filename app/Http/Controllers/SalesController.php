<?php namespace App\Http\Controllers;

use Response;

use App\Article;

use App\Sale;

use App\SaleDetail;

use App\Client;

use App\Debt;

class SalesController extends Controller {

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
		return view('sales.inicio');
	}

	public function sell()
	{
		return view('sales.vender');
	}

	public function save_sale($json,$total,$medio,$cliente)
	{
		//$data = Request::only('name');

		$data = [
			'total'=>$total,
			'payment_method'=>$medio,
			'client_id'=>$cliente
			];

		$rules = [
			'total'=>'required',
			'payment_method'=>'required'
		];

		$validation = \Validator::make($data,$rules);

		if($validation->passes())
		{
			if($data['client_id'] == 0){
				$data['client_id'] = null;
			}
			$sale = new Sale($data);

			$sale->save();

			$arrayjson = json_decode($json);

			foreach ($arrayjson as $key => $value) {
				//$aux.=$value->cantidad." y ".$value->articulo;

				$data_detail = array('quantity'=>$value->cantidad,'subtotal'=>$value->subtotal,'article_id'=>$value->articulo,'sale_id'=>$sale->id);

				$detail = new SaleDetail($data_detail);

				$detail->save();

				$article = Article::find($value->articulo);

				$article->modificar_stock("-",$value->cantidad);

				$article->save();
			}

			//si es credito, crear deuda

			if($medio == "Credito"){
				$today = date("Y-m-d");
				$data_deuda = array('expiration'=>$today,'total'=>$total,'client_id'=>$cliente,'sale_id'=>$sale->id);

				$debt = new Debt($data_deuda);

				$debt->save();
			}
			
			return "Venta Guardada";

		}
		return "No Valido";

	}

	public function sales_list()
	{
		$sales = Sale::orderBy('created_at','desc')->paginate(10);

		return view('sales.list',compact('sales'));
	}

	public function sale_info($id)
	{
		$sale = Sale::find($id);

		return view('sales.info_sale',compact('sale'));
	}

	public function clients_list()
	{
		$clients = Client::orderBy('created_at','desc')->paginate(10);

		return view('sales.clients_list',compact('clients'));
	}

	public function client_data($id)
	{
		$client = Client::find($id);

		$vista 	= view('sales.data_client',compact('client'));

		$view_data = $vista->render();

		$view_data = str_replace("\n", "", $view_data);
		$view_data = str_replace("\t", "", $view_data);
		/*$view_data = str_replace('\"', '"', $view_data);*/

		$view_data = stripslashes($view_data);

		$json 	= response()->json(
			array(
				"vista"=>$view_data,
				"id_cliente"=>$id
				)
			);

		return ($json);
	}

}
