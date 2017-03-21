<?php

namespace App;

use App\Allow;

class Project extends Model
{
	protected $fillable = ['id'];
	public function allow(){

		return $this->hasMany(Allow::class);
	
	}

}

?>