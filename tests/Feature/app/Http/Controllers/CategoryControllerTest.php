<?php

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected static $idTest;

    public function idOfTestCase($titleRequested)
    {
        $allJson = Category::all();
        $Json = array();
        $Json = json_decode($allJson, true);
        $length = count($Json);
        for ($i = 0; $i < $length; $i++) {
            if ($Json[$i]['title'] == $titleRequested) {
                self::$idTest = $Json[$i]["id"];

            }
        }
    }

    public function testListSuccessful()
    {
        $response = $this->call('GET', 'api/category');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPOSTSucessful()
    {
        $this->idOfTestCase('TestProduct');
        $this->call('DELETE', 'api/category/' . self::$idTest);
        $response = $this->call('POST', 'api/category', ['id' => 1, 'title' => 'TestProduct']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGETSuccessful()
    {
        $response = $this->call('GET', 'api/category');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetWithID()
    {
        $this->idOfTestCase('TestProduct');
        $response = $this->call('GET', 'api/category/' . CategoryControllerTest::$idTest);
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testUpdateSuccessful()
    {
        $this->call('POST', 'api/category', ['id' => 1, 'title' => 'TestProduct']);
        $this->idOfTestCase('TestProduct');
        $idOfUpdateCategoryOption = self::$idTest;
        $response = $this->call('PUT', 'api/category/' . CategoryControllerTest::$idTest, ['title' => 'TestProductUpdated']);
        $this->call('DELETE', 'api/category/' . CategoryControllerTest::$idTest);
        $this->assertEquals('200', $response->getStatusCode()); //TODO Thelei implementation
    }

    public function testDeleteSuccessful()
    {
        $this->call('POST', 'api/category', ['id' => 1, 'title' => 'TestProduct']);
        $this->idOfTestCase('TestProduct');
        $response = $this->call('DELETE', 'api/category/' . CategoryControllerTest::$idTest);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateNotExisted()
    {
        $response = $this->call('PUT', 'api/category/' . 999999, ['title' => 'TestProductUpdated']);
        $this->assertEquals('404', $response->getStatusCode());
    }

    public function testDeleteNotExisted()
    {
        $response = $this->call('DELETE', 'api/category/' . 999999);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testIsPostingJSON()
    {
        $this->get('api/category')
            ->assertJsonStructure([
                '*' => ['id',
                    'title'
                ]
            ]);
    }

    //TODO
    public function testListInvalidData()
    {
        $this->assertTrue(true);
    }

    public function testPOSTInvalidData()
    {
        $this->assertTrue(true);
    }

    public function testGETInvalidData()
    {
        $this->assertTrue(true);
    }

    public function testGetInvalidWithID()
    {
        $this->assertTrue(true);
    }

    public function testUpdateInvalidData()
    {
        $this->assertTrue(true);
    }

    public function testDeleteInvalidData()
    {
        $this->assertTrue(true);
    }

    public function testIsNotPostingJson()
    { // TODO ???
        if ((!$response = $this->get('api/category')
            ->assertJsonStructure([
                '*' => ['id',
                    'title'
                ]
            ]))) {
            $this->assertTrue(false);
            //$this->assertTrue(true);
        } else $this->assertFalse(false);
    }
}
