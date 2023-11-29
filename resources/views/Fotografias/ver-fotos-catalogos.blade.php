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

        <div class="taskboardapp-detail-wrap">
            <header class="taskboard-header">
                <ul class="nav nav-justified nav-light nav-tabs nav-segmented-tabs active-theme mx-auto w-350p">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_boards">
                            <span class="nav-link-text">{{ $catalogo['title_catalogo'] }}</span>
                        </a>
                    </li>

                </ul>
                <div class="hk-sidebar-togglable"></div>
            </header>
            <div class="taskboard-body">
                <div data-simplebar class="nicescroll-bar">
                    <div class="container-fluid">
                        <div class="row justify-content-center board-team-wrap">
                            <div class="col-md-8 col-sm-12">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab_boards">
                                        <div class="row">
                                            @foreach ($fotoscatalogo as $foto)
                                                <div class="col-lg-6">
                                                    <div class="card board-card card-border">
                                                        <div class="card-body">
                                                            <div class="media align-items-center">
                                                                <div class="media-head">
                                                                    <div class="">

                                                                        <img src="{{ asset('storage/' . $foto->ruta_foto) }}"
                                                                            style="height: 200px;" alt="foto"
                                                                            class="avatar-img">
                                                                    </div>
                                                                </div>
                                                                <div class="media-body">
                                                                    <!-- Puedes mostrar más información de la foto si lo deseas -->
                                                                    <span>{{ $foto->title_evento }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-muted justify-content-between">

                                                            <div class="d-flex align-items-center">
                                                                <!-- Puedes mostrar más información o acciones aquí -->
                                                                <p class="p-xs me-2">{{ $foto->title_catalogo }}</p>
                                                                <p class="p-xs me-2">{{ $foto->precio_foto }} Bs.</p>
                                                                <div class="flex-shrink-0">
                                                                    <a class="btn btn-xs btn-icon btn-flush-primary btn-rounded flush-soft-hover"
                                                                        href="#" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title=""
                                                                        data-bs-original-title="Público">
                                                                        <span class="icon"><span
                                                                                class="feather-icon"><i
                                                                                    data-feather="globe"></i></span></span>
                                                                    </a>

                                                                    <a class="btn btn-xs btn-icon btn-flush-primary btn-rounded flush-soft-hover"
                                                                        href="#" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title=""
                                                                        data-bs-original-title="Comprar">
                                                                        <span class="icon"><span
                                                                                class="feather-icon"><i
                                                                                    class="bi bi-cart4"></i></span></span>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
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
