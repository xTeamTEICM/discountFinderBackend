<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\requestedDiscount;
use Illuminate\Support\Facades\Auth;


class requestedDiscountController extends Controller
{
    public function list() {
        $userId = Auth::user()->id;
        return requestedDiscount::all()->where('userId','=',$userId);
    }

    public function get($id) {
        // Check if id is numeric
        $userId = Auth::user()->id;
        return requestedDiscount::query()->where('userId','=',$userId)->where('id','=',$id)->firstOrFail();
    }

    public function post(Request $request) {

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

    public function put($id, Request $request) {
// Check if id is numeric
        $userId = Auth::user()->id;
        $requestedDiscount = requestedDiscount::query()->where('userId','=',$userId)->where('id','=',$id)->firstOrFail();

        $data = $this->validate($request, [
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'tags' => 'required|string'
        ]);


        $requestedDiscount->category = $data['category'];
        $requestedDiscount->price = $data['price'];
        $requestedDiscount->tags = $data['tags'];


        $requestedDiscount->save();
        $requestedDiscount->push();
        return $requestedDiscount;
    }

    public function delete($id) {
        // Check if id is numeric
        $userId = Auth::user()->id;
        $requestedDiscount = requestedDiscount::query()->where('userId','=',$userId)->findOrFail($id);
        $requestedDiscount->delete();
    }
}
