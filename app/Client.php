<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

	protected $table = 'clients';

	protected $fillable = ['rut','name','phone'];

	public function sales()
	{
		return $this->hasMany('App\Sales');
	}

}
