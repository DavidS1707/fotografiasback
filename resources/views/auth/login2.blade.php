<link rel="stylesheet" href="{{ asset('assets/estilos.css') }}">

<body>
    <section>
        <form>
            <h1>Login</h1>
            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" required>
                <label for="">Email</label>
            </div>
            <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" required>
                <label for="">Password</label>
            </div>
            <button>Log in</button>
            <div class="register">
                <p>Don't have a account <a href="#">Register</a></p>
            </div>
        </form>
    </section>
</body>
