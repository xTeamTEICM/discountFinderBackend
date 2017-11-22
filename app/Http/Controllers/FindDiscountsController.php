<?php

namespace App\Http\Controllers;

use App\Discounts;
use Illuminate\Http\Request;

class findDiscountsController extends Controller
{
    public function listOfDiscounts(Request $request)
    {
        $this->validate($request,[

            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'

        ]);

        return Discounts::all();
    }



    public function  sortShops(){




    }

}
