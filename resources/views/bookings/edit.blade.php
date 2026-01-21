@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Edit Booking</h4>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('bookings.update', $booking->id) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="room_id" value="{{ $booking->room_id }}">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Guest Name</label>
                        <input type="text" name="guest_name" class="form-control"
                            value="{{ old('guest_name', $booking->guest_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="guest_email" class="form-control"
                            value="{{ old('guest_email', $booking->email) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $booking->phone) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bi bi-people me-1"></i> Adults
                        </label>
                        <input type="number" name="adults" class="form-control rounded-3" min="1" max="8"
                            value="{{ old('adults', $booking->adults) }}">
                    </div>

                    <!-- Children -->
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bi bi-people me-1"></i> Children
                        </label>
                        <input type="number" name="children" class="form-control rounded-3" value="0" min="0"
                            max="4" value="{{ old('children', $booking->children) }}">
                    </div>

                    <!-- Meal Plan -->
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bi bi-cup-hot me-1"></i> Meal Plan
                        </label>

                        <select name="meal_plan" class="form-select rounded-3" required>
                            <option value="">Select Meal Plan</option>

                            <option value="EP – Room Only"
                                {{ old('meal_plan', $booking->meal_plan) == 'EP – Room Only' ? 'selected' : '' }}>
                                EP – Room Only
                            </option>

                            <option value="CP – Breakfast"
                                {{ old('meal_plan', $booking->meal_plan) == 'CP – Breakfast' ? 'selected' : '' }}>
                                CP – Breakfast
                            </option>

                            <option value="MAP – Breakfast + Dinner"
                                {{ old('meal_plan', $booking->meal_plan) == 'MAP – Breakfast + Dinner' ? 'selected' : '' }}>
                                MAP – Breakfast + Dinner
                            </option>

                            <option value="AP – All Meals"
                                {{ old('meal_plan', $booking->meal_plan) == 'AP – All Meals' ? 'selected' : '' }}>
                                AP – All Meals
                            </option>
                        </select>
                    </div>


                    <div class="col-md-3">
                        <label class="form-label">Check-in</label>


                        <input type="date" class="form-control" name="check_in" id="checkInDate"
                            value="{{ old('check_in', $booking->check_in->format('Y-m-d')) }}"
                            min="{{ min(now()->format('Y-m-d'), $booking->check_in->format('Y-m-d')) }}">

                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bi bi-clock me-1"></i> Check-in Time
                        </label>
                        <input type="time" name="check_in_time" class="form-control rounded-3" id="checkInTime"
                            value="{{ old('check_in_time', $booking->check_in_time) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Check-out</label>
                        <input type="date" name="check_out" class="form-control" id="checkOutDate"
                            value="{{ old('check_out', $booking->check_out->format('Y-m-d')) }}"
                            min="{{ old('check_in', $booking->check_in->format('Y-m-d')) }}">
                    </div>


                    <div class="col-md-3">
                        <label class="form-label">Advance</label>
                        <input type="number" name="advance" class="form-control"
                            value="{{ old('advance', $booking->advance) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" class="form-select" required>
                            @foreach (['Cash', 'UPI', 'NEFT', 'Other'] as $mode)
                                <option value="{{ $mode }}"
                                    {{ $booking->payment_mode == $mode ? 'selected' : '' }}>
                                    {{ $mode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Receptionist Name</label>
                        <input type="text" name="receptionist_name" class="form-control"
                            value="{{ old('receptionist_name', $booking->receptionist_name) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Payment Person</label>
                        <input type="text" name="payment_person" class="form-control"
                            value="{{ old('payment_person', $booking->payment_person) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tariff</label>
                        <input type="number" name="tariff" class="form-control"
                            value="{{ old('tariff', $booking->tariff) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control">{{ old('notes', $booking->notes) }}</textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn btn-primary">Update Booking</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <script>
        const checkIn = document.getElementById('checkInDate');
        const checkOut = document.getElementById('checkOutDate');

        checkIn.addEventListener('change', function() {
            if (this.value) {
                checkOut.min = this.value;
                if (!checkOut.value || checkOut.value < this.value) {
                    checkOut.value = this.value;
                }
            }
        });
    </script>
@endsection