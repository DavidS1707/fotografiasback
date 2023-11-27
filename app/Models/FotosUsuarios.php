<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotosUsuarios extends Model
{
    use HasFactory;
    protected $table = 'fotos_usuarios';
    protected $fillable = ['ruta_imagen', 'usuario_id'];
}
