<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model {
	
	protected $table = 'budgets';

	protected $fillable = ['total','client_id'];

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function budgetDetails()
	{
		return $this->hasMany('App\BudgetDetail');
	}
}
?>