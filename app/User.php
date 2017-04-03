<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fullName', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function allow(){

        return $this->hasMany(Project_and_contributors::class);
    
    }

    public static function getUsername($user_id){
        return User::where('id', $user_id)->first()->fullName;
    }

    public static function getEmail($id){
        return User::where('id', $id)->get();
    }

    public static function getid($email){
        return User::where('email', $email)->first()->id;
    }
}