<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

	protected $table = 'sales';

	protected $fillable = ['total'];

	public function saledetails()
	{
		return $this->hasMany('App\SaleDetail');
	}

}
