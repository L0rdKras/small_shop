<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model {

	protected $table = 'pays';

	protected $fillable = ['amount','debt_id'];

}
