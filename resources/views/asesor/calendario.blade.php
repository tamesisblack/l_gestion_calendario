@extends('layouts.app')

@section('content')
<div id="app"> <!-- Este id es importante para Vue -->
    <div>
        <div id="calendar"></div>

        <!-- Modal para mostrar detalles del evento -->
        <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventDetailsModalLabel">Detalles de la Reserva</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="seccionImprimir2">
                        <div v-for="(item, index) in fotos" :key="index">
                            <p>Fecha de la Reserva: @{{ item.reservation_date }}</p>
                            <img :src="'/storage/' + item.foto_evidencia" alt="Foto de Evidencia" style="max-width: 100%; display: block; margin-top: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="m_imprimirTodos('12px', 'Evidencias', '0px', '', 'portrait')">Imprimir</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Incluir Vue 2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Vue({
            el: '#app',
            data: {
                fotos: [] // Array para almacenar las fotos de evidencia
            },
            methods: {
                // Método para cargar las imágenes en el modal
                cargarFotos(userId, reservationDate) {
                    fetch(`/reservations/evidencias/${userId}/${reservationDate}`)
                        .then(response => response.json())
                        .then(data => {
                            this.fotos = data; // Asignamos el array de imágenes a la variable fotos
                            $('#eventDetailsModal').modal('show'); // Mostramos el modal
                        })
                        .catch(error => {
                            console.error('Error al cargar las fotos:', error);
                        });
                },
                m_imprimirTodos(estiloSize = "12px", nombreArchivo = "documento", tamanoborde = "0px", textomarca_agua = '', orientacion = '') {
                    const notifyDiv = document.createElement('div');
                    notifyDiv.style.position = 'fixed';
                    notifyDiv.style.top = '50%';
                    notifyDiv.style.left = '50%';
                    notifyDiv.style.transform = 'translate(-50%, -50%)';
                    notifyDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                    notifyDiv.style.color = '#fff';
                    notifyDiv.style.borderRadius = '5px';
                    notifyDiv.style.padding = '20px';
                    notifyDiv.style.zIndex = '99999999';
                    notifyDiv.style.display = 'flex';
                    notifyDiv.style.alignItems = 'center';
                    notifyDiv.style.justifyContent = 'center';
                    notifyDiv.style.fontSize = '16px';
                    notifyDiv.innerHTML = `
                        <span style="margin-right: 10px;">⚠️</span>
                        <span>Tiene documentos para impresión abiertos, ciérrelos para poder navegar en esta página.</span>
                    `;
                    document.body.appendChild(notifyDiv);
                    notifyDiv.style.display = 'block';

                    setTimeout(() => {
                        notifyDiv.style.display = 'none';
                    }, 10000);

                    const printContents = document.getElementById('seccionImprimir2').innerHTML;

                    const htmlContent = `
                    <html>
                        <head>
                            <title>${nombreArchivo}</title>
                            <style>
                            body {
                                font-family: Calibri, sans-serif;
                                font-size: ${estiloSize};
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                font-size: ${estiloSize};
                            }
                            th, td {
                                border: ${tamanoborde} solid #ddd;
                                padding: 3px;
                                font-size: ${estiloSize};
                            }
                            th {
                                text-align: left;
                                background-color: #f2f2f2;
                            }
                            .watermark {
                                position: fixed;
                                top: 50%;
                                left: 50%;
                                transform: translate(-50%, -50%) rotate(-45deg);
                                font-size: 5rem;
                                color: rgba(0, 0, 0, 0.1);
                                z-index: -1;
                                pointer-events: none;
                                user-select: none;
                                white-space: nowrap;
                                text-align: center;
                            }
                            @media print {
                                .watermark {
                                    position: fixed;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%) rotate(-45deg);
                                    font-size: 5rem;
                                    color: rgba(0, 0, 0, 0.1);
                                    z-index: -1;
                                }
                                @page {
                                    size: ${orientacion ? orientacion : 'portrait'};
                                    margin: 10mm;
                                }
                            }
                            </style>
                        </head>
                        <body>
                            <div class="watermark">${textomarca_agua}</div>
                            ${printContents}
                        </body>
                    </html>`;

                    const newWin = window.open('', '_blank');
                    newWin.document.write(htmlContent);
                    newWin.document.close();

                    const images = newWin.document.getElementsByTagName('img');
                    const imageLoadPromises = Array.from(images).map(img => {
                        return new Promise((resolve) => {
                            img.onload = resolve;
                            img.onerror = resolve;
                        });
                    });

                    Promise.all(imageLoadPromises).then(() => {
                        newWin.print();
                        newWin.close();
                    });

                    let intervalId = setInterval(() => {
                        if (newWin.closed) {
                            clearInterval(intervalId);
                            notifyDiv.style.display = 'none';
                            document.body.removeChild(notifyDiv);
                        }
                    }, 1000);
                }

            },
            mounted() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay',
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día',
                    },
                    events: '{{ route("asesor.fullcalendar") }}',

                    // Aquí agregas la personalización de colores
                    eventDidMount: function (info) {
                        if (info.event.backgroundColor) {
                            info.el.style.backgroundColor = info.event.backgroundColor;
                        }
                        if (info.event.borderColor) {
                            info.el.style.borderColor = info.event.borderColor;
                        }
                    },

                    eventClick: (info) => {
                        const userId = info.event.extendedProps.user_id;
                        const reservationDate = info.event.extendedProps.reservation_date;
                        this.cargarFotos(userId, reservationDate);
                    }
                });

                calendar.render();
            }
        });
    });
</script>
@endpush
