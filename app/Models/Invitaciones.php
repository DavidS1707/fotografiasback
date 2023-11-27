<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitaciones extends Model
{
    use HasFactory;
    protected $table = 'invitaciones';
    protected $fillable = ['descripcion_invitacion', 'asistencia_evento','evento_id','email','nombre_invitado'];
}
