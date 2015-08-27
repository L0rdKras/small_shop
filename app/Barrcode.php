<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Barrcode extends Model {

	//
	protected $table = 'barrcodes';

	protected $fillable = ['code','article_id'];

	public function article()
	{
		return $this->belongsTo('App\Article');
	}

}
