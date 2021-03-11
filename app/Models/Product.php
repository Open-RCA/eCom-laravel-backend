<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'product_sub_category_id',
        'unit_price',
        'quantity',
        'images',
        'status'
    ];

    protected $hidden = ['product_sub_category_id'];

    public $timestamps = true;

//    public function productImages() {
//        return $this->hasMany();
//    }

    public function productSubCategory() {
        return $this->belongsTo(ProductCategory::class);
    }



}
