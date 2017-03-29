<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Allow;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProjectsController extends Controller
{
    public function projects() {
	   	
	   	if( Auth::check() ){
	   		$email = Auth::user()->email;
		    $projects = Project::where('email', $email)->get();
			$allows = Allow::getAllowedProjects(Auth::user()->id);

			$i = count($projects);

			foreach ($allows as $allow) {
				
				$projects[$i] = $allow;
				$i++;

			}


		    return view('projects', ['projects' => $projects]); //edited
	   	}else{
	   		return view('auth.login');
	   	}
    
    }

    public function create(Request $request) {
	
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
	    $project->body = $request->body;
	    $project->email = Auth::user()->email;
	    $project->category = $request->category; 
	    // Category::where('name', $category)->first()->id;
	    $project->save();

	    return redirect('/');
	
	}

	public function delete($id) {
	    
	    Project::findOrFail($id)->delete();

	    return redirect('/');

	}

	public function show($id) {

		$project = Project::find($id);

		return view('show', compact('project'));

	}

	public function edit(Request $request){

		$project = Project::find($request->id);
		$project->body = $request->body;
		$project->save();

		return view('show', compact('project'));

	}
}