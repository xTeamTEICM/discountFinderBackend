<?php

namespace App\Http\Controllers;

use App\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class categoryController extends Controller
{
    //
    public function list () {
        return category::all();
    }
    public function get($id){
        return category::find($id);
    }
    public function post(){
        //TODO EXEI Security issue -> mporei o opoiosdipote na valei katigoria
        $category = new category();
        $category->title = Input::get('title');
        $category->save();
        return $category;
    }
    public function update(){
        $category = category::find(Input::get('id'));
        $category->title = Input::get('title');
        $category->save();
        return $category;
    }
    public function remove($id){
        //$category = new category();
        $category = category::find($id);
        //return  $category;
        $category->delete();
    }

}
