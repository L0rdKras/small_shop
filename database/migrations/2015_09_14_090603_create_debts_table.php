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
			$table->date('expiration');
			$table->enum('status',['Pendiente','Pagada'])->default("Pendiente");
			$table->integer('total');
			$table->integer('client_id')->unsigned();
			$table->integer('sale_id')->unsigned();
			$table->timestamps();

			$table->foreign('client_id')->references('id')->on('clients');
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
		Schema::drop('debts');
	}

}
