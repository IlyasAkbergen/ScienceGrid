<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Project_and_contributors;
use App\Category;
use App\Activity;
use Illuminate\Support\Facades\Validator;
use Auth;

class ContributorsController extends Controller
{
    public function show($id)
    {
        if (Auth::guest()) {
            return redirect('/');
        } else {
            $contributors = array();
            $contributors = Project_and_contributors::getContributor($id);

            return view('contributors', compact('contributors', 'id'));
        }
    }

    public function edit(Request $request){

        $allow = Project_and_contributors::where('project_id', $request->pID)->where('user_id', $request->uID)->first();
        $allow->permission = $request->permission;
        $allow->save();

        $activity = new Activity;
        $activity->user_id = Auth::user()->id;
        $activity->project_id = $request->pID;
        $activity->activity = "changed permission for contributor";
        $activity->save();

        return 0;
    }

    public static function canRead($pID, $uID){

        $perm = Project_and_contributors::where('project_id', $pID)->where('user_id', $uID)->first()->permission;

        if ( $perm == 'Read' ) {
            return true;
        } else {
            return false;
        }
    }

    public static function canWrite($pID, $uID){

        $perm = Project_and_contributors::where('project_id', $pID)->where('user_id', $uID)->first();
    
        if( isset($perm->permission) && $perm == 'Read+Write' ){
            return true;
        } else {
            return false;
        }
    }
}
