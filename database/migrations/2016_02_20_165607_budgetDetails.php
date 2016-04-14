<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BudgetDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('budgetDetails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('quantity')->unsigned();
			$table->integer('subtotal');
			$table->integer('article_id')->unsigned();
			$table->integer('budget_id')->unsigned();
			$table->timestamps();

			$table->foreign('article_id')->references('id')->on('articles');
			$table->foreign('budget_id')->references('id')->on('budgets');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('budgetDetails');
	}

}
