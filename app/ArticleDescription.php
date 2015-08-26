<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleDescription extends Model {

	//
	protected $table = 'article_descriptions';

	protected $fillable = ['name'];

	public function articles()
	{
		return $this->hasMany('App\Article');
	}

}
