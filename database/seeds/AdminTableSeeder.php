<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{

	public function run()
	{
		\DB::table('users')->insert(array(
			'name' 		=> 'Admin',
			'email' 	=> 'admin_sistema@sistema.cl',
			'type' 		=> 'admin',
			'password' 	=> \Hash::make('claveAdmin')

		));
	}

}

?>