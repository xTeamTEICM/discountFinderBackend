<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;


class discountController extends Controller
{
    public function list(){

        return Discount::all();

    }


   

}
