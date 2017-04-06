<?php

namespace App;

use App\User;
use App\Project;

class Employment extends Model
{
    protected $fillable = [
        'employment_id', 'employer', 'department', 'job Title', 'startDate', 'endDate', 'ongoing',
    ];
}
