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
use App\Education;

class EducationController extends Controller
{
   
    public function create(request $request)
    {
        if(Auth::guest()){
            return redirect('/editProfilePage');
        }else{

            $education = new Education;
            $education->universityName = $request->institution;
            $education->department = $request->department;
            $education->degree = $request->degree;
            $education->startDate = $request->startmonth . ', ' . $request->startyear;
            $education->endDate = $request->endmonth . ', ' . $request->endyear;
            
            if($request->ongoing === 'on'){
                $education->ongoing = 1;
            }else{
                $education->ongoing = 0;
            }
            
            $education->save();
    
            $user = User::find(Auth::user()->id);
            $user->education_id = Education::all()->last()->education_id;
            $user->save();

            return redirect('/editProfilePage');

        }
    }
}
