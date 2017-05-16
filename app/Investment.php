<?php
namespace App;
use App\User;
use App\Project;


class Investment extends Model
{
    protected $fillable = [
        'user_id', 'project_id', 'sum',
    ];
}
