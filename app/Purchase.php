<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model {

	//
	protected $table = 'purchases';

	protected $fillable = ['number','document','supplier_id','total'];

	public function supplier()
	{
		return $this->belongsTo('App\Supplier');
	}

	public function purchasedetails()
	{
		return $this->hasMany('App\PurchaseDetail');
	}

}
