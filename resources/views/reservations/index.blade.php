@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Listado de Reserva</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Reservas</a></li>
                    <li class="breadcrumb-item active">Lista de Reservas</li>
                </ol>
            </div>

        </div>
    </div>
</div>
{{-- <pre>{{ json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Reservas</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('reservations.create') }}" class="btn btn-primary waves-effect waves-light">Nueva Reserva</a>
                <br>
                <br>
                <table id="reservationsTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                #id
                            </th>
                            <th>Usuario</th>
                            <th>Área</th>
                            <th>Consultor</th>
                            <th>Fecha</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->user->nombres }} {{ $reservation->user->apellidos }}</td>
                            <td>{{ $reservation->area ? $reservation->area->nombre_area : 'Área no asignada' }}</td>
                            <td>
                                {{ (!empty($reservation->consultant) && !empty($reservation->consultant->nombres) && !empty($reservation->consultant->apellidos))
                                    ? $reservation->consultant->nombres . ' ' . $reservation->consultant->apellidos
                                    : 'Coordinador no asignado' }}
                            </td>
                            <td>{{ $reservation->reservation_date }}</td>
                            <td>{{ $reservation->start_time }}</td>
                            <td>{{ $reservation->end_time }}</td>

                            <td>
                                @if($reservation->reservation_status == 'cancelada')
                                    <button class="btn btn-warning btn-sm" disabled>Editar</button>
                                    <button class="btn btn-danger btn-sm" disabled>Cancelar</button>
                                @else
                                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <button type="button" class="btn btn-danger btn-sm btn-cancel" data-id="{{ $reservation->id }}">Cancelar</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Ejecutar cuando el DOM esté completamente cargado
    $(document).ready(function() {
        $('#reservationsTable').DataTable({
            order: [[0, 'desc']] // ordena por la primera columna (índice 0) en orden descendente
        });
    });

    // Evento para el botón de cancelar reserva
    $('.btn-cancel').on('click', function(e) {
        e.preventDefault(); // Prevenir la acción predeterminada del enlace
        var reservationId = $(this).data('id'); // Obtener el ID de la reserva desde el atributo 'data-id'

        // Muestra el modal de SweetAlert para ingresar la razón de la cancelación
        Swal.fire({
            title: "Cancelar Reserva", // Título del modal
            icon: "warning", // Ícono de advertencia
            text: "Por favor, ingresa la razón de la cancelación:", // Texto del modal
            input: 'textarea', // Tipo de input para ingresar la razón
            inputPlaceholder: 'Escribe la razón de la cancelación aquí...', // Placeholder para el input
            showCancelButton: true, // Mostrar botón de cancelar
            confirmButtonText: "Cancelar Reserva", // Texto del botón de confirmación
            cancelButtonText: 'Cerrar', // Texto del botón de cerrar
            preConfirm: (cancellationReason) => {
                // Validación: Si no se ingresa una razón, mostrar un mensaje de error
                if (!cancellationReason) {
                    swal.showValidationMessage('Es necesario ingresar una razón');
                    return false;
                } else {
                    // Promesa para realizar la solicitud AJAX
                    return new Promise((resolve) => {
                        $.ajax({
                            url: "{{ route('reservations.cancel') }}", // Ruta para cancelar la reserva
                            method: "POST", // Método POST para enviar la solicitud
                            data: {
                                _token: "{{ csrf_token() }}", // Token CSRF para la seguridad de Laravel
                                reservation_id: reservationId, // ID de la reserva
                                cancellation_reason: cancellationReason, // Razón de la cancelación
                            },
                            success: function(response) {
                                // Si la solicitud es exitosa y la reserva fue cancelada
                                if (response.success) {
                                    Swal.fire({
                                        title: "Reserva cancelada", // Título del mensaje de éxito
                                        text: response.message, // Mensaje de éxito
                                        icon: "success" // Ícono de éxito
                                    }).then(() => {
                                        location.reload(); // Recargar la página
                                    });
                                } else {
                                    // Si hay un error en la solicitud
                                    Swal.fire({
                                        title: "Error", // Título del mensaje de error
                                        text: response.message, // Mensaje de error
                                        icon: "error" // Ícono de error
                                    });
                                }
                            }
                        });
                    });
                }
            }
        });
    });
</script>

@if(session('success'))
<script>
    // Mostrar una notificación Toastify si existe un mensaje de éxito en la sesión
    Toastify({
        text: "{{ session('success') }}", // Mensaje de éxito de la sesión
        duration: 2000, // Duración de la notificación (2 segundos)
        close: true, // Mostrar botón de cerrar
        gravity: "top", // Posición de la notificación (arriba)
        position: "right", // Posición a la derecha
        stopOnFocus: true, // Evitar que la notificación se cierre al pasar el ratón por encima
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)", // Estilo de fondo
        },
    }).showToast();
</script>
@endif
@endpush

