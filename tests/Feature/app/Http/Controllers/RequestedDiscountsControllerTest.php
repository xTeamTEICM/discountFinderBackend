<?php

namespace Tests\Feature;

use Tests\AuthForTests;
use Tests\TestCase;

class requestedDiscountsControllerTest extends TestCase
{
    protected static $id;


    public function testPostNotExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('POST', 'api/requestedDiscount', [
            'category' => '1',
            'price' => '999',
            'tags' => 'testingAPI'
        ], [
            'Authorization' => $tokenKey
        ]);

        requestedDiscountsControllerTest::$id = $response->decodeResponseJson()['id'];

        $response->assertStatus(200);
        $response->assertJsonStructure(['userId', 'category', 'price', 'tags', 'id']);
    }

    public function testPostNotExisted2()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('POST', 'api/requestedDiscount', [
            'category' => '2',
            'price' => '123',
            'tags' => 'Fgj'
        ], [
            'Authorization' => $tokenKey
        ]);

        requestedDiscountsControllerTest::$id = $response->decodeResponseJson()['id'];

        $response->assertStatus(200);
        $response->assertJsonStructure(['userId', 'category', 'price', 'tags', 'id']);
    }

    public function testList()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', 'api/requestedDiscount', [], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([['userId', 'category', 'price', 'tags', 'id', 'categoryTitle']]);
    }

    public function testGetExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', 'api/requestedDiscount/' . requestedDiscountsControllerTest::$id, [], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'userId', 'category', 'price', 'tags', 'categoryTitle']);
    }

    public function testGetNotExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', 'api/requestedDiscount/0', [], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Requested discount not found'
        ]);
    }

    public function testPutExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/requestedDiscount/' . requestedDiscountsControllerTest::$id, [
            'category' => '1',
            'price' => '999',
            'tags' => 'testingAPI2'
        ], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'userId', 'category', 'price', 'tags']);

    }

    public function testPutExisted2()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/requestedDiscount/' . requestedDiscountsControllerTest::$id, [
            'category' => '2',
            'price' => '123',
            'tags' => 'Fgj'
        ], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'userId', 'category', 'price', 'tags']);

    }

    public function testPutNotExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/requestedDiscount/0', [
            'category' => '1',
            'price' => '999',
            'tags' => 'testingAPI2'
        ], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Requested discount not found'
        ]);
    }


    public function testPutNotExisted2()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/requestedDiscount/0', [
            'category' => '2',
            'price' => '123',
            'tags' => 'Fgj'
        ], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Requested discount not found'
        ]);
    }

    public function testDeleteExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('DELETE', "api/requestedDiscount/" . self::$id,
            [],
            [
                'Authorization' => $tokenKey
            ]);

        $response->assertStatus(200);
    }


    public function testDeleteNotExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('DELETE', "api/requestedDiscount/" . 999999999999,
            [],
            [
                'Authorization' => $tokenKey
            ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Requested discount not found'
        ]);
    }

    public function testDeleteNotExisted2()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('DELETE', "api/requestedDiscount/" . 21,
            [],
            [
                'Authorization' => $tokenKey
            ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Requested discount not found'
        ]);
    }
}
