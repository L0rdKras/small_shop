<?php

use Illuminate\Database\Seeder;

class BarcodeTableSeeder extends Seeder
{

	public function run()
	{
		\DB::table('barrcodes')->insert(array(
			'code' 				=> '01',
			'article_id' 		=> 1
		));
	}

}

?>