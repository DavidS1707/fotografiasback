<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotografo_Evento extends Model
{
    use HasFactory;
    protected $table = 'fotografos_evento';
    protected $fillable = ['evento_id', 'fotografo_id'];
}
