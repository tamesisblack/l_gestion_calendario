@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Nuevo de Usuarios</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Usuarios</a></li>
                    <li class="breadcrumb-item active">Nuevo Registro</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Nuevo Usuario</h4>
            </div>
            <div class="card-body">
                <form class="row gy-1" method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="nombres" class="form-label">{{ __('Nombres') }}</label>
                            <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" value="{{ old('nombres') }}" required autofocus>
                            @error('nombres')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="apellidos" class="form-label">{{ __('Apellidos') }}</label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required>
                            @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="telefono" class="form-label">{{ __('Teléfono') }}</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="teléfono" class="form-label">{{ __('Rol') }}</label>
                            <select class="form-select @error('rol_id') is-invalid @enderror" id="rol_id" name="rol_id" required>
                                @foreach ($roles as $rol )
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                            @error('rol_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input type="text" class="form-control" id="password" name="password" value="password" readonly>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="foto" class="form-label">{{ __('Foto (Opcional)') }}</label>
                            <input type="file" id="foto" name="foto" class="form-control pe-5 @error('foto') is-invalid @enderror">
                            @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-12 col-md-6">
                        <div>
                            <br>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-danger">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Guardar Registro') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
