<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class File extends Eloquent
{
    use HasFactory;
    protected $fillable = [
        'file_url',
        'file_name',
        'file_size',
        'file_size_type',
        'file_type',
        'status'
    ];

    public $timestamps = true;
}
