<!Doctype HTML>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body>

    <div id="mySidenav" class="sidenav">
        <p class="logo"><span>2do</span>Parcial</p>
        <a href="{{ route('home') }}" class="icon-a"><i class="fa fa-dashboard icons"></i> Dashboard</a>
        <a href="{{ route('abrir_alleventos') }}" class="icon-a"><i class="fa fa-calendar icons"></i> Eventos</a>
        <a href="#"class="icon-a"><i class="fa fa-list icons"></i> Catálogo de fotos</a>
        <a href="{{ route('abrir_suscripciones') }}"class="icon-a"><i class="fa fa-shopping-bag icons"></i>
            Suscripciones</a>
        <a href="#"class="icon-a"><i class="fa fa-user icons"></i> Cuenta</a>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" <i
            class="fa fa-sign-out icons"></i>
            {{ __('Cerrar Sesión') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>
    <div id="main">

        <div class="head">
            <div class="col-div-6">
                <span style="font-size:30px;cursor:pointer; color: white;" class="nav">☰ Dashboard</span>
                <span style="font-size:30px;cursor:pointer; color: white;" class="nav2">☰ Dashboard</span>
            </div>

            <div class="col-div-6">
                <div class="profile">
                    <img src="{{ asset('assets/images/user.png') }}" class="pro-img" />
                    <p>{{ Auth::user()->name }}</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
        <br />

        <div class="row edit-profile-wrap">
            <div class="col-lg-2 col-sm-3 col-4">
                <div class="nav-profile mt-4">
                    <div class="nav-header">
                        <span>Cuenta</span>
                    </div>
                    <ul class="nav nav-light nav-vertical nav-tabs">

                        <li class="nav-item">
                            <a data-bs-toggle="tab" href="#tab_block_1" class="nav-link active">
                                <span class="nav-link-text">Perfil Personal</span>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a data-bs-toggle="tab" href="#tab_block_4" class="nav-link">
                                <span class="nav-link-text">Cambiar Contraseña</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="tab" href="#tab_block_5" class="nav-link">
                                <span class="nav-link-text">3 Fotografias</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-lg-10 col-sm-9 col-8">
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab_block_1">
                        <form action="{{ route('update_perfil') }}" method="POST">
                            @csrf

                            <div class="row gx-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="media align-items-center">
                                            <div class="media-head me-5">
                                                <div class="avatar avatar-rounded avatar-xxl">

                                                    <img src="{{ asset('storage/' . Auth::user()->profile_image_path) }}"
                                                        class="avatar-img" alt="Tu Foto de Perfil">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="btn btn-soft-primary btn-file mb-1">
                                                    Upload Photo
                                                    <input type="file" class="upload">
                                                </div>
                                                <div class="form-text text-muted">
                                                    Para una mejor vista previa, el tamaño recomendado es 450 px x 450
                                                    px.
                                                    Tamaño máximo 2mb.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="title title-xs title-wth-divider text-primary text-uppercase my-4">
                                <span>Informacion Personal</span>
                            </div>
                            <div class="row gx-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Nombre Completo</label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                                            id="name" name="name" value="{{ $datos['name'] }}" />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Correo</label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            id="email" name="email" value="{{ $datos['email'] }}" />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" id="business_id" name="business_id"
                                value="{{ $datos->empresa_id }}">
                            <input type="hidden" id="rol_id" name="rol_id" value="{{ $datos->rol_id }}">
                            <button type="submit" class="btn btn-primary mt-5">Guardar Cambios</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="tab_block_4">
                        <div class="title-lg fs-4"><span>Cambiar Contraseña</span></div>

                        <form id="cambiarContraseñaForm">
                            @csrf
                            <div class="title title-xs title-wth-divider text-primary text-uppercase my-4">
                                <span>Actualizar Contraseña</span>
                            </div>
                            <div class="row gx-3">
                                <div id="mensaje"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Contraseña Antigua</label>
                                        <input class="form-control @error('antigua_contraseña') is-invalid @enderror"
                                            type="password" id="antigua_contraseña" name="antigua_contraseña"
                                            required />
                                        @error('antigua_contraseña')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label class="form-label">Contraseña Nueva</label>
                                        <input class="form-control @error('nueva_contraseña') is-invalid @enderror"
                                            type="password" id="nueva_contraseña" name="nueva_contraseña" required />
                                        @error('nueva_contraseña')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Cambiar Contraseña</button>
                            </div>


                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_block_5">
                        <form action="{{ route('registrar_3imagenes') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex align-items-center mb-3">
                                <div class="title-lg fs-4">
                                    <span>3 IMÁGENES TUYAS</span>
                                </div>
                                <button type="submit" class="btn btn-primary ms-2">Guardar Cambios</button>
                            </div>

                            <!-- Primer Input -->
                            <div class="row gx-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="media align-items-center">
                                            <div class="media-head me-5">
                                                @if ($fotosusuarios->isNotEmpty())
                                                    <div class="avatar avatar-rounded avatar-xxl">
                                                        @php
                                                            $firstFoto = $fotosusuarios->first();
                                                            $userImagePath = $firstFoto->ruta_imagen;
                                                            $userAvatarPath = public_path($userImagePath);
                                                        @endphp

                                                        @if (file_exists($userAvatarPath))
                                                            <img src="{{ asset($userImagePath) }}" alt="user"
                                                                class="avatar-img">
                                                        @else
                                                            <img src="{{ asset('assets/dist/img/avatar3.jpg') }}"
                                                                alt="user" class="avatar-img">
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="avatar avatar-rounded avatar-xxl">
                                                        <img src="{{ asset('assets/dist/img/avatar3.jpg') }}"
                                                            alt="user" class="avatar-img">
                                                    </div>
                                                @endif


                                            </div>
                                            <div class="media-body">
                                                <div class="btn btn-soft-primary btn-file mb-1">
                                                    Upload Photo
                                                    <input type="file" name="photo_1" class="upload"
                                                        id="photo_1">
                                                </div>
                                                <div class="form-text text-muted">
                                                    Esta imagen es la que usará la IA para detectarte
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="preview-container" style="display:none;">
                                        <img src="#" alt="Preview" class="preview-image"
                                            style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Segundo Input -->
                            <div class="row gx-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="media align-items-center">
                                            <div class="media-head me-5">
                                                @if ($fotosusuarios->isNotEmpty())
                                                    <div class="avatar avatar-rounded avatar-xxl">
                                                        @php
                                                            $secondFoto = $fotosusuarios->get(1); // Acceder al segundo elemento (índice 1)
                                                            $userImagePath = $secondFoto->ruta_imagen;
                                                            $userAvatarPath = public_path($userImagePath);
                                                        @endphp

                                                        @if (file_exists($userAvatarPath))
                                                            <img src="{{ asset($userImagePath) }}" alt="user"
                                                                class="avatar-img">
                                                        @else
                                                            <img src="{{ asset('assets/dist/img/avatar3.jpg') }}"
                                                                alt="user" class="avatar-img">
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="avatar avatar-rounded avatar-xxl">
                                                        <img src="{{ asset('assets/dist/img/avatar3.jpg') }}"
                                                            alt="user" class="avatar-img">
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="media-body">
                                                <div class="btn btn-soft-primary btn-file mb-1">
                                                    Upload Photo
                                                    <input type="file" name="photo_2" class="upload"
                                                        id="photo_2">
                                                </div>
                                                <div class="form-text text-muted">
                                                    Esta imagen es la que usará la IA para detectarte
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="preview-container" style="display:none;">
                                        <img src="#" alt="Preview" class="preview-image"
                                            style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Tercer Input -->
                            <div class="row gx-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="media align-items-center">
                                            <div class="media-head me-5">
                                                @if ($fotosusuarios->isNotEmpty())
                                                    <div class="avatar avatar-rounded avatar-xxl">
                                                        @php
                                                            $secondFoto = $fotosusuarios->get(2); // Acceder al segundo elemento (índice 1)
                                                            $userImagePath = $secondFoto->ruta_imagen;
                                                            $userAvatarPath = public_path($userImagePath);
                                                        @endphp

                                                        @if (file_exists($userAvatarPath))
                                                            <img src="{{ asset($userImagePath) }}" alt="user"
                                                                class="avatar-img">
                                                        @else
                                                            <img src="{{ asset('assets/dist/img/avatar3.jpg') }}"
                                                                alt="user" class="avatar-img">
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="avatar avatar-rounded avatar-xxl">
                                                        <img src="{{ asset('assets/dist/img/avatar3.jpg') }}"
                                                            alt="user" class="avatar-img">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <div class="btn btn-soft-primary btn-file mb-1">
                                                    Upload Photo
                                                    <input type="file" name="photo_3" class="upload"
                                                        id="photo_3">
                                                </div>
                                                <div class="form-text text-muted">
                                                    Esta imagen es la que usará la IA para detectarte
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="preview-container" style="display:none;">
                                        <img src="#" alt="Preview" class="preview-image"
                                            style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(".nav").click(function() {
                $("#mySidenav").css('width', '70px');
                $("#main").css('margin-left', '70px');
                $(".logo").css('visibility', 'hidden');
                $(".logo span").css('visibility', 'visible');
                $(".logo span").css('margin-left', '-10px');
                $(".icon-a").css('visibility', 'hidden');
                $(".icons").css('visibility', 'visible');
                $(".icons").css('margin-left', '-8px');
                $(".nav").css('display', 'none');
                $(".nav2").css('display', 'block');
            });

            $(".nav2").click(function() {
                $("#mySidenav").css('width', '300px');
                $("#main").css('margin-left', '300px');
                $(".logo").css('visibility', 'visible');
                $(".icon-a").css('visibility', 'visible');
                $(".icons").css('visibility', 'visible');
                $(".nav").css('display', 'block');
                $(".nav2").css('display', 'none');
            });
        </script>
    </div>
</body>


</html>