<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('debts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->time('expiration');
			$table->integer('client_id')->unsigned();
			$table->integer('sale_id')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('debts');
	}

}
