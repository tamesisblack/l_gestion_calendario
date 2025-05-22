@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Crear Nueva Área</h2>

    <form action="{{ route('areas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_area" class="form-label">Nombre del Área</label>
            <input type="text" name="nombre_area" class="form-control" value="{{ old('nombre_area') }}" required>
            @error('nombre_area')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">Volver</a>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
