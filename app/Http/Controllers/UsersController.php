<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\FotosUsuarios;

class UsersController extends Controller
{
    public function abrir_miusuario()
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();
            $fotosusuarios= FotosUsuarios::where('usuario_id',$userId)->select('*')->get();
            //dd($datos , $fotosusuarios);



        return view('usuario.miusuario')->with('datos', $datos)->with('fotosusuarios', $fotosusuarios);
    }

    public function registrar_3imagenes(Request $request)
    {
        $request->validate([
            'photo_1' => 'required|mimes:jpeg,png,jpg',
            'photo_2' => 'required|mimes:jpeg,png,jpg',
            'photo_3' => 'required|mimes:jpeg,png,jpg',
        ]);

        $user_id = auth()->user()->id;

        //dd($request->file('photo_1'),$request->file('photo_2'),$request->file('photo_3'));


        $user = auth()->user();
        $photo1 = $request->file('photo_1')->storeAs('public/UsuariosFotos/'.$user_id,  '1.' . $request->file('photo_1')->getClientOriginalExtension());


        // Para la foto 2
        $photo2 = $request->file('photo_2')->storeAs('public/UsuariosFotos/'.$user_id, '2.' . $request->file('photo_2')->getClientOriginalExtension());

        // Para la foto 3
        $photo3 = $request->file('photo_3')->storeAs('public/UsuariosFotos/'.$user_id, '3.' . $request->file('photo_3')->getClientOriginalExtension());

        // Guardar los nombres de las imágenes en la base de datos
        $ruta1='UsuariosFotos/'.$user_id.'/'. '1.'.$request->file('photo_1')->getClientOriginalExtension();
        $foto1 = new FotosUsuarios();
        $foto1->ruta_imagen = 'storage/' . $ruta1;
        $foto1->usuario_id = $user_id;
        $foto1->save();

        $ruta2='UsuariosFotos/'.$user_id.'/'. '2.'.$request->file('photo_2')->getClientOriginalExtension();
        $foto2 = new FotosUsuarios();
        $foto2->ruta_imagen = 'storage/' . $ruta2;
        $foto2->usuario_id = $user_id;
        $foto2->save();

        $ruta3='UsuariosFotos/'.$user_id.'/'.'3.'.$request->file('photo_3')->getClientOriginalExtension();
        $foto3 = new FotosUsuarios();
        $foto3->ruta_imagen = 'storage/' . $ruta3;
        $foto3->usuario_id = $user_id;
        $foto3->save();

        return redirect()->back()->with('success', 'Imágenes registradas correctamente.');
    }


    public function update_perfil(Request $request)
    {



        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|filled',

        ], [
            'email.required' => 'El correo es requerido.',
            'email.email' => 'El correo debe ser una dirección de correo válida.',
            'name.required' => 'El nombre es requerido.',


        ]);

        $user = Auth::user();

        if ($user->email !== $request->email) {
            $this->validate($request, [

                'email' => 'unique:users',
            ], [
                'email.unique' => 'El correo ya está en uso.',
            ]);

            User::where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return redirect()->route('abrir_miusuario');
        }


        User::where('id', $user->id)->update([
            'name' => $request->name . ' ' . $request->lastname,
        ]);

        return redirect()->route('abrir_miusuario');
    }
    public function cambiar_contraseña(Request $request)
    {
        $this->validate($request, [
            'antigua_contraseña' => 'required|filled',
            'nueva_contraseña' => 'required|filled', // La nueva contraseña debe tener al menos 8 caracteres
        ], [
            'antigua_contraseña.required' => 'Escriba su anterior contraseña requerido.',
            'nueva_contraseña.required' => 'Escriba su nueva contraseña.',
        ]);

        $user = Auth::user(); // Obtiene al usuario autenticado

        // Verifica si la contraseña antigua proporcionada coincide con la contraseña actual del usuario
        if (Hash::check($request->antigua_contraseña, $user->password)) {
            // La contraseña antigua coincide, puedes proceder a actualizarla

            User::where('id', $user->id)->update(['password' => Hash::make($request->nueva_contraseña)]);


            return response()->json(['mensaje' => 'Contraseña actualizada correctamente.']);
        } else {
            return response()->json(['error' => 'La contraseña antigua no es correcta.'], 422);
        }
    }
}
