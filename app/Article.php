<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	//
	protected $table = 'articles';

	protected $fillable = ['details','price','article_description_id'];

	public function article_description()
	{
		return $this->belongsTo('App\ArticleDescription');
	}

	public function barrcodes()
	{
		return $this->hasMany('App\Barrcode');
	}

}