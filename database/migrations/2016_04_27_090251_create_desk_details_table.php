<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeskDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('desk_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('paymenth_method');
			$table->string('document_type');
			$table->integer('ticket');
			$table->integer('sale_id')->unsigned();
			$table->integer('cash_desk_id')->unsigned();
			$table->timestamps();

			$table->foreign('sale_id')->references('id')->on('sales');
			$table->foreign('cash_desk_id')->references('id')->on('cash_desks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('desk_details');
	}

}
