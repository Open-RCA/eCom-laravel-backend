<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ProductSubCategory extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'category',
        'description',
        'product_category_id'
    ];

    public $timestamps = true;

    public function productCategory() {
        return $this->belongsTo(ProductCategory::class);
    }
}
