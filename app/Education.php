<?php

namespace App;

use App\User;
use App\Project;

class Education extends Model
{
    protected $fillable = [
        'education_id', 'universityName', 'department', 'degree', 'startDate', 'endDate', 'ongoing',
    ];
}
