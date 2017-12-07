<?php

namespace App\Http\Controllers\AuthApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class LoginController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client=Client::find(2);
    }



    public function login(Request $request){

        $this->validate($request,[
            'username' =>'required',
            'password' =>'required'
        ]);

        return "{
                \"token_type\": \"Bearer\",
                \"expires_in\": 7199,
                \"access_token\": \"mock_access\",
                \"refresh_token\": \"mock_refresh\"
                }";

    }

    public function refresh(Request $request){

      $this->validate($request,[

         'refresh_token' => 'required'

      ]);

        // ToDo : Add mock return

    }

    public function logout(Request $request){
         return response()->json([],204);
    }
}
