<?php namespace App\Http\Controllers;

/*use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;*/
use Response;

use App\Article;

use App\Budget;

use App\BudgetDetail;

use App\Client;

use App\Debt;

use App\ArticleDescription;

class BudgetsController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	public function store($json,$total,$medio,$cliente)
	{
		$data = [
			'total'=>$total,
			'client_id'=>$cliente
			];

		$rules = [
			'total'=>'required',
			'client_id'=>'required'
		];

		$validation = \Validator::make($data,$rules);

		if($validation->passes())
		{
			
			$budget = new Budget($data);

			$budget->save();

			$arrayjson = json_decode($json);

			foreach ($arrayjson as $key => $value) {
				//$aux.=$value->cantidad." y ".$value->articulo;

				$data_detail = array('quantity'=>$value->cantidad,'subtotal'=>$value->subtotal,'article_id'=>$value->articulo,'budget_id'=>$budget->id);

				$detail = new BudgetDetail($data_detail);

				$detail->save();

			}
			
			//return "Cotizacion Guardada";
			return response()->json(["respuesta"=>"Presupuesto Guardado","idBudget"=>$budget->id]);

		}
		//return "No Valido";
		return response()->json(["respuesta"=>"No valido"]);
	}

	public function Budgets_list()
	{
		$budgets = Budget::orderBy('created_at','desc')->paginate(10);

		return view('budgets.list',compact('budgets'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$budget = Budget::find($id);

		return view('budgets.info',compact('budget'));
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

}
