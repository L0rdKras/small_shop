<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model {

	protected $table = 'waiting_rooms';

	protected $fillable = ['status','sales_id'];

	public function Sale(){
		return $this->belongsTo('App\Sales');
	}
}
