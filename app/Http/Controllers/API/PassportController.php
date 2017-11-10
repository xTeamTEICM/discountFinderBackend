<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController extends Controller
{

    protected $successStatus = 200;


    public function login(){
        if(Auth::attempt(['eMail' => request('eMail'), 'password' => request('password')])){

            return response()->json( $this->successStatus);
        }
        else{
            return response()->json(['STATUS'=>'BAD','error'=>'Unauthorised']);
        }
    }




    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'eMail' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6|max:50',
            'passwordSalt'=>'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->firstName;

        return response()->json(['success'=>$success], $this->successStatus);
    }


    //epistrofh stoixion  xrhsth mazi me status succes =200
    public function getDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}