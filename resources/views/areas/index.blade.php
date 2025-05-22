@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Áreas</h2>
        <a href="{{ route('areas.create') }}" class="btn btn-primary">Crear Nueva Área</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre del Área</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
                <tr>
                    <td>{{ $area->id }}</td>
                    <td>{{ $area->nombre_area }}</td>
                    <td>
                        <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('areas.destroy', $area->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta área?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
