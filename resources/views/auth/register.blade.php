@extends('layouts.guest')

@section('content')

<div class="auth-page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-sm-1 mb-4 text-white-50">
                    <div>
                        <a href="index.html" class="d-inline-block auth-logo">
                            <img src="{{ asset('assets/images/Logo_blanco-1200px.png') }}" alt="" height="150">
                        </a>
                    </div>
                    <p class="mt-3 fs-15 fw-medium">Sistema de Gestión de Calendario</p>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Crear Nueva Cuenta !</h5>
                            <p class="text-muted">Registrese para continuar con la Reserva.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form class="needs-validation" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="nombres" class="form-label">{{ __('Nombres') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="nombres" name="nombres" placeholder="Ingrese Nombres" value="{{ old('nombres') }}" class="form-control pe-5 @error('nombres') is-invalid @enderror" required autofocus>
                                    @error('nombres')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="apellidos" class="form-label">{{ __('Apellidos') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="apellidos" name="apellidos" placeholder="Ingrese Apellidos" value="{{ old('apellidos') }}" class="form-control pe-5 @error('apellidos') is-invalid @enderror" required>
                                    @error('apellidos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="teléfono" class="form-label">{{ __('Teléfono') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="teléfono" name="teléfono" placeholder="Ingrese Teléfono" value="{{ old('teléfono') }}" class="form-control pe-5 @error('teléfono') is-invalid @enderror" required>
                                    @error('teléfono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Correo Electrónico') }} <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" placeholder="Ingrese Correo Electrónico" value="{{ old('email') }}" class="form-control pe-5 @error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">{{ __('Foto (Opcional)') }}</label>
                                    <input type="file" id="foto" name="foto" class="form-control pe-5 @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password">{{ __('Contraseña') }} <span class="text-danger">*</span></label>
                                    <input type="password" id="password" name="password" placeholder="Ingrese Contraseña" class="form-control pe-5 @error('email') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password-confirm">{{ __('Confirmar Contraseña') }} <span class="text-danger">*</span></label>
                                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="Confirmar Contraseña" class="form-control" required>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success w-100" type="submit">{{ __('Registrate') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="mb-0">Ya tienes una cuenta? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Iniciar Sesion </a> </p>
                </div>

            </div>
        </div>
        <!-- end row -->
    </div>
</div>
@endsection
