<?php

use Illuminate\Database\Seeder;

class CashDeskTableSeeder extends Seeder
{

	public function run()
	{
		\DB::table('cash_desks')->insert(array(
			'status' 		=> 'activa',
			'total' 		=> 0
		));
	}

}

?>