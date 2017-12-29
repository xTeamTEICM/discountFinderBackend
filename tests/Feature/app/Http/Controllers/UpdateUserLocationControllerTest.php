<?php

namespace Tests\Feature;

use Tests\AuthForTests;
use Tests\TestCase;

class UpdateUserLocationControllerTest extends TestCase
{
    public function testUpdateLocationUnauthorized()
    {
        $response = $this->json('PUT', '/api/user/deviceLocation', [], []);
        $response->assertStatus(401);
    }

    public function testUpdateLocationEmpty()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', '/api/user/deviceLocation', [], [
            'Authorization' => $tokenKey
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateLocationInvalidLatLog()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', '/api/user/deviceLocation', [
            'logPos' => '123',
            'latPos' => '456'
        ], [
            'Authorization' => $tokenKey
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateLocationSuccess()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', '/api/user/deviceLocation', [
            'logPos' => '12.34',
            'latPos' => '56.78'
        ], [
            'Authorization' => $tokenKey
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateLocationSuccessVathylakkos()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', '/api/user/deviceLocation', [
            'logPos' => '22.708959',
            'latPos' => '40.769614'
        ], [
            'Authorization' => $tokenKey
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateLocationSuccessMammasPizza()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', '/api/user/deviceLocation', [
            'logPos' => '23.543211',
            'latPos' => '41.082201'
        ], [
            'Authorization' => $tokenKey
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateLocationSuccessTEICafe()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', '/api/user/deviceLocation', [
            'logPos' => '23.553907',
            'latPos' => '41.074601'
        ], [
            'Authorization' => $tokenKey
        ]);
        $response->assertStatus(200);
    }

    public function testGetLocationUnauthorized()
    {
        $response = $this->json('GET', '/api/user/deviceLocation', [], []);
        $response->assertStatus(401);
    }

    public function testGetLocationSuccess()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', '/api/user/deviceLocation', [], [
            'Authorization' => $tokenKey
        ]);
        $response->assertStatus(200);
    }

}
