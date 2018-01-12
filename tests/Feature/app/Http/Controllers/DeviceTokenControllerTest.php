<?php


namespace Tests\Feature;

use Tests\AuthForTests;
use Tests\TestCase;

class deviceTokenControllerTest extends TestCase
{

    public function testPutEmptyBody()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/user/deviceToken', [

        ], [
            "Authorization" => $tokenKey
        ]);

        $response->assertStatus(422);

    }

    public function testPutWithBodyInvalid()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/user/deviceToken', [
            'deviceToken' => 12313213123123123123
        ], [
            "Authorization" => $tokenKey
        ]);

        $response->assertStatus(422);
    }

    public function testPutWithBodyValid()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/user/deviceToken', [
            'deviceToken' => 'lalakis'
        ], [
            "Authorization" => $tokenKey
        ]);

        $response->assertStatus(200);
    }


}
