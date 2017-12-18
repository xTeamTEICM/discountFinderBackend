<?php

namespace App\Http\Controllers;

use App\User ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UpdateUserLocationController extends Controller
{
    public function list()
    {
        return auth('api')->user();
    }

    public function update(Request $request)
    {

        $user = auth('api')->user();
        $data = $this->validate($request, [
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        if ($user) {
            $user->logPos = $data['logPos'];
            $user->latPos = $data['latPos'];
            $user->save();
            $user->push();
        }
    }
}
