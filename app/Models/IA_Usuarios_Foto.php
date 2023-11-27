<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IA_Usuarios_Foto extends Model
{
    use HasFactory;
    protected $table = 'ia_usuarios_foto';
    protected $fillable = ['foto_id', 'usuario_id'];
}
