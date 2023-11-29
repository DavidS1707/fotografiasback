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
        <a href="{{ route('abrir_miusuario') }}" class="icon-a"><i class="fa fa-user icons"></i> Cuenta</a>
        <a href="#" onclick="confirmLogout()">
            <i class="fa fa-sign-out icons"></i> Cerrar Sesión
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
                            <a data-bs-toggle="tab" href="#tab_block_1" class="nav-link active ">
                                <span class="nav-link-text">Catalogos del Evento</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="tab" href="#tab_block_5" class="nav-link  ">
                                <span class="nav-link-text">Crear Catalogo</span>
                            </a>
                        </li>




                    </ul>
                </div>
            </div>

            <div class="col-lg-10 col-sm-9 col-8">
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab_block_1">
                        <table id="datable_1" class="table nowrap w-100 mb-5">
                            <thead>
                                <tr>
                                    <th><span class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input check-select-all"
                                                id="customCheck1">
                                            <label class="form-check-label" for="customCheck1"></label>
                                        </span></th>
                                    <th>Nombre</th>
                                    <th>Precio</th>


                                    <th>Cantidad</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catalogos as $catalogo)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="contact-star marked"><span class="feather-icon"><i
                                                            data-feather="star"></i></span></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">

                                                <div class="media-body">
                                                    <span
                                                        class="d-block text-high-em">{{ $catalogo->title_catalogo }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-truncate">{{ $catalogo->precio_catalogo }} Bs.</td>


                                        <td>{{ $catalogo->cantidad_fotos }} Fotos</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex">



                                                </div>
                                                <div class="d-flex">

                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover add-button"
                                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                                        data-bs-original-title="Ver Fotos"
                                                        href="{{ route('abrir_fotos_catalogos', ['id_catalogo' => $catalogo->id]) }}"><span
                                                            class="icon"><span class="feather-icon"><i
                                                                    class="bi bi-images"></i></span></span></a>
                                                </div>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover dropdown-toggle no-caret"
                                                        aria-expanded="false" data-bs-toggle="dropdown"><span
                                                            class="icon"><span class="feather-icon"><i
                                                                    data-feather="more-vertical"></i></span></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <span class="d-block text-high-em">Cambiar Rol</span>
                                                        <a class="dropdown-item" href="#"><span
                                                                class="feather-icon dropdown-icon"><i
                                                                    data-feather="edit"></i></span><span>Master</span></a>
                                                        <a class="dropdown-item" href="#"><span
                                                                class="feather-icon dropdown-icon"><i
                                                                    data-feather="trash-2"></i></span><span>Administrador</span></a>
                                                        <a class="dropdown-item" href="#"><span
                                                                class="feather-icon dropdown-icon"><i
                                                                    data-feather="copy"></i></span><span>Empleado</span></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="tab-pane fade " id="tab_block_5">
                        <form action="{{ route('registrar_catalogo') }}" method="POST"
                            enctype="multipart/form-data" id="form-imagenes">
                            @csrf
                            <div class="d-flex align-items-center mb-3">
                                <div class="title-lg fs-4">
                                    <span>Subir Catalogo de Fotos</span>
                                </div>
                                <button type="submit" class="btn btn-primary ms-2">Publicar Catalogo</button>
                            </div>

                            <!-- Único Input para varias fotos -->
                            <div class="row gx-3">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">Titulo Catalogo</label>
                                    <input class="form-control  @error('titulo_catalogo') is-invalid @enderror"
                                        id="titulo_catalogo" name="titulo_catalogo" type="text"
                                        value="{{ old('titulo_catalogo') }}">
                                    @error('titulo_catalogo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="form-label">Precio Fotos</label>
                                    <input class="form-control  @error('precio') is-invalid @enderror" id="precio"
                                        name="precio" type="number" value="{{ old('precio') }}">
                                    @error('precio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <div class="btn btn-soft-primary btn-file mb-1">
                                                    Upload Photos
                                                    <input type="file" name="photos[]" class="upload"
                                                        id="photos" multiple>
                                                </div>
                                                <div class="form-text text-muted">
                                                    Estas imágenes son las Imagenes a subir
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="preview-container" style="display:none;">
                                        <!-- Las imágenes seleccionadas se mostrarán aquí -->
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" id="id_evento" name="id_evento" value="{{ $evento->id }}">
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function confirmLogout() {
                var confirmLogout = confirm("¿Estás seguro de que deseas cerrar sesión?");
                if (confirmLogout) {
                    document.getElementById('logout-form').submit();
                }
            }
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
