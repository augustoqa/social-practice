@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                @include('partials.validation-errors')
                <div class="card border-0 bg-light py-2 px-4">
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Username:</label>
                                <input type="text" name="name" class="form-control border-0" id="name" placeholder="Escribe tu nombre...">
                            </div>
                            <div class="form-group">
                                <label for="first_name">Nombre:</label>
                                <input type="text" name="first_name" class="form-control border-0" id="first_name" placeholder="Escribe tu primer nombre...">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Apellido:</label>
                                <input type="text" name="last_name" class="form-control border-0" id="last_name" placeholder="Escribe tu apellido...">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control border-0" id="email" placeholder="Tu email...">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" name="password" class="form-control border-0" id="password" placeholder="Tu Contraseña">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Repetir contraseña:</label>
                                <input type="password" name="password_confirmation" class="form-control border-0" id="password_confirmation" placeholder="Repite tu contraseña">
                            </div>
                            <button dusk="register-btn" class="btn btn-primary btn-block">Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
