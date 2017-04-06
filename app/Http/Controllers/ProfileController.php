<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Education;
use App\Employment;
use App\User_and_employments;
use App\User_and_educations;
use Auth;

class ProfileController extends Controller
{
    public function show($id){

        if( Auth::check() ){
            $user_and_emp = User_and_employments::where('user_id', User::find($id)->first()->id)->get();
        
            $employments = array();
            
            if(!empty($user_and_emp)){
                $i = 0;
                foreach ($user_and_emp as $a) {
                    $employments[$i] = Employment::where('employment_id', $a->employment_id)->first();
                    $i++;
                }
            }

            $user_and_edu = User_and_educations::where('user_id', User::find($id)->first()->id)->get();
            
            $educations = array();

            if(!empty($user_and_edu)){
                $j=0;
                foreach ($user_and_edu as $b) {
                    $educations[$j] = Education::where('education_id', $b->education_id)->first();
                    $j++;
                }
            }

            return view('profile', compact('educations', 'employments', 'id'));
        }else{
            return view('auth.login');
        }

    	
	}

    public function show_for_edit(){

        if( Auth::check() ){
            $user_and_emp = User_and_employments::where('user_id', User::find(Auth::user()->id)->first()->id)->get();
        
            $employments = array();
            
            if(!empty($user_and_emp)){
                $i = 0;
                foreach ($user_and_emp as $a) {
                    $employments[$i] = Employment::where('employment_id', $a->employment_id)->first();
                    $i++;
                }
            }

            $user_and_edu = User_and_educations::where('user_id', User::find(Auth::user()->id)->first()->id)->get();
            
            $educations = array();

            if(!empty($user_and_edu)){
                $j=0;
                foreach ($user_and_edu as $b) {
                    $educations[$j] = Education::where('education_id', $b->education_id)->first();
                    $j++;
                }
            }

            return view('editProfile', compact('educations', 'employments'));
        }else{
            return view('auth.login');
        }
    }
}
