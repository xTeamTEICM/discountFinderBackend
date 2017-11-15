<?php

namespace Tests\Feature\AuthApi;

use Tests\TestCase;




class RegisterControllerTest extends TestCase
{



    /**
     * A basic test example.
     *
     * @return void
     */

    public function testExample()
    {
        $this->assertTrue(true);

    }

    //TODO issue:  database.... testings adds users on real database
    //TODO Test user if exists


    public function testInvalidEmailDuckSymbol(){

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'sotiris',
            'lastName'=>'yolo4',
            'eMail'=>'sotirishotmail.com',
            'password'=>'1234567'
        ]);
        $response->assertJson([
            'errors'=>['eMail'=>['The e mail must be a valid email address.']]]);

   }
    public function testInvalidEmailDot(){

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'sotiris',
            'lastName'=>'yolo4',
            'eMail'=>'sotiris@hotmailcom',
            'password'=>'1234567'
        ]);
        $response->assertJson([
            'errors'=>['eMail'=>['The e mail must be a valid email address.']]]);

    }

    public function testInvalidPasswordMin6(){

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'sotiris',
            'lastName'=>'yolo4',
            'eMail'=>'sotiris@hotmailcom',
            'password'=>'12345'
        ]);
        $response->assertJson([
            'errors'=>['password'=>['The password must be at least 6 characters.']]]);

    }

    public function testInvalidPasswordMax50(){

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'sotiris',
            'lastName'=>'yolo4',
            'eMail'=>'sotiris@hotmailcom',
            'password'=>'12345ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss'
        ]);
        $response->assertJson([
            'errors'=>['password'=>['The password may not be greater than 50 characters.']]]);

    }

    public function testEmptyFieldFirstName()
    {

        $response = $this->json('POST', 'api/register', [

            'lastName' => 'yolo4',
            'eMail' => 'sotiris@hotmailcom',
            'password' => '1234567'
        ]);
        $response->assertJson([
            'errors' => ['firstName' => ['The first name field is required.']]]);

    }
        public function testEmptyFieldLastName()
        {

            $response = $this->json('POST', 'api/register', [
                'firstName' => 'sotiris',

                'eMail' => 'sotiris@hotmailcom',
                'password' => '1234567'
            ]);
            $response->assertJson([
                'errors' => ['lastName' => ['The last name field is required.']]]);


        }

    public function testEmptyFieldEmail(){

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'sotiris',
            'lastName'=>'yolo4',

            'password'=>'12345ssss'
        ]);
        $response->assertJson([
            'errors'=>['eMail'=>['The e mail field is required.']]]);

    }

    public function testEmptyFieldPassword(){

        $response = $this->json('POST', 'api/register', [
            'firstName' => 'sotiris',
            'lastName'=>'yolo4',
            'eMail' => 'sotiris@hotmailcom'

        ]);
        $response->assertJson([
            'errors'=>['password'=>['The password field is required.']]]);

    }

}
