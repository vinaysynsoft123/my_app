@extends('layouts.app')

@section('content')
<h4 class="mb-4">Booking Calendar</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

{{-- Include Rooms Modal --}}
@include('bookings.roommodel')

{{-- Include Booking Form Modal --}}
@include('bookings.bookingform')

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');
    const roomsModal = new bootstrap.Modal(document.getElementById('roomsModal'));
    const bookingFormModal = new bootstrap.Modal(document.getElementById('bookingFormModal'));

    const roomsList = document.getElementById('roomsList');
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

        dateClick: function(info) {
            selectedDate = info.dateStr;
            selectedDateEl.innerText = selectedDate;
            loadRooms(selectedDate);
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
                                    <h6>${room.room_number}</h6>
                                    <small>${room.type}</small>
                                    <span class="badge ${room.booked ? 'bg-danger' : 'bg-success'} w-100 mt-2">
                                        ${room.booked ? 'Booked' : 'Available'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
    }

    window.selectRoom = function(roomId, date, roomNumber) {
        document.getElementById('bookingRoomId').value = roomId;
        document.getElementById('bookingCheckIn').value = date;
        document.getElementById('bookingRoomNumber').innerText = roomNumber;
        document.getElementById('bookingDate').innerText = date;

        bookingFormModal.show();
    };

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
                alert('Booking Confirmed!');
                bookingFormModal.hide();
                roomsModal.hide();
                calendar.refetchEvents();
            } else {
                alert('Something went wrong');
            }
        })
        .catch(err => console.error(err));
    });

});
</script>
@endsection
