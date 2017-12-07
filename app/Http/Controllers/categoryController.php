<?php

namespace App\Http\Controllers;

use App\category;
use Illuminate\Support\Facades\Input;

class categoryController extends Controller
{
    //
    public function list () {
        return "[
                    {
                        \"id\": 1,
                        \"title\": \"Computers\"
                    },
                    {
                        \"id\": 4,
                        \"title\": \"Food\"
                    },
                    {
                        \"id\": 2,
                        \"title\": \"Laptops\"
                    },
                    {
                        \"id\": 41,
                        \"title\": \"PDAs\"
                    },
                    {
                        \"id\": 3,
                        \"title\": \"Shoes\"
                    }
                ]";
    }
    public function get($id){
        return "{
                    \"id\": $id,
                    \"title\": \"Computers\"
                }";
    }
    public function post(){
        $category = new category();
        $category->title = Input::get('title');
        return $category;
    }
    public function update(){
        $category = category::find(Input::get('id'));
        $category->title = Input::get('title');
        return $category;
    }
    public function remove($title){
        // ToDo ??
    }

}
