<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasedetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchasedetails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('quantity');
			$table->integer('prize')->unsigned();
			$table->integer('article_id')->unsigned();
			$table->integer('purchase_id')->unsigned();
			$table->timestamps();

			$table->foreign('article_id')->references('id')->on('articles');
			$table->foreign('purchase_id')->references('id')->on('purchases');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('purchasedetails');
	}

}
