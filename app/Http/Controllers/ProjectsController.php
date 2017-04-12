<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Project;
use App\Project_and_contributors;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProjectsController extends Controller
{
    public function projects() {
	   	
	   	if( Auth::check() ){
	   		$user_id = Auth::user()->id;
		    $projects = Project::where('user_id', $user_id)->get();
			$allows = Project_and_contributors::getAllowedProjects(Auth::user()->id);

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
	    
	    
	    if($request->hasFile('uploadFile')) {
            
        	$file = $request->file('uploadFile');
        	
        	if($file->isValid()) {
                $file->move(public_path('uploads\\'), $file->getClientOriginalName());
            }
		}

		$project->file_path = $request->title . '_' . $file->getClientOriginalName();

	    $project->save();

	    return redirect('/');
	}

	public function delete($id) {
	    if(Auth::guest()){
			return redirect('/');
		}else{
		    Project::findOrFail($id)->delete();
		   	return redirect('/');
		}
	}

	public function show($id) {

		if(Auth::guest()){
			return redirect('/');
		}else{
			$project = Project::find($id);
        	return view('show', compact('project'));
        }
	}

	public function edit(Request $request){
		if(Auth::guest()){
			return redirect('/');
		}else{
			$project = Project::find($request->id);
			$project->title = $request->title;
			$project->description = $request->description;
			$project->category = $request->category;
			$project->save();
			
			return redirect()->route('show', ['id' => $request->id]);
		}
	}
}