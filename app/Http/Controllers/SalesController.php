<?php namespace App\Http\Controllers;

use App\Article;

use App\Sale;

use App\SaleDetail;

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

	public function save_sale($json,$total)
	{
		//$data = Request::only('name');

		$data = array('total'=>$total);

		$rules = [
			'total'=>'required'
		];

		$validation = \Validator::make($data,$rules);

		if($validation->passes())
		{
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

}
