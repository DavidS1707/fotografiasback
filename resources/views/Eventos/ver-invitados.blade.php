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
                <span style="font-size:30px;cursor:pointer; color: white;" class="nav">☰ Lista de invitados</span>
                <span style="font-size:30px;cursor:pointer; color: white;" class="nav2">☰ Lista de invitados</span>
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

        <div class="contactapp-wrap">
            <div class="contactapp-content">
                <div class="contactapp-detail-wrap">
                    <header class="contact-header">
                        <div class="d-flex align-items-center">
                            <div class="dropdown ms-3">
                                <a href="{{ route('abrir_registrarinvitado', ['id_evento' => $evento->id]) }}"
                                    class="btn btn-primary">Registrar invitado</a>
                                <a href="{{ route('abrir_alleventos') }}"
                                    class="btn btn-cancel btn-rounded btn-uppercase btn-block">Volver</a>
                            </div>
                            <div class="dropdown ms-3">
                                {{-- <a href="{{ route('abrir_escaner_qr') }}"
                                    class="btn btn-sm btn-outline-secondary flex-shrink-0 ">Escanear QR</a> --}}
                            </div>
                        </div>
                        <br />
                    </header>
                    <div class="contact-body">
                        <div data-simplebar class="nicescroll-bar">

                            @if (isset($mensaje))
                                <div class="alert alert-success">
                                    {{ $mensaje }}
                                </div>
                            @endif

                            <div class="contact-list-view">
                                @if (count($invitados) > 0)
                                    <table id="datable_1" class="table nowrap w-100 mb-5">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Correo</th>
                                                <th>Asistencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invitados as $invitado)
                                                <tr>
                                                    <td>
                                                        <div class="media align-items-center">
                                                            <div class="media-body">
                                                                <span
                                                                    class="d-block text-high-em">{{ $invitado['nombre_invitado'] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-truncate">{{ $invitado['email'] }}</td>
                                                    <td>{{ $invitado['asistencia_evento'] === 1 ? 'Asistió' : 'Invitado' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No tienes ningún invitado.</p>
                                @endif
                            </div>
                        </div>
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
