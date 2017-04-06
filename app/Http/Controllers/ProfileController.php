<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Education;
use App\Employment;

class ProfileController extends Controller
{
    public function show($id){

    	$education = Education::where('education_id', User::find($id)->first()->education_id )->first();
    	$employment = Employment::where('employment_id', User::find($id)->first()->employment_id )->first();

		return view('profile', compact('education', 'employment', 'id'));
	}
}
