<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model {

	protected $table = 'saledetails';

	protected $fillable = ['quantity','subtotal','article_id','sale_id'];

	public function sale()
	{
		return $this->belongsTo('App\Sale');
	}
	public function article()
	{
		return $this->belongsTo('App\Article');
	}

	public function unit_price()
	{
		return ($this->subtotal)/($this->quantity);
	}

}
