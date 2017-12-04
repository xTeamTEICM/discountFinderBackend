<?php

namespace Tests\Feature\AuthApi;



use Illuminate\Support\Facades\DB;

use Tests\TestCase;


class LoginControllerTest extends TestCase
{
    protected static $AuthValues;


    public function testRegisterUser()
    {

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'sotiris',
            'lastName' => 'yolo4',
            'eMail' => 'AuthTestEmailAuthTestEmail@hotmail.com',
            'password' => '1234567'
        ]);

        $response->assertJsonStructure(['token_type', 'expires_in', 'access_token', 'refresh_token']);

    }



    public function testRegisterUserEmailExists()
    {

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'kwstas',
            'lastName'=>'yolo22',
            'eMail'=>'AuthTestEmailAuthTestEmail@hotmail.com',
            'password'=>'123456722'
        ]);

        $response->assertJson([
            'errors'=>['eMail'=>['The e mail has already been taken.']]]);

    }





    public function testLoginUser(){
        $response = $this->json('POST', 'api/login', [

            'username'=>'AuthTestEmailAuthTestEmail@hotmail.com',
            'password'=>'1234567'
        ]);
        LoginControllerTest::$AuthValues=json_decode($response->getContent(),true);


        $response->assertJsonStructure(['token_type','expires_in','access_token','refresh_token']);


    }

    public function testInvalidLoginUserPassword(){
        $response = $this->json('POST', 'api/login', [

            'username' => 'AuthTestEmailAuthTestEmail@hotmail.com',
            'password' => '123456789'
        ]);
        $response->assertJson(['message'=>'The user credentials were incorrect.']);


    }

    public function testInvalidLoginUserEmail(){
        $response = $this->json('POST', 'api/login', [

            'username' => '111AuthTestEmailAuthTestEmail@hotmail.com',
            'password' => '1234567'
        ]);
        $response->assertJson(['message'=>'The user credentials were incorrect.']);


    }



    public function testEndPointUser(){
        $token=LoginControllerTest::$AuthValues['access_token'];

        $response= $this->withHeader('Authorization','Bearer ' . $token)->json('GET','api/user');

        $response->assertStatus(200);

    }

    public function testInvalidToken(){
        $token=LoginControllerTest::$AuthValues['access_token'];

        $response= $this->withHeader('Authorization','Bearer ' . $token.'sdds')->json('GET','api/user');

        $response->assertJson(['message'=>'Unauthenticated.']);

    }



    public function testRefreshToken(){

        $refreshToken=LoginControllerTest::$AuthValues['refresh_token'];
        $response = $this->json('POST', 'api/refresh', [

            'refresh_token' => $refreshToken,

        ]);
        LoginControllerTest::$AuthValues=json_decode($response->getContent(),true);

        $response->assertStatus(200);

    }

    public function testLogout(){
        $token=LoginControllerTest::$AuthValues['access_token'];

        $response= $this->withHeader('Authorization','Bearer ' . $token)->json('POST','api/logout');
           //Status 204 :The server successfully processed the request and is not returning any content
        $response->assertStatus(204);


    }



    public function testDeleteUser(){

        DB::table('users')->where('eMail','AuthTestEmailAuthTestEmail@hotmail.com')->delete();

        $this->assertDatabaseMissing('users', [
            'eMail' => 'AuthTestEmailAuthTestEmail@hotmail.com'
        ]);
    }



}
