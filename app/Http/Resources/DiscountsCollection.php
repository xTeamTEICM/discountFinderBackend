<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DiscountsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    //we need this class to send collection of data to user, Resources/Discounts  returns only a single object

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
