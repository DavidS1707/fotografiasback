<link rel="stylesheet" href="{{ asset('assets/estilos.css') }}">

<body>
    <section>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <h1>Iniciar Sesión</h1>
            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" name="email" id="email" required>
                <label for="">Correo</label>
            </div>
            <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" name="password" id="password" required>
                <label for="">Contraseña</label>
            </div>
            <button class="btn btn-outline-light btn-lg px-5" type="submit">Ingresar</button>
            <div class="register">
                <p>No tienes una cuenta? <a href="{{ route('register') }}" class="text-white-50 fw-bold">Registrate!</a>
                </p>
            </div>
        </form>
    </section>
</body>
