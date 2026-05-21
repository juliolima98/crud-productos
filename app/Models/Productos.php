<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'is_active',
    ];
}
