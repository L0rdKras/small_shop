<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{

	public function run()
	{
		\DB::table('articles')->insert(array(
			'details' 		=> 'Prueba Descripcion',
			'price' 	=> 10000,
			'stock'		=> 100,
			'article_description_id' 		=> 1
		));
	}

}

?>