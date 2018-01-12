<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected static $id;

    public function testListSuccessful()
    {
        $response = $this->call('GET', 'api/category', [], []);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPOSTSuccessful()
    {
        $response = $this->json('POST', 'api/category', [
            'title' => 'TestProduct'
        ], []);
        self::$id = $response->decodeResponseJson()['id'];
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGETSuccessful()
    {
        $response = $this->json('GET', 'api/category/' . self::$id, [], []);
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testPUTSuccessful()
    {
        $response = $this->json('PUT', 'api/category/' . self::$id, [
            'title' => 'TestProductUpdated'
        ], []);
        $this->assertEquals('200', $response->getStatusCode()); //TODO Thelei implementation
    }

    public function testDeleteSuccessful()
    {
        $response = $this->json('DELETE', 'api/category/' . self::$id, [], []);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateNotExisted()
    {
        $response = $this->json('PUT', 'api/category/' . 999999, [
            'title' => 'TestProductUpdated'
        ], []);
        $this->assertEquals('404', $response->getStatusCode());
    }

    public function testDeleteNotExisted()
    {
        $response = $this->json('DELETE', 'api/category/' . 999999, [], []);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
