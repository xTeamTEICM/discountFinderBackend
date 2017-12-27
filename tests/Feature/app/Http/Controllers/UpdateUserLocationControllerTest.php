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

    public function testUpdateLocationSuccess()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', '/api/user/deviceLocation', [
            'logPos' => '123',
            'latPos' => '321'
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
