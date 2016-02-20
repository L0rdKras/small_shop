<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model {
	
	protected $table = 'budgetDetails';

	protected $fillable = ['quantity','subtotal','article_id','budget_id'];

	public function budget()
	{
		return $this->belongsTo('App\Budget');
	}
	
	public function article()
	{
		return $this->belongsTo('App\Article');
	}
}
?>