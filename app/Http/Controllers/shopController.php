<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;


class shopController extends Controller
{
    public function list()
    {
        return Shop::all();
    }

    public function myList()
    {
        $user = auth('api')->user();
        return Shop::query()->where("ownerId", "=", $user->id)->get();
    }

    public function get($id)
    {
        return Shop::find($id);
    }

    public function myGet($id)
    {
        $user = auth('api')->user();
        return Shop::query()->where("ownerId", "=", $user->id)->find($id);
    }

    public function post(Request $request)
    {

        $user = auth('api')->user();

        $data = $this->validate($request, [
            'brandName' => 'required|string|unique:shops',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $shop = new Shop();

        $shop->ownerId = $user->id;
        $shop->brandName = $data['brandName'];
        $shop->logPos = $data['logPos'];
        $shop->latPos = $data['latPos'];

        $shop->save();
        $shop->push();

        return $shop;

    }

    public function update(Request $request)
    {

        $user = auth('api')->user();

        $data = $this->validate($request, [
            'id' => 'required|integer',
            'brandName' => 'required|string',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $shop = Shop::query()->where("ownerId", "=", $user->id)->find($data['id']);

        if($shop) {
            $shop->brandName =$data['brandName'];
            $shop->logPos = $data['logPos'];
            $shop->latPos = $data['latPos'];

            $shop->save();
            $shop->push();

            return $shop;
        }
    }

    public function delete($id)
    {
        $user = auth('api')->user();

        $shop = Shop::query()->where("ownerId", "=", $user->id)->find($id);
        if ($shop) {
            $shop->delete();
        }
    }
}
