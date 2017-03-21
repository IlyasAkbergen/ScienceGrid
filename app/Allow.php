<?php

namespace App;

use App\User;
use App\Project;

class Allow extends Model
{

	public $timestamps = false;

	public function project(){

		return $this->belongsTo(Project::class); 

	}

    public static function getEmail($pID) {
	
		$allowed_results = Allow::where('project_id',$pID)->get();
		$output = '';

		foreach ($allowed_results as $a) {
			
			$allowed_email = User::getEmail($a->user_id);

			foreach ( $allowed_email as $allowed ) {
				$output = $output . $allowed->email . "\n";
            }
		}

		return $output;
	}


	public static function getAllowedProjects($uID){

		$pIDs = Allow::where('user_id', $uID)->get();
		$projects = array();
		
		$i = 0;
		foreach ($pIDs as $pID) {
			
			$projects[$i] = Project::where('id', $pID->project_id)->first();
			$i++;

		}

		return $projects;

	}

}
