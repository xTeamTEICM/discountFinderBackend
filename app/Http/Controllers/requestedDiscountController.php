<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\requestedDiscount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Mockery\Exception;


class requestedDiscountController extends Controller
{
    public function list()
    {
        $userId = Auth::user()->id;
        return requestedDiscount::query()->where('userId', '=', $userId)->get();
    }

    public function get($id)
    {
        $request = new Request();
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        $userId = Auth::user()->id;
        return requestedDiscount::query()->where('userId', '=', $userId)->where('id', '=', $data['id'])->first();
    }

    public function post(Request $request)
    {

        $data = $this->validate($request, [
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'tags' => 'required|string'
        ]);

        $userId = Auth::user()->id;

        $requestedDiscount = new requestedDiscount();
        $requestedDiscount->userId = $userId;
        $requestedDiscount->category = $data['category'];
        $requestedDiscount->price = $data['price'];
        $requestedDiscount->tags = $data['tags'];


        $requestedDiscount->save();
        $requestedDiscount->push();
        return $requestedDiscount;
    }

    public function put($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'tags' => 'required|string'
        ]);

        $userId = Auth::user()->id;

        $requestedDiscount = requestedDiscount::query()->where('userId', '=', $userId)->where('id', '=', $data['id'])->first();
        if ($requestedDiscount != null) {
            $requestedDiscount->category = $data['category'];
            $requestedDiscount->price = $data['price'];
            $requestedDiscount->tags = $data['tags'];


            $requestedDiscount->save();
            $requestedDiscount->push();
            return $requestedDiscount;
        } else {
            return "";
        }
    }

    public function delete($id)
    {
        $request = new Request();
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $userId = Auth::user()->id;

        $requestedDiscount = requestedDiscount::query()->where('userId', '=', $userId)->find($data['id']);
        if ($requestedDiscount != null) {
            $requestedDiscount->delete();
        }
    }
}
