<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Project_and_contributors;
use App\Category;
use App\User;

use Illuminate\Support\Facades\Validator;
use Auth;

class UsersController extends Controller
{
    
    public function investors(){

        if( Auth::check() ){
            $investors = User::where('role', 'investor')->get();
            return view('investors', compact('investors'));
        }else{
            return view('home');
        }
    }

    public function update(Request $request)
    {
        if( Auth::check() ){
            $user = User::find(Auth::user()->id);
            $user->fullName = $request->fullName;
            $user->address = $request->address;
            $user->save();

            return redirect()->route('editProfilePage');
        }else{
            return view('auth.login');
        }
    }

    public function search(request $request)
    {
        $result = $request->session()->all();//получаем данные из сессии
        $token = $result['_token'];
        $result = User::where('fullName', 'like', '%' . $request->search_name . '%')->get();
        $data = array();
        $i=0;
        foreach ( $result as $a ) {
            if( $a->id == Auth::user()->id ){
                continue;
            }
            $data[$i] = $a->id;
            $data[$i+1] = $a->fullName;
            $data[$i+2] = $a->email;
            $i+=3;
        }
        $dataJson = json_encode($data);
        return $data;
    }

    public function addRightCol(request $request){

        $result = $request->session()->all();//получаем данные из сессии
        $token = $result['_token'];
        $result = User::where('id', $request->id)->first();

        $data = array();
    
        $data[0] = $result->id;
        $data[1] = $result->fullName;
        $data[2] = $result->email;
        
        $dataJson = json_encode($data);
        return $data;

    }
}
