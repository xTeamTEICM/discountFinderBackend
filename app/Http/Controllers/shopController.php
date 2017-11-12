<?php

namespace App\Http\Controllers;

use App\shop;
use Illuminate\Http\Request;


class shopController extends Controller
{
    public function list()
    {
        return shop::all();
    }

    public function get($id)
    {
        return shop::find($id);
    }

    public function post(Request $request)
    {

        $data = $this->validate($request, [
            'ownerId' => 'required|integer',
            'brandName' => 'required|string|unique:shops',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $shop = new shop();

        $shop->ownerId = $data['ownerId'];
        $shop->brandName = $data['brandName'];
        $shop->logPos = $data['logPos'];
        $shop->latPos = $data['latPos'];

        $shop->save();
        $shop->push();

        return $shop;

    }

    public function update(Request $request)
    {

        $data = $this->validate($request, [
            'id' => 'required|integer',
            'brandName' => 'required|string|unique:shops',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $shop = shop::find($data['id']);

        if($shop) {
            $shop->brandName = $data['brandName'];
            $shop->logPos = $data['logPos'];
            $shop->latPos = $data['latPos'];

            $shop->save();
            $shop->push();

            return $shop;
        }
    }

    public function delete($id)
    {
        $shop = shop::find($id);
        if ($shop) {
            $shop->delete();
        }
    }
}
