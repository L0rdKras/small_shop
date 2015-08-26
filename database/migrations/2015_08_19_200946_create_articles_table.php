<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('details')->nullable();
			$table->integer('price')->unsigned();
			$table->integer('stock');
			$table->integer('article_description_id')->unsigned();
			$table->timestamps();

			/***/
			$table->foreign('article_description_id')->references('id')->on('article_descriptions');
			/**/

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
