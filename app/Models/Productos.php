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
        'category_id',
    ];

    //Relacion muchos a uno (Muchos productos pertenecen a una categoria)
    //Tabla padre
    public function categorias()
    {
        return $this->belongsTo(Categorias::class, 'category_id');
    }
}
