<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Shop;
use App\User;
use function GuzzleHttp\default_user_agent;
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

    public function post(Request $request){

        $data = $this->validate($request, [

            'category' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'currentPrice' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|string'
        ]);

        //trexei alla den ksero giati, einai arga kleinoun ta matia, i need coffeeeeeeeeeee

        $userId = Auth::user()->id;
        $shopId = Shop::query()->where('ownerId','=',$userId)->value('id');



        $discount = new Discount();
        $discount->shopId = $shopId;
        $discount->category = $data['category'];
        $discount->originalPrice = $data['originalPrice'];
        $discount->currentPrice = $data['currentPrice'];
        $discount->description = $data['description'];
        $discount->image = $data['image'];

        $discount->save();
        $discount->push();
        return $discount;


    }

}
