<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model {

	protected $table = 'debts';

	protected $fillable = ['expiration','total','client_id','sale_id'];

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function sale()
	{
		return $this->belongsTo('App\Sale');
	}

}
