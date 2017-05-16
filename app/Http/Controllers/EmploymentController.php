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
use App\User_and_employments;


class EmploymentController extends Controller
{
    
    public function create(Request $request)
    {
        if(Auth::guest()){
            return redirect('/');
        }else{

            $employment = new Employment;
            $employment->employer = $request->employer;
            $employment->department = $request->department;
            $employment->jobTitle = $request->jobTitle;
            $employment->startDate = $request->startmonth . ', ' . $request->startyear;
            $employment->endDate = $request->endmonth . ', ' . $request->endyear;
            
            if ($request->ongoing === 'on') {
                $employment->ongoing = 1;
            } else {
                $employment->ongoing = 0;
            }
            $employment->save();
            $user_and_employments = new User_and_employments;
            $user_and_employments->user_id = Auth::user()->id;
            $user_and_employments->employment_id = Employment::all()->last()->employment_id;
            $user_and_employments->save();


            return redirect('/editProfilePage' . '/' . Auth::user()->id);

        }
    }

    public function delete($id){

        if(Auth::guest()){
            return redirect('/');
        }else{
            Employment::where('employment_id', $id)->delete();
            User_and_employments::where('employment_id', $id)->delete();
            return redirect('/editProfilePage' . '/' . Auth::user()->id);
        }
    }
}
