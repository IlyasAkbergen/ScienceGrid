<?php

namespace App;

class Activity extends Model
{
	protected $fillable = [
        'user_id', 'project_id', 'activity', 'created_at', 'updated_at',
    ];
}
