<div class="">
    <form wire:submit.prevent="guardar" enctype="multipart/form-data">
        @csrf
        <label class="form-label">Catalogo</label>
        <p>Valor de $evento: {{ $evento['id'] }}</p>
        <input class=" "
            id="titulo_catalogo" name="titulo_catalogo" wire:model="titulo_catalogo" type="text"
            value="{{ old('titulo_catalogo') }}">
            <input type="hidden" id="id_evento" name="id_evento" wire:model="id_evento" value="HOLAAA">

        <input type="file" name="imagen[]" id="imagen" wire:model="imagen" multiple>
        <button type="submit" class="px-2 py-1 bg-red-600" wire:click=''>Guardar</button>
    </form>

    <button hidden id="btnNotificaciones" class="">
        <i class="fa-solid fa-bell"></i> Notificar </button>
    <script src="{{ asset('js/face-api.min.js') }}" type="text/javascript"></script>
    <script>
        Livewire.on('face-api', (usuarios) => {

            console.log(usuarios);
            const imageUpload = document.getElementById('imagen')
            const btnNotificaciones = document.getElementById('btnNotificaciones')


            //cargo los modelos de FACEAPI cuanndo la funcion start comience
            Promise.all([
                faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
                faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
            ]).then(start)

            function loadLabeledImages() {
                //nombre de las carpetas(usuarios)
                
                const labels = usuarios.flat();
                return Promise.all(
                    labels.map(async label => {
                        const descriptions = [];
                        for (let i = 1; i <= 3; i++) {
                            //console.log(label)
                            const img = await faceapi.fetchImage(`/storage/UsuariosFotos/${label}/${i}.jpg`);
                            const detections = await faceapi.detectSingleFace(img).withFaceLandmarks()
                                .withFaceDescriptor();
                            descriptions.push(detections.descriptor);
                            //console.log(label, descriptions)
                        }

                        return new faceapi.LabeledFaceDescriptors(label, descriptions);
                    })
                )
            }



            async function start() {

                //obtengo los nombres de las caras de las imagenes del servidor
                const labeledFaceDescriptors = await loadLabeledImages();
                console.log(labeledFaceDescriptors);
                //console.log(labeledFaceDescriptors)

                //que tenga una presicion arriba de 60%
                const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6);
                console.log(faceMatcher);

                console.log('Listo');
                btnNotificaciones.addEventListener('click', async () => {

                    //obtengo la imagen subida en el input
                    resultados = [];
                    for (i = 0; i < imageUpload.files.length; i++) {
                        image = await faceapi.bufferToImage(imageUpload.files[i]);
                        const displaySize = {
                            width: image.width,
                            height: image.height
                        };
                        //detecta todas las caras de la imagagen del input
                        const detections = await faceapi.detectAllFaces(image).withFaceLandmarks()
                            .withFaceDescriptors();

                        const resizedDetections = faceapi.resizeResults(detections, displaySize);

                        //las coincidencias
                        const results = resizedDetections.map(d => faceMatcher.findBestMatch(d
                            .descriptor));

                        resultados.push(results);
                    }
                    console.log(resultados);
                    idusuarios = []
                    for (i = 0; i < resultados.length; i++) {
                        let result = resultados[i];
                        for (j = 0; j < result.length; j++) {
                            //console.log(result[j].label)
                            idusuarios.push(result[j].label);
                        };
                    }
                    console.log('estos son los usuarios en esa foto',idusuarios);
                    Livewire.dispatch('notiAparecesFoto', {idusuarios: idusuarios});
                })
                btnNotificaciones.click()


            }


        });
    </script>
</div>

