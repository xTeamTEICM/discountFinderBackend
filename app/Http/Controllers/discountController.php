<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class discountController extends Controller
{
    public function list(){

        return Discount::all();

    }


    public function get($id){

        $request = new Request();
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);


        return Discount::query()->where('shopId', '=', $data['id'])->first();




    }

}
