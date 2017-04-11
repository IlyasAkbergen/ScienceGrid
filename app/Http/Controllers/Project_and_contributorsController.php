<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Project_and_contributors;
use Illuminate\Support\Facades\Validator;
use Auth;


class Project_and_contributorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function create(Request $request)
    {
   
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email|max:255'
        // ]);

        // if ($validator->fails()) {
        //     return redirect('/')
        //         ->withInput()
        //         ->withErrors($validator);
        // }

        $ids = array();
        $ids = explode(" ", $request->cString);

        
        foreach ($ids as $uID) {
            if( Project_and_contributors::where('project_id', $request->pID)->where('user_id', $uID)->count('user_id') > 0){
                
               continue;
            
            }
        
            $allow = new Project_and_contributors; 
            $allow->project_id = $request->pID;
            $allow->user_id = $uID; 
            $allow->save();
            
        }

        return redirect('/');
    }


    public function delete($pID, Request $request) {
      
       $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $uID = User::getid($request->email);

        Project_and_contributors::where('project_id', $pID)->where('user_id', $uID)->delete();

        return redirect('/');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
