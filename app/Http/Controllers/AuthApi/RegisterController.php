<?php

namespace App\Http\Controllers\AuthApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        return "{
                \"token_type\": \"Bearer\",
                \"expires_in\": 7199,
                \"access_token\": \"mock_access\",
                \"refresh_token\": \"mock_refresh\"
                }";

    }
}
