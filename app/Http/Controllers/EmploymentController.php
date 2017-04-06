<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Project_and_contributors;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Employment;
use App\User;

class EmploymentController extends Controller
{
    
    public function create(Request $request)
    {
        if(Auth::guest()){
            return redirect('/editProfilePage');
        }else{

            $employment = new Employment;
            $employment->employer = $request->employer;
            $employment->department = $request->department;
            $employment->jobTitle = $request->jobTitle;
            $employment->startDate = $request->startmonth . ', ' . $request->startyear;
            $employment->endDate = $request->endmonth . ', ' . $request->endyear;
            
            if($request->ongoing === 'on'){
                $employment->ongoing = 1;
            }else{
                $employment->ongoing = 0;
            }
            $employment->save();
    
            $user = User::find(Auth::user()->id);
            $user->employment_id = Employment::all()->last()->employment_id;
            $user->save();

            return redirect('/editProfilePage');

        }
    }

}
