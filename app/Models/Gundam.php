<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gundam extends Model
{
    protected $table = 'gundams';

    protected $fillable = ['nama', 'merk', 'ori', 'harga_retail'];

    protected $casts = [
        'ori' => 'boolean',
        'harga_retail' => 'integer',
    ];
}