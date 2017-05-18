<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Project_and_contributors;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Auth;

class SettingsController extends Controller
{
    public function show($pID)
    {
        if(Auth::guest()){
            return redirect('/');
        }else{
            $project = Project::find($pID);
            return view('settings', compact('project'));
        }
    }
}
