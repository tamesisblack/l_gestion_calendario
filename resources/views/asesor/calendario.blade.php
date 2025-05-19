@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Calendario de Reservas</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Asesor</a></li>
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
    document.addEventListener('DOMContentLoaded',function(){
        var calendarE1 = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarE1,{
            initialView : 'dayGridMonth',
            locale : 'es',
            headerToolbar : {
                left : 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            buttonText:{
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
            },
            events: '{{ route("asesor.fullcalendar") }}',
            eventDidMount: function(info){
                if(info.event.backgroundColor){
                    info.el.style.backgroundColor = info.event.backgroundColor;
                }

                if(info.event.borderColor){
                    info.el.style.borderColor = info.event.borderColor;
                }
            }
        });

        calendar.render();
    });
</script>
@endpush
