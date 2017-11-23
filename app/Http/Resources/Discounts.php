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
    protected static $i;


    public function toArray($request)
    {

     //here we add the jsonForm as we wish for a single discount
        return [
            'shopName'=>  DB::table('shops')->where('id',$this->shopId)->pluck('brandName')->first(),
            'category'=> DB::table('category')->where('id',$this->category)->pluck('title')->first(),
            'shortDescription'=>$this->description,
            'finalPrice'=>$this->currentPrice,
            'productImageURL'=>$this->image,
            'discountId' =>$this->id,


        ];

    }

}
