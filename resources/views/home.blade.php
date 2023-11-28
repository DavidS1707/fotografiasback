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

        <div>
            <p>Bienvenido, {{ Auth::user()->name }}</p>
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
