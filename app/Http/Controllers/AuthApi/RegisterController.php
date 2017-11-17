<?php

namespace App\Http\Controllers\AuthApi;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class RegisterController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client=Client::find(2);
    }

    public function  register(Request $request){

        $this->validate($request,[

                'firstName' => 'required|max:50',
                'lastName' => 'required|max:50',
                'eMail' => 'required|email|max:50|unique:users',
                'password' => 'required|min:6|max:50',
                 //'password_confirm' => 'required|same:password' (auto an apofasisoume na exoume repeat password gia na n kanei lathos o xrhsths)dn xreiazetai kapia prosthiki sti vash


        ]);

        $user =User::create([

            'firstName' => request('firstName'),
            'lastName' => request('lastName'),
            'eMail' => request('eMail'),
            'password' => bcrypt(request('password')),
            'passwordSalt'=> request('password')  //auto i to svinoume i to ftiaxnoume kapos kalitera pros to paron pernaei to kodiko user sti vash xwris crypt
            //douleuei an exoume crypt kodiko sti vash kai dn to vlepoume oute emeis dn einai aparaithto na ton vlepoume


        ]);

         $params =[

             'grant_type' => 'password',
             'client_id' => $this->client->id,
             'client_secret' =>$this->client->secret,
             'username' => request('eMail'),
             'password' => request ('password'),
             'scope' => '*'

         ];

         $request->request->add($params);

         $proxy= Request::create('oauth/token','POST');

         return Route::dispatch($proxy);

    }
}
