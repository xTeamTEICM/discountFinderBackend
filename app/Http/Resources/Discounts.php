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
    public static $distance=array();
    public static  $counter=0;

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
            'distance' =>Discounts::$distance[Discounts::$counter++],
            'shopLatPos' => DB::table('shops')->where('id',$this->shopId)->pluck('latPos')->first(),
            'shopLogPos' => DB::table('shops')->where('id',$this->shopId)->pluck('logPos')->first()

        ];


    }






}
