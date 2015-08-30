<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model {

	protected $table = 'purchasedetails';

	protected $fillable = ['quantity','article_id','purchase_id'];

	public function article()
	{
		return $this->belongsTo('App\Article');
	}

	public function purchase()
	{
		return $this->belongsTo('App\Purchase');
	}
}
