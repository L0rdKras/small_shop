<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CashDesk extends Model {

	protected $table = 'cash_desks';

	protected $fillable = ['status'];

	public function User(){
		return $this->belongsTo('App\User');
	}

}
