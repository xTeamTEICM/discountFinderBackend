<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\DB;

class Discounts extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */


    public function toArray($request)
    {

     //here we add the jsonForm as we wish for a single discount
        return [
            'finalPrice'=>$this->currentPrice,
            'shortDescription'=>$this->description,
            'productImageURL'=>$this->image,
            'shopName'=>  DB::table('shops')->where('id',$this->shopId)->pluck('brandName')->first()



        ];
    }
}
