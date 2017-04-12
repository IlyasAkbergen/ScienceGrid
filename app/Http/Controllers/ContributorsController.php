<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Project_and_contributors;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Auth;

class ContributorsController extends Controller
{
    public function show($id)
    {
        if(Auth::guest()){
            return redirect('/');
        }else{
            $contributors = array(); 
            $contributors = Project_and_contributors::getEmail($id); 
            
            return view('contributors', compact('contributors', 'id'));
        }
    }
 
}
