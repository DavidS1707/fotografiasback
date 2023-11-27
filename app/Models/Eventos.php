<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    use HasFactory;
    protected $table = 'eventos';
    protected $fillable = ['title_evento', 'descripcion_evento','fecha_evento','hora_evento','ubicacion','organizador_id'];
}
