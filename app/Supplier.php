<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

	//
	protected $table = 'suppliers';

	protected $fillable = ['rut','name','phone'];

	public function purchases()
	{
		return $this->hasMany('App\Purchase');
	}

}
