@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h5 class="mb-3 fw-semibold text-center text-md-start">
            📅 Booking Calendar
        </h5>
        <div class="card shadow-sm">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>

        {{-- Include Rooms Modal --}}
        @include('bookings.roommodel')

        {{-- Include Booking Form Modal --}}
        @include('bookings.bookingform')
    </div>
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const calendarEl = document.getElementById('calendar');
                const roomsModal = new bootstrap.Modal(document.getElementById('roomsModal'));
                const bookingFormModal = new bootstrap.Modal(document.getElementById('bookingFormModal'));

                const roomsList = document.getElementById('roomsList');
                const roomsWrapper = document.getElementById('roomsWrapper');
                const selectedDateEl = document.getElementById('selectedDate');

                let selectedDate = '';
                let calendar;

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek'
                    },
                    events: "{{ route('bookings.events') }}",
                    //  validRange: function(nowDate) {
                    //     return {
                    //         start: nowDate // today
                    //     };
                    // },

                    dateClick: function(info) {
                        selectedDate = info.dateStr;
                        selectedDateEl.innerText = formatDateDMY(selectedDate);
                        loadRooms(selectedDate);
                        roomsWrapper.classList.remove('d-none');
                        roomsModal.show();
                    }
                });

                calendar.render();

                function loadRooms(date) {
                    roomsList.innerHTML = '<div class="text-center">Loading...</div>';

                    fetch(`/rooms-by-date/${date}`)
                        .then(res => res.json())
                        .then(data => {
                            roomsList.innerHTML = '';

                            data.forEach(room => {
                                roomsList.innerHTML += `
                <div class="col-lg-2 col-md-3 col-sm-4 mb-3">
                    <div class="card shadow-sm text-center
                        ${room.booked ? 'opacity-75' : 'room-select'}"
                        style="cursor:${room.booked ? 'not-allowed' : 'pointer'}"
                        ${room.booked ? '' : `onclick="selectRoom(${room.id}, '${date}', '${room.room_number}')"`}>

                        <div class="card-body p-2">
                            <h6 class="mb-1">${room.room_number}</h6>
                            <small class="text-muted">${room.type}</small>

                            <span class="badge ${room.booked ? 'bg-danger' : 'bg-success'} w-100 mt-2">
                                ${room.booked ? 'Booked' : 'Available'}
                            </span>

                            ${room.booked ? `
                                                                                <div class="mt-2 text-danger fw-semibold small">
                                                                                     ${room.guest_name}
                                                                                </div>
                                                                            ` : ''}
                        </div>
                    </div>
                </div>`;
                            });
                        });
                }



                document.getElementById('bookingForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    fetch("{{ route('bookings.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Booking Confirmed Successfully!', 'success');
                                this.reset();
                                bookingFormModal.hide();
                                roomsModal.hide();
                                calendar.refetchEvents();
                            } else {
                                alert('Something went wrong');
                            }
                        });
                });

                // 🔹 When booking form closes → show rooms again
                document.getElementById('bookingFormModal')
                    .addEventListener('hidden.bs.modal', function() {
                        roomsWrapper.classList.remove('d-none');
                    });

            });

            window.selectRoom = function(roomId, date, roomNumber) {

                // Hide rooms
                document.getElementById('roomsWrapper').classList.add('d-none');

                document.getElementById('bookingRoomId').value = roomId;
                document.getElementById('bookingRoomNumber').innerText = roomNumber;
                document.getElementById('bookingDate').innerText = formatDateDMY(date);

                document.getElementById('checkInDisplay').value = date;
                document.getElementById('bookingCheckIn').value = date;

                const checkIn = new Date(date);
                checkIn.setDate(checkIn.getDate() + 1);

                const yyyy = checkIn.getFullYear();
                const mm = String(checkIn.getMonth() + 1).padStart(2, '0');
                const dd = String(checkIn.getDate()).padStart(2, '0');

                const nextDate = `${yyyy}-${mm}-${dd}`;
                const checkOutInput = document.getElementById('checkOutDate');

                checkOutInput.value = nextDate;
                checkOutInput.min = nextDate;

                new bootstrap.Modal(document.getElementById('bookingFormModal')).show();
            };

            function formatDateDMY(dateStr) {
                const d = new Date(dateStr);
                return `${String(d.getDate()).padStart(2,'0')}-${String(d.getMonth()+1).padStart(2,'0')}-${d.getFullYear()}`;
            }
        </script>
        <script>
            function showToast(message, type = 'success') {
                const toastContainer = document.querySelector('.toast-container');

                const toastEl = document.createElement('div');
                toastEl.className = `toast align-items-center text-bg-${type} border-0`;
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.setAttribute('aria-atomic', 'true');

                toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

                toastContainer.appendChild(toastEl);

                const toast = new bootstrap.Toast(toastEl, {
                    delay: 4000
                });
                toast.show();

                toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            }
        </script>
    @endsection
