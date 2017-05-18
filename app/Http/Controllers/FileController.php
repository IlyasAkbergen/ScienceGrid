<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Project_and_files;
use App\Activity;
use Auth;
class FileController extends Controller
{
   
    public function download($filename)
    {
        $filetodownload="./uploads/" . $filename;
        return Response::download($filetodownload);
    }

    public function upload(Request $request){

    	if($request->hasFile('uploadFile')) {
            
        	$file = $request->file('uploadFile');
            $size = $request->file('uploadFile')->getClientSize();
        	
        	if($file->isValid()) {
                $file->move(public_path('uploads\\'), $file->getClientOriginalName());
            }
		}

		$p_and_file = new Project_and_files;
		$p_and_file->project_id = $request->project_id;
		$p_and_file->file = $file->getClientOriginalName();
        $p_and_file->size = $size;
		$p_and_file->save();

        $activity = new Activity;
        $activity->user_id = Auth::user()->id;
        $activity->project_id = $request->project_id;
        $activity->activity = "uploaded new file";
        $activity->save();


		return redirect('show/' . $request->project_id);
    }
}
