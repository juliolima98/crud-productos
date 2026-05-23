<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use HasFactory;

    /**
     * PROPIEDAD $fillable
     * Define qué columnas de la base de datos pueden ser llenadas de forma masiva (Mass Assignment).
     * Esto se usa por ejemplo cuando hacemos: Productos::create($request->all());
     * Es una medida de seguridad vital para evitar que modifiquen campos que no queremos (como IDs o roles).
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'is_active',
        'category_id',
    ];

    /**
     * RELACIONES DE ELOQUENT
     * Define la relación "Muchos a Uno" (Pertenece a).
     * Indica que muchos productos pueden pertenecer a una sola categoría.
     */
    public function categorias()
    {
        // belongsTo() significa "Pertenece a". 
        // El segundo parámetro ('category_id') es opcional si sigues la convención de nombres,
        // pero es buena práctica especificar cuál es la llave foránea en esta tabla.
        return $this->belongsTo(Categorias::class, 'category_id');
    }
}
