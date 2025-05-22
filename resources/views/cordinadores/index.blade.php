@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Asignaciones de Coordinadores</h2>
    <a href="{{ route('cordinadores.create') }}" class="btn btn-primary mb-3">Asignar Coordinador</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Área</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cordinadores as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->nombre_completo }}</td>
                    <td>{{ $item->area->nombre_area }}</td>
                    <td>
                        @if($item->estado)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cordinadores.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('cordinadores.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar esta asignación?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
