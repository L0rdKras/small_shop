<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pays', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('amount')->unsigned();
			$table->integer('debt_id')->unsigned();
			$table->timestamps();

			$table->foreign('debt_id')->references('id')->on('debts');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pays');
	}

}
