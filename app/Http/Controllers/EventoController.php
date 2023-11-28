<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Eventos;
use App\Models\Invitaciones;
use Illuminate\Http\Request;
use App\Models\Fotografo_Evento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventoController extends Controller
{
    public function abrir_alleventos()
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

        $eventos = Eventos::where('eventos.organizador_id', $userId)->select('*')->get();
        //dd($eventos);
        return view('eventos.eventos')->with('datos', $datos)->with('eventos', $eventos);
    }

    public function abrir_creareventos()
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

        $fotografos = User::where('users.rol_id', 2)
            ->select('*')->get();

        return view('eventos.create_eventos')->with('datos', $datos)->with('fotografos', $fotografos);
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

        // Obtener información del evento
        $informacionEvento = "Título: {$evento->title_evento}, Descripción: {$evento->descripcion_evento}, Fecha: {$evento->fecha_evento}, Hora: {$evento->hora_evento}, Ubicación: {$evento->ubicacion}";

        // Generar el PDF y el código QR para el evento recién creado
        $qrCodePath = $this->generarPdfYQrEvento($evento->id);

        // Devolver la ruta del código QR
        return redirect()->route('abrir_alleventos');
    }

    public function generarPdfYQrEvento($eventoId)
    {
        // Obtener información del evento
        $evento = Eventos::find($eventoId);

        // Validar si el evento existe
        if (!$evento) {
            abort(404, 'El evento no existe.');
        }

        // Generar el HTML del evento utilizando una vista
        $html = view('eventos.invitacion', compact('evento'))->render();

        // Crear una instancia de Dompdf
        $options = new Options();
        $options->set('chroot', realpath(''));
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');

        // Cargar el HTML del evento
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->render();

        // Generar el nombre del archivo PDF
        $nombreArchivo = "evento_$eventoId.pdf";

        // Guardar el archivo PDF en el almacenamiento (storage)

        Storage::put("public/pdf/$nombreArchivo", $dompdf->output());

        // Generar y devolver la ruta del código QR basado en el PDF
        $rutaQrCode = $this->generateQrCode($nombreArchivo, "qrcodes/qrcode_evento_$eventoId.svg");

        return response()->json(['pdfPath' => "pdf/$nombreArchivo", 'qrCodePath' => $rutaQrCode]);
    }

    public function generateQrCode($nombreArchivo, $rutaQrCode)
    {


        $pdfPath = "storage/pdf/$nombreArchivo";

        // Obtener la URL completa del PDF (incluyendo el "public path")
        $pdfUrl = url($pdfPath);

        // Generar el código QR con la URL del PDF

        QrCode::format('svg')->size(300)->generate($pdfUrl, storage_path("app/public/$rutaQrCode"));


        // Devolver la ruta del código QR guardado
        return "public/$rutaQrCode";
    }

    public function generateAndSaveQrCode($data, $evento)
    {
        // Genera el código QR con la información proporcionada
        $qrCode = QrCode::size(300)->generate($data);

        // Ruta dentro del directorio "storage"
        $qrCodePath = 'qrcodes/qrcode.svg';

        // Guarda el código QR en el almacenamiento
        Storage::put($qrCodePath, $qrCode);

        // Devuelve la ruta del código QR guardado
        return $qrCodePath;
    }

    public function  getevento($id)
    {
        $userId = Auth::id();
        $datos = User::where('users.id', $userId)
            ->select('*')->first();

        $evento = Eventos::where('eventos.id', $id)->select('*')->first();
        $invitados = Invitaciones::where('invitaciones.evento_id', $id)->select('*')->get();
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
}
