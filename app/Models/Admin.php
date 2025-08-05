<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//Model to authenticable
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;


    //!ADDED THIS FOR EDIT PROFILE ADMIN SO IT CAN BE FILLED OR UPDATE FROM THE DB
    protected $fillable = [
        'name', 'email', 'password', 'photo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
