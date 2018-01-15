<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //edo vazoume oti theloume na stelnoume sto frondEnd me to /user
    protected $fillable = [
        'firstName', 'lastName', 'eMail', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // edo oti den theloume na stelnoume sto frondEnd me to /user (to password eno einai kai pano afou bike kai sta hidden den stelnetai)
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $coordinates = [
        'latPos', 'logPos'
    ];
}
