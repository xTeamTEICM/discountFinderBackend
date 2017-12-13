<?php

namespace App\Http\Controllers;

use App\User ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateUserLocationController extends Controller
{
    public function list()
    {
        auth('api')->user();
        return User::all();
        //echo 'Test Test';
    }
    public function update(Request $request)
    {

        $user = auth('api')->user();

        $data = $this->validate($request, [
            'id' => 'required|integer',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $updatedUser = User::query()->where("id", "=", $user->id)->find($data['id']);
        if ($updatedUser) {
            $updatedUser->logPos = $data['logPos'];
            $updatedUser->latPos = $data['latPos'];
            echo 'Success';
        }
        $updatedUser->save();
        $updatedUser->push();

        return $updatedUser;
    }
}
