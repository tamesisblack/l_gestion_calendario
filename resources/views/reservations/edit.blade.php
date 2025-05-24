@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h4>Editar Reserva</h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('reservations.update', $reservation->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row gy-3">

                        {{-- Usuario --}}
                        <div class="col-md-4">
                            <label for="user_id" class="form-label">Usuario</label>
                            <select id="user_id" name="user_id" class="form-select" required>
                                <option value="">Seleccionar usuario</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $reservation->user_id ? 'selected' : '' }}>
                                        {{ $user->nombres }} {{ $user->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Área --}}
                        <div class="col-md-4">
                            <label for="area_id" class="form-label">Área</label>
                            <select id="area_id" name="area_id" class="form-select" required>
                                <option value="">Seleccionar área</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ $area->id == $reservation->area_id ? 'selected' : '' }}>
                                        {{ $area->nombre_area }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Coordinador (se guarda como consulta_id) --}}
                        <div class="col-md-4">
                            <label for="consulta_id" class="form-label">Coordinador</label>
                            <select id="consulta_id" name="consulta_id" class="form-select" required>
                                <option value="">Seleccionar coordinador</option>
                                @php
                                    $cords = $areas->firstWhere('id', $reservation->area_id)?->cordinadores ?? collect();
                                @endphp
                                @foreach ($cords as $cord)
                                    <option value="{{ $cord->id }}" {{ $cord->id == $reservation->consulta_id ? 'selected' : '' }}>
                                        {{ $cord->nombres }} {{ $cord->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Fecha --}}
                        <div class="col-md-4">
                            <label for="reservation_date" class="form-label">Fecha</label>
                            <input type="date" id="reservation_date" name="reservation_date" class="form-control"
                                   value="{{ old('reservation_date', $reservation->reservation_date) }}" required>
                        </div>

                        {{-- Hora de inicio --}}
                        <div class="col-md-4">
                            <label for="start_time" class="form-label">Hora de Inicio</label>
                            <select id="start_time" name="start_time" class="form-select" required>
                                <option value="">Seleccionar hora</option>
                                @for ($i = 9; $i <= 15; $i++)
                                    @php $hora = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $hora }}" {{ $reservation->start_time == $hora ? 'selected' : '' }}>
                                        {{ $hora }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Hora de fin --}}
                        <div class="col-md-4">
                            <label for="end_time" class="form-label">Hora Fin</label>
                            <input type="text" id="end_time" name="end_time" class="form-control" value="{{ $reservation->end_time }}" readonly>
                        </div>

                        {{-- Botones --}}
                        <div class="col-12 mt-3">
                            <a href="{{ route('reservations.index') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // const today = new Date().toISOString().split('T')[0];
    // document.getElementById('reservation_date').setAttribute('min', today);

    // Calcular hora fin
    document.getElementById('start_time').addEventListener('change', function () {
        const startTime = this.value;
        if (startTime) {
            const [h, m] = startTime.split(':');
            const endHour = parseInt(h) + 1;
            document.getElementById('end_time').value = `${String(endHour).padStart(2, '0')}:${m}`;
        } else {
            document.getElementById('end_time').value = "";
        }
    });

    // Cargar coordinadores al cambiar de área
    document.getElementById('area_id').addEventListener('change', function () {
        const areaId = this.value;
        const select = document.getElementById('consulta_id');
        select.innerHTML = '<option value="">Cargando coordinadores...</option>';

        if (areaId) {
            fetch(`/areas/${areaId}/cordinadores`)
                .then(res => res.json())
                .then(data => {
                    select.innerHTML = '<option value="">Seleccionar coordinador</option>';
                    data.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.id;
                        opt.textContent = `${c.nombres} ${c.apellidos}`;
                        select.appendChild(opt);
                    });
                })
                .catch(() => {
                    select.innerHTML = '<option value="">Error al cargar</option>';
                });
        } else {
            select.innerHTML = '<option value="">Seleccione un área primero</option>';
        }
    });

    // Validar que si hay área debe haber coordinador (consulta_id)
    document.querySelector('form').addEventListener('submit', function (e) {
        const area = document.getElementById('area_id').value;
        const consulta = document.getElementById('consulta_id').value;
        if (area && !consulta) {
            e.preventDefault();
            alert('Debe seleccionar un coordinador para el área elegida.');
            document.getElementById('consulta_id').focus();
        }
    });
</script>
@endpush
