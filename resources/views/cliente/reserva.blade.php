@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Nueva Reserva</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Reserva</a></li>
                    <li class="breadcrumb-item active">Nueva Reserva</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Crear Nueva Reserva</h4>
            </div>
            <div class="card-body">
                <form class="row gy-1" id="reservationForm" method="POST" action="{{ route('reservations.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="user" class="form-label">{{ __('Usuario') }}</label>
                            <input id="user" type="text" class="form-control" value="{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}" readonly>
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                        </div>
                    </div>

                    {{-- <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="consulta_id" class="form-label">{{ __('Consultor') }}</label>
                            <select class="form-select @error('consulta_id') is-invalid @enderror" id="consulta_id" name="consulta_id" required>
                                <option value="">Seleccionar Consultor</option>
                                @foreach ($consultants as $consultant )
                                    <option value="{{ $consultant->id }}">{{ $consultant->nombres }} {{ $consultant->apellidos }}</option>
                                @endforeach
                            </select>
                            @error('consulta_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="reservation_date" class="form-label">{{ __('Fecha de Reserva') }}</label>
                            <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" id="reservation_date" name="reservation_date" value="{{ old('reservation_date') }}" required>
                            @error('reservation_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="start_time" class="form-label">{{ __('Hora de Inicio') }}</label>
                            <select class="form-select @error('start_time') is-invalid @enderror" id="start_time" name="start_time" required>
                                <option value="">Seleccionar una hora</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                            </select>
                            @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="end_time" class="form-label">{{ __('Hora Fin') }}</label>
                            <input type="text" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" readonly>
                            @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="reservation_status" class="form-label">{{ __('Estado de la Reserva') }}</label>
                            <select class="form-select @error('reservation_status') is-invalid @enderror" id="reservation_status" name="reservation_status" required>
                                <option value="">Seleccionar un estado</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                            </select>
                            @error('reservation_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="col-xxl-3 col-md-6">
                        <div>
                            <label for="foto_evidencia" class="form-label">{{ __('Foto Evidencia') }}</label>
                            <input type="file" id="foto_evidencia" name="foto_evidencia" class="form-control pe-5 @error('foto_evidencia') is-invalid @enderror">
                            @error('foto_evidencia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div style="margin-top: 27px">
                            <button type="submit" class="btn btn-primary">Crear Reserva</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://www.paypal.com/sdk/js?client-id=AWxL0bRmYRB-uEt0-JFzYjY_5i0qdn38KKhZe_tVtToS3rDOdx2Ro_dW4qTVaMOKNzukswGqddhBI0V6&currency=USD"></script>
<script>
      // Obtiene la fecha actual en formato YYYY-MM-DD y la establece como mínimo en el campo de fecha de reserva
      const today = new Date().toISOString().split('T')[0];
    document.getElementById('reservation_date').setAttribute('min', today);

    const pricePerHour = 50; // Define el precio por hora

    // Evento cuando el usuario selecciona la hora de inicio
    document.getElementById('start_time').addEventListener('change', function() {
        const startTime = this.value; // Obtiene el valor de la hora de inicio seleccionada

        if (startTime) {
            // Convierte la hora de inicio en un objeto Date (usando una fecha ficticia)
            const startDate = new Date(`1970-01-01T${startTime}:00`);
            // Añade una hora al objeto Date
            startDate.setHours(startDate.getHours() + 1);
            // Formatea la nueva hora como HH:MM
            const endTime = startDate.toTimeString().slice(0, 5);
            // Establece el valor del campo de hora de finalización
            document.getElementById('end_time').value = endTime;

            // Calcula el total por una hora (puedes ajustar si hay múltiplos de horas)
            // const total = pricePerHour; // Para este caso, el total es el precio por una hora
            // document.getElementById('total_amount').value = total.toFixed(2); // Establece el total formateado
        } else {
            // Si no se selecciona una hora, limpia los campos de hora de finalización y total
            document.getElementById('end_time').value = "";
            // document.getElementById('total_amount').value = "";
        }
    });

</script>
@endpush
