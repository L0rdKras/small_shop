<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WaitingRoom extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waiting_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('sale_id');
            $table->timestamps();

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
		Schema::drop('waiting_rooms');
	}

}
