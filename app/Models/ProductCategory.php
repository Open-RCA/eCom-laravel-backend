<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ProductCategory extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'category',
        'description'
    ];

    public $timestamps = true;

}
