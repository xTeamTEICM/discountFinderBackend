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
    public function list()
    {
        return Discount::all();
    }


    public function get($id)
    {
        $request = new Request();
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        return Discount::query()->where('shopId', '=', $data['id'])->first();
    }

    public function post(Request $request)
    {
        $data = $this->validate($request, [
            'shopId' => 'required|numeric',
            'category' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'currentPrice' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|string'
        ]);

        $discount = new Discount();
        $discount->shopId = $data['shopId'];
        $discount->category = $data['category'];
        $discount->originalPrice = $data['originalPrice'];
        $discount->currentPrice = $data['currentPrice'];
        $discount->description = $data['description'];
        $discount->image = $data['image'];

        $discount->save();
        $discount->push();

        $fcm = new FCMController();
        $fcm->sentToMultiple(
            User::pluck('deviceToken')->toArray(),
            'Υπάρχουν νέες προσφορές',
            'Δείτε τώρα τις νέες προσφορές',
            [],//data
            'postedNewDiscount'
        );

        return $discount;
    }


    public function put($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'shopId' => 'required|numeric',
            'id' => 'required|numeric',
            'category' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'currentPrice' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|string'
        ]);

        $discount = Discount::query()->where('shopId', '=', $data['shopId'])
            ->where('id', '=', $data['id'])->first();

        if ($discount != null) {
            $discount->category = $data['category'];
            $discount->originalPrice = $data['originalPrice'];
            $discount->currentPrice = $data['currentPrice'];
            $discount->description = $data['description'];
            $discount->image = $data['image'];

            $discount->save();
            $discount->push();
            return $discount;
        } else {
            return "";
        }
    }


    public function delete($id, Request $request)
    {
        $request['id'] = $id;
        $data = $this->validate($request, [
            'shopId' => 'required|numeric',
            'id' => 'required|numeric'
        ]);

        $discount = Discount::query()->where('shopId', '=', $data['shopId']) ->find($data['id']);

        if ($discount != null) {
            $discount->delete();
        }
    }


}
