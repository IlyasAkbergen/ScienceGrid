<?php

namespace App;

use App\User;
use App\Project;

class User_and_employments extends Model
{
    protected $fillable = [
        'id', 'user_id', 'employment_id',
    ];
}
