<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('total');
			$table->string('payment_method');
			$table->string('status')->default('Valida');
			$table->integer('client_id')->unsigned()->nullable();
			$table->timestamps();

			$table->foreign('client_id')->references('id')->on('clients');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sales');
	}

}
