<?php

namespace App;

use App\Search\Searchable;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {

	use Searchable;

	/**
 	* Fields that are mass assignable
 	*
 	* @var array
 	*/
	protected $fillable = ['message'];
    
    public function users() {
    	return $this->belongsTo('App\User');
    }

}
