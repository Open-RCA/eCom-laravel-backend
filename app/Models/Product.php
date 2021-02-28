<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_sub_category_id',
        'unit_price',
        'quantity'
    ];

    public $timestamps = true;

//    public function productImages() {
//        return $this->hasMany();
//    }


}
