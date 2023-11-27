<?php

namespace App\Http\Controllers\Eventos;

use App\Models\User;
use App\Models\Eventos;
use App\Models\Invitaciones;
use Illuminate\Http\Request;
use App\Models\Fotografo_Evento;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventoSocialesController extends Controller
{

    /**---------------------------------------------------------------------------------------------
     * ------------------------------------EVENTOS--------------------------------------------------
     * ---------------------------------------------------------------------------------------------
     */
    public function abrir_alleventos(){
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

            $eventos= Eventos::where('eventos.organizador_id',$userId)->select('*')->get();
            //dd($eventos);
            return view('eventos.eventos')->with('datos', $datos)->with('eventos', $eventos);
    }
    public function abrir_creareventos()
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

        $fotografos=User::where('users.rol_id', 2)
        ->select('*')->get();

        return view('eventos.create_eventos')->with('datos', $datos)->with('fotografos',$fotografos);
    }

    public function registrar_evento(Request $request)
    {
       
        $this->validate($request, [
            'titulo_evento' => 'required',
            'single-date-pick' => 'required',
            'input-timepicker' => 'required',
            'ubicacion' => 'required',
            
            'descripcion' => 'required',
            'fotografos' => 'required',
        ], [
            'titulo_evento.required' => 'El título del evento es requerido.',
            'single-date-pick.required' => 'La fecha del evento es requerida.',
            'input-timepicker.required' => 'La hora del evento es requerida.',
            'ubicacion.required' => 'La ubicación del evento es requerida.',
            
            'descripcion.required' => 'La descripción del evento es requerida.',
            'fotografos.required' => 'Es requerido elegir un fotografo .',
        ]);



        // Crear un nuevo evento
        $evento = new Eventos();
        $evento->title_evento = $request->input('titulo_evento');
        $evento->descripcion_evento = $request->input('descripcion');
        $evento->fecha_evento = $request->input('single-date-pick');
        $evento->hora_evento = $request->input('input-timepicker');
        $evento->ubicacion = $request->input('ubicacion');
        $evento->organizador_id = auth()->user()->id;

        $evento->save();
        $directorioEvento = "public/eventos/evento_{$evento->id}";
        Storage::makeDirectory($directorioEvento);

        if ($request->has('fotografos')) {
            foreach ($request->input('fotografos') as $fotografoId) {
                Fotografo_Evento::create([
                    'evento_id' => $evento->id,
                    'fotografo_id' => $fotografoId,
                ]);
            }
        }

        // Devolver la ruta del código QR
        return redirect()->route('abrir_alleventos');
    }





    public function  getevento($id){
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

            $evento= Eventos::where('eventos.id',$id)->select('*')->first();
            $invitados = Invitaciones::where('invitaciones.evento_id',$id)->select('*')->get();
            //dd($evento,$invitados);
            $mensaje = Session::get('mensaje');
            return view('eventos.adminevento')->with('datos', $datos)->with('evento', $evento)->with('invitados', $invitados)->with('mensaje', $mensaje);
    }
    // Método para eliminar un evento
    public function eliminarEvento($id)
    {
        // Encuentra el evento por su ID
        $evento = Eventos::find($id);

        // Verifica si el evento existe
        if (!$evento) {
            // Puedes manejar el caso donde el evento no existe (por ejemplo, redireccionar o mostrar un mensaje de error)
            return 'NO EXISTE ESTE EVENTO';
        }

        // Elimina el evento
        $evento->delete();

        // Puedes redireccionar a la lista de eventos u hacer cualquier otra acción después de eliminar el evento
        return redirect()->route('abrir_alleventos');
    }

        /**---------------------------------------------------------------------------------------------
     * ------------------------------------INVITACIONES-------------------------------------------------
     * ---------------------------------------------------------------------------------------------
     */
    public function abrir_registrarinvitado($id_evento)
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

        $evento = Eventos::where('eventos.id', $id_evento)->select('*')->first();


        return view('eventos.create_invitado')->with('datos', $datos)->with('evento', $evento);
    }

    public function registrar_invitacion(Request $request)
    {
       
        $this->validate($request, [
            'nombre' => 'required',
            'email' => 'required',
            'email' => 'email',

        ], [
            'nombre.required' => 'El nombre del invitado es requerido.',
            'email.required' => 'La correo del invitado es requerida.',
            'email.email' => 'El correo tiene que ser un email valido',

        ]);

        $invitacion = Invitaciones::create([
            'nombre_invitado' => $request->input('nombre'),
            'descripcion_invitacion' => 'Usted fue invitado',
            'evento_id' => $request->input('id_evento'),
            'email' => $request->input('email'),
        ]);

        //MODIFICAR TU RUTA
        $accionUrl = route('marcar_asistenciaqr', ['invitacionId' => $invitacion->id]);

        $directorio = "public/invitaciones/{$invitacion->evento_id}/";

        // Asegúrate de que el directorio exista
        if (!Storage::exists($directorio)) {
            Storage::makeDirectory($directorio);
        }
        // Generar el código QR
        QrCode::format('svg')->size(300)->generate($accionUrl, storage_path("app/{$directorio}{$invitacion->id}.svg"));

        

        return redirect()->route('getevento', ['id' => $invitacion->evento_id]);
    }
    public function marcar_asistenciaqr($invitacionId)
    {
        $userId = Auth::id();
        $user = User::where('users.id', $userId)
            ->select('*')->first();

        $invitacion = Invitaciones::find($invitacionId);
        $evento = Eventos::find($invitacion->evento_id);
        //dd($invitacion,$user,$evento);

        if ($invitacion && $user->id === $evento->organizador_id) {
            // Realiza la acción de marcar asistencia aquí, por ejemplo:
            $invitacion->update(['asistencia_evento' => 1]);
            Session::flash('mensaje', 'Asitio el invitado: ' . $invitacion->nombre_invitado . ' al evento');

            return redirect()->route('getevento', ['id' => $invitacion->evento_id]);
        } else {
            return redirect()->route('home');
        }
    }
}
