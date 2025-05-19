@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Calendario de Reservas</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Cliente</a></li>
                    <li class="breadcrumb-item active">Calendario</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Ver Reservas</h4>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cuando el DOM esté completamente cargado, obtener el elemento con id 'calendar'
        var calendarE1 = document.getElementById('calendar');

        // Inicializa el calendario usando FullCalendar
        var calendar = new FullCalendar.Calendar(calendarE1, {
            initialView: 'dayGridMonth', // Vista inicial por mes
            locale: 'es', // Establece el idioma del calendario a español
            headerToolbar: { // Configuración de la barra de herramientas del encabezado
                left: 'prev,next today', // Botones prev, next y hoy en el lado izquierdo
                center: 'title', // El título (nombre del mes o día) en el centro
                right: 'dayGridMonth,timeGridWeek,timeGridDay', // Botones para cambiar la vista entre mes, semana y día en el lado derecho
            },
            buttonText: { // Personaliza el texto de los botones
                today: 'Hoy', // Texto del botón para "Hoy"
                month: 'Mes', // Texto del botón para la vista mensual
                week: 'Semana', // Texto del botón para la vista semanal
                day: 'Día', // Texto del botón para la vista diaria
            },
            // Define de dónde se cargarán los eventos del calendario (ruta hacia el controlador que devuelve los eventos)
            events: '{{ route("cliente.fullcalendar") }}',
            // Función que se ejecuta cuando se monta un evento en el calendario
            eventDidMount: function(info) {
                // Si el evento tiene un color de fondo definido, aplicarlo al elemento del evento
                if (info.event.backgroundColor) {
                    info.el.style.backgroundColor = info.event.backgroundColor;
                }

                // Si el evento tiene un color de borde definido, aplicarlo al elemento del evento
                if (info.event.borderColor) {
                    info.el.style.borderColor = info.event.borderColor;
                }
            }
        });

        // Renderizar el calendario en la página
        calendar.render();
    });
</script>
@endpush
