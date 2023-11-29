<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Catalogo;
use App\Models\FotosCatalogo;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class IaFotos extends Component
{
    use WithFileUploads;
    public $titulo_catalogo;
    public $id_evento;
    public $evento;
    public $imagen;
    protected $listeners = ["notiAparecesFoto"];
    public function guardar(){

        //dd($this->imagen, $this->titulo_catalogo,$this->evento->id);
        $userId = Auth::id();
        $catalogo = new Catalogo();
        $catalogo->title_catalogo = $this->titulo_catalogo;
        $catalogo->evento_id = $this->evento->id;
        $catalogo->precio_catalogo = null;
        $catalogo->fotografo_id = $userId;
        $catalogo->save();


        // Crear un directorio para el catálogo en el almacenamiento
        $directorioCatalogo = "public/eventos/evento_{$catalogo->evento_id}/catalogo_{$catalogo->id}";
        Storage::makeDirectory($directorioCatalogo);

        // Mover las imágenes al directorio del catálogo
        if ($this->imagen) {
            foreach ($this->imagen as $photo) {
                $directorioCatalogo = "public/eventos/evento_{$catalogo->evento_id}/catalogo_{$catalogo->id}";
                $nombreArchivo = $photo->getClientOriginalName();
                $photo->storeAs($directorioCatalogo, $nombreArchivo);
                $directorioCatalogo = "eventos/evento_{$catalogo->evento_id}/catalogo_{$catalogo->id}";
                $fotos_catalogo = new FotosCatalogo();
                $fotos_catalogo->ruta_foto = $directorioCatalogo . '/' . $nombreArchivo;
                $fotos_catalogo->precio_foto =  null;
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


        $this->dispatch('face-api', $usuarios);
    }

    public function notiAparecesFoto(array $idusuarios)
    {
          
        $tokenfmc='dYGJZAL9RiGS3HR6Jfpf3G:APA91bE3NDTvl6nX8I2uKMECYMNRHFJ-iiV3yFKD05syiMFCgWHrZ-jpp6vJN1YBfJ13DomTKvvhrg0YzYzBqAaz7wW1vrm8X6q_9ryZbulQkc0Ev3svvlBxIfwu9dlCWACEEkpPR-rE';
        foreach ($idusuarios as $idusuario) {
            if($idusuario != 'unknown'){
                $firebase = [
                    'notification' => [
                        'title' => '¡APARECISTE EN UNA FOTOGRAFIA !',
                        'body' => 'Gracias a la IA USTED FUE IDENTIFICADA EN UNA FOTOGRAFIA',
                    ],
                    'data' => [
                        'key' => 'value',
                    ],
                    'token' => $tokenfmc, // Especifica el token directamente aquí
                ];

                Firebase::messaging()->send($firebase);

            }
        }

    }
    public function mount($evento)
    {
        $this->evento = $evento;
    }
    public function render()
    {
        
        return view('livewire.ia-fotos');
    }
}
