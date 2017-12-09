<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class deviceTokenController extends Controller
{


    public function setDeviceToken(Request $request){


        $this->validate($request,[
            'deviceToken' => 'required|String',
        ]);

        $id=auth('api')->user()->id;
       User::query()
           ->where("id", "=", $id)
           ->update(['deviceToken'=>request('deviceToken')]);


    }
}
