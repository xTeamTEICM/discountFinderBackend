<?php

namespace Tests\Feature\app\Http\Controllers;

use App\category;
use App\Http\Controllers\categoryController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Throwable;

class categorycontrollerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    protected static $idTest;

    public function idOfTestCase($titleRequested) {
        $allJson = category::all();
        $Json = array();
        $Json = json_decode($allJson,true);
        $length = count($Json);
        for ($i=0;$i<$length;$i++) {
            if ($Json[$i]['title'] == $titleRequested) {
                categorycontrollerTest::$idTest = $Json[$i]["id"];

            }
        }
    }
    public function testListSuccessfull()
    {
        $this->assertTrue(true);
    }

    public function testPOSTSuccessfull()
    {
        $this->idOfTestCase('TestProduct');
        $this->call('DELETE','api/category/'.categorycontrollerTest::$idTest);
        $response = $this->call('POST', 'api/category',['id'=>1,'title'=>'TestProduct']);
        $this->assertEquals(200, $response->getStatusCode());
 //       $this->call('DELETE', 'api/category/48');
    }

    public function testGETSuccessfull()
    {
        $response = $this->call('GET', 'api/category');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetWithID() {
        $this->idOfTestCase('TestProduct');
        $response = $this->call('GET','api/category/'.categorycontrollerTest::$idTest);
        $this->assertEquals('200',$response->getStatusCode());
    }

    public function testUpdateSuccessfull()
    {
        $this->call('POST', 'api/category',['id'=>1,'title'=>'TestProduct']);
        $this->idOfTestCase('TestProduct');
        $idOfUpdateCategoryOption =categorycontrollerTest::$idTest;
        $response = $this->call('PUT','api/category',['id'=>$idOfUpdateCategoryOption,'title'=>'TestProductUpdated']);
        $this->call('DELETE','api/category/'.categorycontrollerTest::$idTest);
        $this->assertEquals('200',$response->getStatusCode()); //TODO Thelei implementation
    }

    public function testDeleteSuccessfull()
    {
        $this->call('POST', 'api/category',['id'=>1,'title'=>'TestProduct']);
        $this->idOfTestCase('TestProduct');
        $response = $this->call('DELETE','api/category/'.categorycontrollerTest::$idTest);
        $this->assertEquals(200, $response->getStatusCode());
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



//    public function testListInvalidData()
//    {
//
//    }
//
//    public function testPOSTInvalidData()
//    {
//
//    }
//
//    public function testGETInvalidData()
//    {
//
//    }
//    public function testGetInvalidWithID($id) {
//
//    }
//
//    public function testUpdateInvalidData()
//    {
//
//    }
//
//    public function testDeleteInvalidData()
//    {
//
//    }
//
//    public function testIsNotPostingJson() { // TODO ???
//
//    }
}
