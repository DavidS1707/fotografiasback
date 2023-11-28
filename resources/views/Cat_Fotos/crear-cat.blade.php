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

        <form class="w-100" method="POST" action="{{ route('registrar_evento') }}">
            @csrf
            <div class="card card-border">
                <div class="card-body">
                    <div class="row gx-3">
                        <div class="form-group col-lg-12">
                            <label class="form-label">Nombre del evento</label>
                            <input class="form-control  @error('titulo_evento') is-invalid @enderror" id="titulo_evento"
                                name="titulo_evento" name="titulo_evento" type="text"
                                value="{{ old('titulo_evento') }}">
                            @error('titulo_evento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Fecha</label>
                                <input class="form-control cal-event-date-start" id="fecha" name="single-date-pick"
                                    type="text" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Hora</label>
                                <input class="form-control input-single-timepicker" id="evento"
                                    name="input-timepicker" type="text" />
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="form-label">Ubicacion</label>
                            <input class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion"
                                name="ubicacion" type="text" value="{{ old('ubicacion') }}">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="form-label">Fotografo</label>
                            <select id="fotografos" name="fotografos[]"
                                class="form-select me-3 @error('fotografos') is-invalid @enderror" style="width: 100%;"
                                multiple>
                                @foreach ($fotografos as $fotografo)
                                    <option value="{{ $fotografo->id }}">{{ $fotografo->name }}</option>
                                    <!-- Reemplaza 'id' y 'name' con los nombres de los campos correspondientes en tu modelo User -->
                                @endforeach
                            </select>

                            @error('fotografo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">Descripcion</label>
                            <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                rows="3"></textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" id="id_organizador" name="id_organizador" value="{{ $datos->id }}">

                    <button type="submit" class="btn btn-primary btn-rounded btn-uppercase btn-block">Registrar
                        Evento</button>
                    <a href="{{ route('abrir_alleventos') }}"
                        class="btn btn-cancel btn-rounded btn-uppercase btn-block">Cancelar</a>

                </div>
            </div>
        </form>

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
