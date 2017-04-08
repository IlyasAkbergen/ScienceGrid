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
            $data[$i] = $a->id;
            $data[$i+1] = $a->fullName;
            $data[$i+2] = $a->email;
            $i+=3;
        }
        $dataJson = json_encode($data);
        return $data;
    }
}
