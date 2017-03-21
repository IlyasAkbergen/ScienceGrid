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
        'id', 'name', 'email', 'password',
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

        return $this->hasMany(Allow::class);
    
    }

    public static function getUsername($email){
        return User::where('email', $email)->first()->name;
    }

    public static function getEmail($id){
        return User::where('id', $id)->get();
    }

    public static function getid($email){
        return User::where('email', $email)->first()->id;
    }
}