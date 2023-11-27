@extends('home')

@section('content_header')
    <h1>Editar Perfil</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Información del Perfil</h3>
                </div>
                <div class="box-body">
                    <!-- Formulario para editar la información del perfil -->
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $user->name }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $user->email }}">
                        </div>

                        <!-- Otros campos de perfil que desees -->

                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Subir Fotos</h3>
                </div>
                <div class="box-body">
                    <!-- Formulario para subir tres fotos -->
                    <form action="{{ route('upload.photos') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="photo1">Foto 1:</label>
                            <input type="file" name="photo1" id="photo1" class="form-control-file" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="photo2">Foto 2:</label>
                            <input type="file" name="photo2" id="photo2" class="form-control-file" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="photo3">Foto 3:</label>
                            <input type="file" name="photo3" id="photo3" class="form-control-file" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Subir Fotos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
