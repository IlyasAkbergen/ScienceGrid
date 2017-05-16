<?php

namespace App;

use App\User;
use App\Project;

class Project_and_contributors extends Model
{

	public $timestamps = false;
	protected $fillable = ['permission'];

	public function project(){

		return $this->belongsTo(Project::class); 

	}

    public static function getContributor($pID) {
	
		$allowed_results = Project_and_contributors::where('project_id',$pID)->get();
		$output = '';
		$allows_array = array();
		$i = 0;

		foreach ($allowed_results as $a) {
			
			$allowed_email = User::getEmail($a->user_id);
			foreach ( $allowed_email as $allowed ) {
				// $output = $output . $allowed->email . "\n";
           		$allows_array[$i] = $allowed->fullName;
            }

            $i++;
		}

		return $allows_array;
	}


	public static function getAllowedProjects($uID){

		$pIDs = Project_and_contributors::where('user_id', $uID)->get();
		$projects = array();
		
		$i = 0;
		foreach ($pIDs as $pID) {
			$project = Project::where('id', $pID->project_id)->where('privacyLevel', 'private')->first();
			
			if( isset($project->id) ){
				$projects[$i] = $project; 
				$i++;	
			}

		}

		return $projects;

	}

	public static function getPerm($pID, $uID){

		return Project_and_contributors::where('project_id', $pID)->where('user_id',$uID)->first()->permission;

	}

}
