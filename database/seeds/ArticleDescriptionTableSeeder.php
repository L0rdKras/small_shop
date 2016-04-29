<?php

use Illuminate\Database\Seeder;

class ArticleDescriptionTableSeeder extends Seeder
{

	public function run()
	{
		\DB::table('article_descriptions')->insert(array(
			'name' 		=> 'Prueba Articulo',
		));
	}

}

?>