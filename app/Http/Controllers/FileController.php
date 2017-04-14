<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Project_and_files;

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
        	
        	if($file->isValid()) {
                $file->move(public_path('uploads\\'), $file->getClientOriginalName());
            }
		}

		$p_and_file = new Project_and_files;
		$p_and_file->project_id = $request->project_id;
		$p_and_file->file = $file->getClientOriginalName();
		$p_and_file->save();

		return redirect('show/' . $request->project_id);
    }
}
