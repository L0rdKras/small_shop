<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	//
	protected $table = 'articles';

	protected $fillable = ['details','price','article_description_id'];

	public function article_description()
	{
		return $this->belongsTo('App\ArticleDescription');
	}

	public function barrcodes()
	{
		return $this->hasMany('App\Barrcode');
	}

	public function purchasedetails()
	{
		return $this->hasMany('App\PurchaseDetail');
	}

	public function saledetails()
	{
		return $this->hasMany('App\SaleDetail');
	}

	public function modificar_stock($operator,$quantity)
	{
		if($operator == "+")
		{
			$this->stock += $quantity;
			return true;
		}elseif ($operator == "-") {
			$this->stock -= $quantity;
			return true;
		}

		return false;
	}

}