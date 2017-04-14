<?php

namespace App;

use App\User;
use App\Project;

class Project_and_files extends Model
{
    protected $fillable = [
        'id', 'project_id', 'file',
    ];
}
