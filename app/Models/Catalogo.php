<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;
    protected $table = 'catalogos';
    protected $fillable = ['title_catalogo', 'evento_id','fotografo_id','precio_catalogo'];
}
