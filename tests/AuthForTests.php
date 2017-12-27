<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 27/12/2017
 * Time: 2:43 μμ
 */

namespace Tests;


class AuthForTests extends TestCase
{
    public $token = "EMPTY";

    /**
     * AuthForTests constructor.
     * @param $motherClass
     * @throws \Exception
     */
    public function generateToken(TestCase $motherClass)
    {

        $response = $motherClass->json('POST', '/api/login', [
            'username' => 'user@jnksoftware.eu',
            'password' => 'myPassword'
        ], []);

        $this->token = 'Bearer ' . $response->decodeResponseJson()['access_token'];

    }

    public function getToken()
    {
        return $this->token;
    }


}