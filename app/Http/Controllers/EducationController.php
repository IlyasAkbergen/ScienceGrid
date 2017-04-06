<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Project_and_contributors;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use App\Education;
use App\User_and_educations;

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
    
            $user_and_educations = new User_and_educations;
            $user_and_educations->user_id = Auth::user()->id;
            $user_and_educations->education_id = Education::all()->last()->education_id;
            $user_and_educations->save();

            
            return redirect('/editProfilePage');

        }
    }

     public function delete($id){

        if(Auth::guest()){
            return redirect('/');
        }else{
            Education::where('education_id', $id)->delete();
            User_and_educations::where('education_id', $id)->delete();
            return redirect('/editProfilePage');
        }
    }

}
