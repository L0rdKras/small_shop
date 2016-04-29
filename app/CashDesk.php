<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CashDesk extends Model {

	protected $table = 'cash_desks';

	protected $fillable = ['status','total'];

	public function User(){
		return $this->belongsTo('App\User');
	}

	public function DeskDetail(){
		return $this->hasMany('App\DeskDetail');
	}

}