<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	public function create(Request $request) {
	    return redirect('/');
	}
}
