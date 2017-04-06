<?php

namespace App;

use App\User;
use App\Project;

class User_and_educations extends Model
{
    protected $fillable = [
        'id', 'user_id', 'education_id',
    ];
}
