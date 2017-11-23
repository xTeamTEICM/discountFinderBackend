<?php

namespace App\Http\Controllers;

use App\Discounts;
use Illuminate\Http\Request;
use App\Http\Resources\DiscountsCollection ;

class findDiscountsController extends Controller
{
    public function listOfDiscounts(Request $request)
    {
        $this->validate($request,[

            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'

        ]);

        $discounts=Discounts::all();
        return new DiscountsCollection($discounts);

    }



    public function  sortShops(){




    }

}
