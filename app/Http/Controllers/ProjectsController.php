<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Project;
use App\Project_and_contributors;
use App\Project_and_files;
use App\Category;
use App\Investment;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProjectsController extends Controller
{
    public function projects() {
	   	
	   	if( Auth::check() ){
	   		if( Auth::user()->role !== 'investor' ){
		   		$user_id = Auth::user()->id;
			    $projects = Project::where('privacyLevel', 'public')->get();
				$allows = Project_and_contributors::getAllowedProjects(Auth::user()->id);

				$i = count($projects);
				foreach ($allows as $allow) {
					
					$projects[$i] = $allow;
					$i++;

				}

			} else {

				$projects = Project::where('privacyLevel', 'public')->get();

			}

		    return view('projects', ['projects' => $projects]); 
	   	}else{
	   		return view('auth.login');
	   	}
    }

    public function create(Request $request) {

		$destinationPath = public_path() . '/uploads/';

	    $validator = Validator::make($request->all(), [
	        'title'  => 'required|max:255'
	    ]);

	    if ($validator->fails()) {
	        return redirect('/')
	            ->withInput()
	            ->withErrors($validator);
	    }

	    $project = new Project;
	    $project->title = $request->title;
	    $project->description = $request->description;
	    $project->user_id = Auth::user()->id;
	    $project->category = $request->category;

	    $project->save();

	    if($request->hasFile('uploadFile')) {

        	$file = $request->file('uploadFile');

        	if($file->isValid()) {
                $file->move(public_path('uploads\\'), $file->getClientOriginalName());
            }
		}

		$p_and_file = new Project_and_files;
		$p_and_file->project_id = Project::all()->last()->id;
		$p_and_file->file = $file->getClientOriginalName();
		$p_and_file->save();

	    return redirect('/');
	}

	public function delete($id) {
	    if (Auth::guest()) {
			return redirect('/');
		} else {
		    Project::findOrFail($id)->delete();
		   	return redirect('/');
		}
	}

	public function show($id) {

		if (Auth::guest()) {
			return redirect('/');
		} else {
			$project = Project::find($id);
			$files = Project_and_files::where('project_id', $id)->get();
			$investments = Investment::where('project_id', $id)->get();
        	return view('show', compact('project', 'files', 'investments'));
        }
	}

	public function edit(Request $request){
		if (Auth::guest()) {
			return redirect('/');
		} else {
			$project = Project::find($request->id);
			$project->title = $request->title;
			$project->description = $request->description;
			$project->category = $request->category;
			$project->save();

			return redirect()->route('show', ['id' => $request->id]);
		}
	}
}
