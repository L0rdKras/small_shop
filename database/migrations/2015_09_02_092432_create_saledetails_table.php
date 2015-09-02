<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaledetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('saledetails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('quantity')->unsigned();
			$table->integer('subtotal');
			$table->integer('article_id')->unsigned();
			$table->integer('sale_id')->unsigned();
			$table->timestamps();

			$table->foreign('article_id')->references('id')->on('articles');
			$table->foreign('sale_id')->references('id')->on('sales');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('saledetails');
	}

}
