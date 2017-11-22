<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    protected $table = "discounts";
    public $timestamps = false;


    protected $fillable = [
        'originalPrice','currentPrice','description', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'id', 'shopId','category',
    ];
}
