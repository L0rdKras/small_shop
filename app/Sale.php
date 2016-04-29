<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

	protected $table = 'sales';

	protected $fillable = ['total','payment_method','client_id'];

	public function saledetails()
	{
		return $this->hasMany('App\SaleDetail');
	}

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function DeskDetail(){
		return $this->hasOne('App\DeskDetail');
	}

	public function Debt(){
		return $this->hasOne('App\Debt');
	}

}
