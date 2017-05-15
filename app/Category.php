<?php

namespace App;

use App\User;
use App\Project;

class Category extends Model
{
	
    public function create($name){
	    $category = new Category;
	    $category->name = $name;
	    $category->save();

	    return redirect('/addProject');
	}
}
