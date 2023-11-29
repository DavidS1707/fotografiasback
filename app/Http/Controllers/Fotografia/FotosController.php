<?php

namespace App\Http\Controllers\Fotografia;

use App\Models\User;
use App\Models\Eventos;
use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\FotosCatalogo;
use App\Models\IA_Usuarios_Foto;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FotosController extends Controller
{

    /* ----------------------------------------------------------------------------------------------------------
    ----------------------------------FOTOGRAFIAS-----------------------------------------------------------------
    -------------------------------------------------------------------------------------------------------------- */
    public function abrir_eventosfotografos()
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

        $eventos = Eventos::join('fotografos_evento', 'fotografos_evento.evento_id', '=', 'eventos.id')->where('fotografos_evento.fotografo_id', $userId)->select('*')->get();

        //dd($eventos);
        return view('eventos.eventosdelfotografo')->with('datos', $datos)->with('eventos', $eventos);
    }
    public function abrir_catalogo_evento($id_evento)
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

        //$catalogos = Catalogo::where('evento_id', $id_evento)->select('*')->get();
        $catalogos = DB::table('catalogos')
            ->select('catalogos.*', DB::raw('(SELECT COUNT(*) FROM fotos_catalogo WHERE catalogo_id = catalogos.id) as cantidad_fotos'))
            ->where('evento_id', 1)
            ->get();


        //dd($catalogos,$catalogosConFotos);

        $evento = Eventos::where('eventos.id', $id_evento)->select('*')->first();
        

        return view('Cat_Fotos.crear-cat')->with('datos', $datos)->with('evento', $evento)->with('catalogos', $catalogos);
    }
    public function abrir_fotos_catalogos($id_catalogo)
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();
        $catalogo = Catalogo::where('catalogos.id', $id_catalogo)->select('*')->first();
        $Fotoscatalogos = Catalogo::join('fotos_catalogo', 'fotos_catalogo.catalogo_id', '=', 'catalogos.id')->where('catalogos.id', $id_catalogo)->select('*')->get();
        //dd($Fotoscatalogos);
        return view('fotografias.fotos_catalogo')->with('fotoscatalogo', $Fotoscatalogos)->with('catalogo', $catalogo);
    }
    public function registrar_catalogo(Request $request)
    {

        $this->validate($request, [
            'titulo_catalogo' => 'required', // Agrega las reglas de validación según tus campos
            'precio' => 'required'
        ], [
            'titulo_catalogo.required' => 'Nombre del catalogo Requerido',
            'precio.required' => 'El precio del catalogo Requerido'
        ]);
        // Crear un nuevo catálogo
        //dd($request);

        $cantidadDeFotos = count($request->file('photos'));
        $precio_foto = $request->input('precio');
        $precio_catalogo =  $cantidadDeFotos * $precio_foto;
        $userId = Auth::id();
        $catalogo = new Catalogo();
        $catalogo->title_catalogo = $request->input('titulo_catalogo');
        $catalogo->evento_id = $request->input('id_evento');
        $catalogo->precio_catalogo = $precio_catalogo;
        $catalogo->fotografo_id = $userId;
        // Completa con los campos necesarios
        $catalogo->save();

        // Crear un directorio para el catálogo en el almacenamiento
        $directorioCatalogo = "public/eventos/evento_{$catalogo->evento_id}/catalogo_{$catalogo->id}";
        Storage::makeDirectory($directorioCatalogo);

        // Mover las imágenes al directorio del catálogo
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $directorioCatalogo = "public/eventos/evento_{$catalogo->evento_id}/catalogo_{$catalogo->id}";
                $nombreArchivo = $photo->getClientOriginalName();
                $photo->storeAs($directorioCatalogo, $nombreArchivo);
                $directorioCatalogo = "eventos/evento_{$catalogo->evento_id}/catalogo_{$catalogo->id}";
                $fotos_catalogo = new FotosCatalogo();
                $fotos_catalogo->ruta_foto = $directorioCatalogo . '/' . $nombreArchivo;
                $fotos_catalogo->precio_foto =  $precio_foto;
                $fotos_catalogo->catalogo_id = $catalogo->id;

                // Completa con los campos necesarios
                $fotos_catalogo->save();
            }
        }


        $usuarios = [];

        $directorios = Storage::Directories('public/UsuariosFotos');
        foreach ($directorios as $dir) {
            $carpeta = str_replace('public/UsuariosFotos/', '', $dir);
            array_push($usuarios, $carpeta);
        }

        // Envía una respuesta JSON con el mensaje, el catálogo y los usuarios
        return response()->json(['message' => 'Catalogo registrado con éxito', 'catalogo' => $catalogo, 'usuarios' => $usuarios, 'directorios' => $directorios]);
    }

    public function IA_DETECTION(Request $request)
    {
        $fotos = FotosCatalogo::where('fotos_catalogo.catalogo_id', $request->catalogo_id)->get();
        $contador = 1;
        foreach ($fotos as $foto) {
            // Accede a los atributos de cada foto
            $fotoIndex = $contador;

            foreach ($request->idusuarios as $usuarioInfo) {
                // Obtener el id del usuario y el índice de la foto
                $usuarioId = $usuarioInfo['id'];

                // Verifica si el usuarioInfo corresponde a la foto actual
                if ($usuarioInfo['fotoIndex'] == $fotoIndex && $usuarioId != 'unknown') {
                    // Crea el registro en la tabla IA_Usuarios_Foto
                    // Create a record in IA_Usuarios_Foto
                    IA_Usuarios_Foto::create([
                        'usuario_id' => $usuarioId,
                        'foto_id' => $foto->id,
                    ]);

                    // Retrieve the user associated with usuario_id
                    $user = User::find($usuarioId);

                    // Retrieve the details of the photo
                    $photo = FotosCatalogo::find($foto->id);




                    //AQUI ENVIA UNA NOTIFICACION DE TIPO PUSH 
                    $tokenEstatico = 'e9meGjRBTSWXMR55VNdlUH:APA91bF861BIxOA5AWwiXPI3u7yXeDHRzxOMAtRNLu49Cnb7r4L4UoPFPINzUNPciBgTj5pN9VqWH3Uei37VHOZoQvr6Ae2dzWXFr6sY0i_UR0fK351mrYZU75eDSgUycaN6O8JsINKq';

                    $message = [
                        'notification' => [
                            'title' => '¡Usted Aparece en una foto!',
                            'body' => 'SOFTWARE 1 MATERIA BASICA',
                        ],
                        'data' => [
                            'key' => 'value',
                        ],
                        'token' => $tokenEstatico, // Especifica el token directamente aquí
                    ];

                    Firebase::messaging()->send($message);
                }
            }
            $contador++;
        }



        return response()->json(['message' => 'Notificaciones enviadas correctamente', 'datos' => $fotos]);
    }
}
