<?php namespace App\Http\Controllers;

use App\ArticleDescription;
use App\Article;

use Request;

use Response;

class ArticlesController extends Controller {

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
		return view('articles.inicio');
	}

	public function add_descriptions()
	{
		$descriptions = ArticleDescription::orderBy('name')->get();

		return view('articles.descriptions',compact('descriptions'));
	}

	public function save_description()
	{
		$data = Request::only('name');

		$rules = [
			'name' => 'required'
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$item = new ArticleDescription($data);

			$item->save();

			//return Redirect::back()->withInput()->withErrors($validation->messages());
			return redirect()->back();
		}
		return redirect()->back()->withInput()->withErrors($validation->messages());
	}

	public function delete_description($id)
	{
		if(Request::ajax())
		{
			$item = ArticleDescription::find($id);

			$item->delete();

			$message  = "Descripcion: '".$item->name."' eliminada";

			return Response::json(array('message' => $message,'id' => $id));
		}

		return redirect()->back();
	}

	public function edit_descriptions($id)
	{
		$description = ArticleDescription::find($id);

		return view('articles.edit_description',compact('description'));

	}

	public function update_descriptions($id)
	{
		$data = Request::only('name');

		$rules = [
			'name' => 'required'
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$item = ArticleDescription::find($id);

			$item->name = $data['name'];

			$item->save();

			return redirect()->route('descripciones');
		}

		return redirect()->back()->withInput();
	}

	/**creacion articulos**/

	public function create_articles()
	{
		//
		$descriptions = ArticleDescription::orderBy('name')->get()->lists('name','id');

		$articles = Article::all();

		return view('articles.create_articles',compact('descriptions','articles'));
	}

	public function save_articles()
	{
		$data = Request::only('details','price','article_description_id');

		$rules = [
			'details' => 'required',
			'price' => 'required',
			'article_description_id' => 'required'
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$item = new Article($data);

			$item->save();

			//return Redirect::back()->withInput()->withErrors($validation->messages());
			return redirect()->back();
		}
		return redirect()->back()->withInput()->withErrors($validation->messages());
	}

	public function delete_article($id)
	{
		if(Request::ajax())
		{
			$item = Article::find($id);

			$item->delete();

			$message  = "Articulo id: '".$item->id."' eliminada";

			return Response::json(array('message' => $message,'id' => $id));
		}

		return redirect()->back();
	}

	public function edit_article($id)
	{
		$article = Article::find($id);

		$descriptions = ArticleDescription::orderBy('name')->get()->lists('name','id');

		return view('articles.edit_article',compact('article','descriptions'));
	}

	public function update_article($id)
	{
		$data = Request::only('details','price','article_description_id');

		$rules = [
			'details' => 'required',
			'price' => 'required',
			'article_description_id' => 'required'
		];

		$validation = \Validator::make($data,$rules);


		if($validation->passes())
		{
			$item = Article::find($id);

			$item->details = $data['details'];

			$item->article_description_id = $data['article_description_id'];

			$item->price = $data['price'];

			$item->save();

			//return Redirect::back()->withInput()->withErrors($validation->messages());
			return redirect()->route('crear_articulos');
		}
		return redirect()->back()->withInput()->withErrors($validation->messages());
	}

}