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

            $user_and_emp = User_and_employments::where('user_id', User::where('id',$id)->first()->id)->get();
        
            $employments = array();
            
            if(!empty($user_and_emp)){
                $i = 0;
                foreach ($user_and_emp as $a) {
                    $employments[$i] = Employment::where('employment_id', $a->employment_id)->first();
                    $i++;
                }
            }

            $user_and_edu = User_and_educations::where('user_id', User::where('id', $id)->first()->id)->get();
            
            $educations = array();

            if(!empty($user_and_edu)){
                $j=0;
                foreach ($user_and_edu as $b) {
                    $educations[$j] = Education::where('education_id', $b->education_id)->first();
                    $j++;
                }
            }

            $profile = User::where('id', $id)->first();

            return view('profile', compact('educations', 'employments', 'profile', 'id'));
        }else{
            return redirect('/');
        }

    	
	}

    public function show_for_edit($id){

        if( $id == Auth::user()->id || Auth::user()->role === 'admin' ){
           
            $user_and_emp = User_and_employments::where('user_id', User::where('id', $id)->first()->id)->get();
        
            $employments = array();
            
            if(!empty($user_and_emp)){
                $i = 0;
                foreach ($user_and_emp as $a) {
                    $employments[$i] = Employment::where('employment_id', $a->employment_id)->first();
                    $i++;
                }
            }

            $user_and_edu = User_and_educations::where('user_id', User::where('id', $id)->first()->id)->get();
            
            $educations = array();

            if(!empty($user_and_edu)){
                $j=0;
                foreach ($user_and_edu as $b) {
                    $educations[$j] = Education::where('education_id', $b->education_id)->first();
                    $j++;
                }
            }

            $profile = User::where('id', $id)->get();

            return view('editProfile', compact('educations', 'employments', 'profile'));
        }else{
            return redirect('/');
        }
    }
}
