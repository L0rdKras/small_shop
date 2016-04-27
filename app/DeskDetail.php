<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DeskDetail extends Model {

	protected $table = 'desk_details';

	protected $fillable = ['paymenth_method','sale_id','cash_desk_id'];

	public function CashDesk(){
		return $this->belongsTo('App\CashDesk');
	}

	public function Sale(){
		return $this->belongsTo('App\Sale');
	}

}
