<link rel="stylesheet" href="{{ asset('assets/estilos.css') }}">

<body>
    <section>
        <form action="{{ route('register') }}" method="post">
            @csrf
            <h1>Registro</h1>
            <div class="inputbox">
                <ion-icon name="name"></ion-icon>
                <input type="text" name="name" id="name" required>
                <label for="">Nombre</label>
            </div>
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
            <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" name="password_confirmation" id="password-confirm" required>
                <label for="">Confirmar contraseña</label>
            </div>
            <button class="btn btn-outline-light btn-lg px-5" type="submit">Registrarse</button>
            <div class="register">
                <p>Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-white-50 fw-bold">Ingresa!</a></p>
            </div>
        </form>
    </section>
</body>
