<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model {

	protected $table = 'saledetails';

	protected $fillable = ['quantity','subtotal','article_id','sale_id'];

	public function purchases()
	{
		return $this->belongsTo('App\Sale');
	}

}
