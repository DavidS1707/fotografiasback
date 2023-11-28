<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuscripcionController extends Controller
{
    public function abrir_suscripciones()
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();
        return view('suscripciones.suscripciones')->with('datos', $datos);
    }
}
