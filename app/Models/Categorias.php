<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorias extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    //Relacion uno a muchos (Una categoria tiene muchos productos)
    //Tabla hija
    public function productos()
    {
        return $this->hasMany(Productos::class);
    }
}
