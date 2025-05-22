@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Área</h2>

    <form action="{{ route('areas.update', $area->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_area" class="form-label">Nombre del Área</label>
            <input type="text" name="nombre_area" class="form-control" value="{{ old('nombre_area', $area->nombre_area) }}" required>
            @error('nombre_area')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">Volver</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
