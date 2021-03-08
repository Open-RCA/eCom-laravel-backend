<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_sub_category_id',
        'unit_price',
        'quantity',
        'images',
        'status'
    ];


    public $timestamps = true;

//    public function productImages() {
//        return $this->hasMany();
//    }

    public function productSubCategory() {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productImages() {
        return $this->hasMany(File::class);
    }


}
