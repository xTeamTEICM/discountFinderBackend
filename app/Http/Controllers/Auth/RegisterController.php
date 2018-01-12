<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class RegisterController extends Controller
{
    private $client;

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->client = Client::find(2);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'eMail' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6|max:50',
        ]);

        $user = User::create([
            'firstName' => request('firstName'),
            'lastName' => request('lastName'),
            'eMail' => request('eMail'),
            'password' => bcrypt(request('password')),
        ]);

        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('eMail'),
            'password' => request('password'),
            'scope' => '*'
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }
}
