<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotosCatalogo extends Model
{
    use HasFactory;
    protected $table = 'fotos_catalogo';
    protected $fillable = ['ruta_foto','precio_foto', 'catalogo_id'];
}
