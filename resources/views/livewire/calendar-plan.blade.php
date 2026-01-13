<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @push('styles')
        <style>
            .container {
                max-width: 1200px;
                margin: 0 auto;
                background: white;
                border-radius: 16px;
                padding: 30px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }

            h1 {
                text-align: center;
                color: #2d3748;
                margin-bottom: 10px;
                font-size: 2rem;
            }

            .subtitle {
                text-align: center;
                color: #718096;
                margin-bottom: 30px;
                font-size: 1rem;
            }

            #calendar {
                margin-top: 20px;
            }

            /* Estilos personalizados para el calendario */
            .fc {
                font-family: inherit;
            }

            .fc-toolbar-title {
                font-size: 1.5rem !important;
                color: #2d3748;
            }

            .fc-button {
                background-color: #667eea !important;
                border: none !important;
                padding: 8px 16px !important;
                text-transform: capitalize !important;
            }

            .fc-button:hover {
                background-color: #5a67d8 !important;
            }

            .fc-button-active {
                background-color: #4c51bf !important;
            }

            .fc-daygrid-day-number {
                color: #2d3748;
                font-weight: 600;
            }

            .fc-col-header-cell-cushion {
                color: #4a5568;
                font-weight: 600;
            }

            /* Estilos para diferentes dificultades */
            .fc-event {
                border: none !important;
                cursor: pointer;
                transition: transform 0.2s;
            }

            .fc-event:hover {
                transform: scale(1.05);
            }

            .fc-event-easy {
                background-color: #48bb78 !important;
            }

            .fc-event-medium {
                background-color: #ed8936 !important;
            }

            .fc-event-hard {
                background-color: #f56565 !important;
            }

            .fc-event-default {
                background-color: #4299e1 !important;
            }

            /* Modal de detalles */
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                z-index: 1000;
                align-items: center;
                justify-content: center;
            }

            .modal.active {
                display: flex;
            }

            .modal-content {
                background: white;
                padding: 30px;
                border-radius: 12px;
                max-width: 500px;
                width: 90%;
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
            }

            .modal-close {
                position: absolute;
                top: 15px;
                right: 15px;
                background: none;
                border: none;
                font-size: 24px;
                cursor: pointer;
                color: #a0aec0;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: all 0.2s;
            }

            .modal-close:hover {
                background: #f7fafc;
                color: #2d3748;
            }

            .modal-title {
                font-size: 1.5rem;
                color: #2d3748;
                margin-bottom: 20px;
                padding-right: 30px;
            }

            .modal-detail {
                margin-bottom: 15px;
            }

            .modal-label {
                font-weight: 600;
                color: #4a5568;
                display: block;
                margin-bottom: 5px;
                font-size: 0.875rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .modal-value {
                color: #2d3748;
                font-size: 1rem;
            }

            .difficulty-badge {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 0.875rem;
                font-weight: 600;
            }

            .difficulty-easy {
                background: #c6f6d5;
                color: #22543d;
            }

            .difficulty-medium {
                background: #feebc8;
                color: #7c2d12;
            }

            .difficulty-hard {
                background: #fed7d7;
                color: #742a2a;
            }

            .legend {
                display: flex;
                gap: 20px;
                justify-content: center;
                flex-wrap: wrap;
                margin-top: 20px;
                padding: 15px;
                background: #f7fafc;
                border-radius: 8px;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 0.875rem;
            }

            .legend-color {
                width: 20px;
                height: 20px;
                border-radius: 4px;
            }
        </style>
    @endpush


    <div class="container">
        <h1>📅 Calendario de Planes</h1>
        <p class="subtitle">Visualiza todos tus planes y aventuras</p>

        <div class="legend">
            <div class="legend-item">
                <div class="legend-color" style="background: #48bb78;"></div>
                <span>Fácil</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: #ed8936;"></div>
                <span>Media</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: #f56565;"></div>
                <span>Difícil</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: #4299e1;"></div>
                <span>Sin dificultad</span>
            </div>
        </div>

        <div id="calendar"></div>
    </div>

    <!-- Modal para mostrar detalles del plan -->
    <div class="modal" id="planModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">×</button>
            <h2 class="modal-title" id="modalTitle"></h2>

            <div class="modal-detail">
                <span class="modal-label">📅 Fechas</span>
                <div class="modal-value" id="modalDate"></div>
            </div>

            <div class="modal-detail">
                <span class="modal-label">🕐 Hora</span>
                <div class="modal-value" id="modalTime"></div>
            </div>

            <div class="modal-detail">
                <span class="modal-label">📍 Lugar de Encuentro</span>
                <div class="modal-value" id="modalPlace"></div>
            </div>

            <div class="modal-detail">
                <span class="modal-label">💪 Dificultad</span>
                <div id="modalDifficulty"></div>
            </div>

            <div class="modal-detail">
                <span class="modal-label">📝 Descripción</span>
                <div class="modal-value" id="modalDescription"></div>
            </div>

            <div class="modal-detail" id="observationsSection" style="display: none;">
                <span class="modal-label">👁️ Observaciones</span>
                <div class="modal-value" id="modalObservations"></div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            // Datos de ejemplo - En Laravel esto vendría del backend
            const plans = @json($plansAcceptedclaencalendar);

            // Convertir planes a eventos de FullCalendar
            const events = plans.map(plan => {
                let className = 'fc-event-default';
                if (plan.difficulty === 'easy') className = 'fc-event-easy';
                if (plan.difficulty === 'medium') className = 'fc-event-medium';
                if (plan.difficulty === 'hard') className = 'fc-event-hard';

                return {
                    id: plan.id,
                    title: plan.name,
                    start: `${plan.start_date}T${plan.time_out}`,
                    end: plan.end_date ? `${plan.end_date}T${plan.time_out}` : null,
                    className: className,
                    extendedProps: {
                        ...plan
                    }
                };
            });

            // Inicializar FullCalendar
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        list: 'Lista'
                    },
                    events: events,
                    eventClick: function(info) {
                        showPlanDetails(info.event);
                    },
                    height: 'auto',
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false
                    }
                });

                calendar.render();
            });

            function showPlanDetails(event) {
                const plan = event.extendedProps;

                document.getElementById('modalTitle').textContent = plan.name;
                document.getElementById('modalDate').textContent = new Date(plan.start_date).toLocaleDateString('es-ES', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                if (plan.end_date) {
                    document.getElementById('modalDate').textContent += ' - ' + new Date(plan.end_date).toLocaleDateString(
                        'es-ES', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                }
                document.getElementById('modalTime').textContent = plan.time_out;
                document.getElementById('modalPlace').textContent = plan.meeting_place;
                document.getElementById('modalDescription').textContent = plan.description || 'Sin descripción';

                // Dificultad
                const difficultyMap = {
                    'easy': {
                        text: 'Fácil',
                        class: 'difficulty-easy'
                    },
                    'medium': {
                        text: 'Media',
                        class: 'difficulty-medium'
                    },
                    'hard': {
                        text: 'Difícil',
                        class: 'difficulty-hard'
                    }
                };

                const diff = difficultyMap[plan.difficulty] || {
                    text: 'No especificada',
                    class: ''
                };
                document.getElementById('modalDifficulty').innerHTML =
                    `<span class="difficulty-badge ${diff.class}">${diff.text}</span>`;

                // Observaciones
                const obsSection = document.getElementById('observationsSection');
                if (plan.observations) {
                    document.getElementById('modalObservations').textContent = plan.observations;
                    obsSection.style.display = 'block';
                } else {
                    obsSection.style.display = 'none';
                }

                document.getElementById('planModal').classList.add('active');
            }

            function closeModal() {
                document.getElementById('planModal').classList.remove('active');
            }

            // Cerrar modal al hacer clic fuera
            document.getElementById('planModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        </script>
    @endpush
</div>
