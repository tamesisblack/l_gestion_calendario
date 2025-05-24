@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Asignar Coordinador</h2>

    <form action="{{ route('cordinadores.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Seleccionar Usuario --</option>
                @foreach($usuarios as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->nombres }} {{ $user->apellidos }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="area_id" class="form-label">Área</label>
            <select name="area_id" class="form-select" required>
                <option value="">-- Seleccionar Área --</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                        {{ $area->nombre_area }}
                    </option>
                @endforeach
            </select>
            @error('area_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" class="form-select" required>
                <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <a href="{{ route('cordinadores.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
