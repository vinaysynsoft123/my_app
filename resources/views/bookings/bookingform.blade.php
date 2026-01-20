<!-- Booking Form Modal -->
<div class="modal fade" id="bookingFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow rounded-4">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-semibold">
                    Book Room <span id="bookingRoomNumber"></span>
                    <small class="d-block text-muted fs-6">
                        on <span id="bookingDate"></span>
                    </small>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="bookingForm">
                <div class="modal-body pt-2">
                    <!-- Hidden -->
                    <input type="hidden" name="room_id" id="bookingRoomId">
                    <div class="row g-3">
                        <!-- Guest Name -->
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-person me-1"></i> Guest Name
                            </label>
                            <input type="text" name="guest_name" class="form-control rounded-3" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-envelope me-1"></i> Email
                            </label>
                            <input type="email" name="guest_email" class="form-control rounded-3">
                        </div>

                        <!-- Phone -->
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-telephone me-1"></i> Phone
                            </label>
                            <input type="text" name="phone" class="form-control rounded-3" required>
                        </div>

                        <!-- Adults -->
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-people me-1"></i> Adults
                            </label>
                            <input type="number" name="adults" class="form-control rounded-3" value="1"
                                min="1" max="8">
                        </div>

                        <!-- Children -->
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-people me-1"></i> Children
                            </label>
                            <input type="number" name="children" class="form-control rounded-3" value="0"
                                min="0" max="4">
                        </div>

                        <!-- Meal Plan -->
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-cup-hot me-1"></i> Meal Plan
                            </label>
                            <select name="meal_plan" class="form-select rounded-3" required>
                                <option value="">Select Meal Plan</option>
                                <option value="EP – Room Only">EP – Room Only</option>
                                <option value="CP – Breakfast">CP – Breakfast</option>
                                <option value="MAP – Breakfast + Dinner">MAP – Breakfast + Dinner</option>
                                <option value="AP – All Meals">AP – All Meals</option>
                            </select>
                        </div>

                        <!-- Booking Date (Readonly) -->
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-calendar-event me-1"></i> Check-in Date
                            </label>
                            <input type="date" class="form-control bg-light rounded-3" id="checkInDisplay" readonly>
                            <input type="hidden" name="check_in" id="bookingCheckIn">
                            
                        </div>
                        <div class="col-md-3">
                        <label class="form-label">
                            <i class="bi bi-clock me-1"></i> Check-in Time
                        </label>
                        <input type="time" name="check_in_time" class="form-control rounded-3" id="checkInTime">
                    </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-calendar-event me-1"></i> Check-out Date
                            </label>
                            <input type="date" name="check_out" id="checkOutDate" class="form-control rounded-3"
                                required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-cash-coin me-1"></i> Advance Payment
                            </label>
                            <input type="number" name="advance" class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-credit-card me-1"></i> Payment Mode
                            </label>
                           <select name="payment_mode" class="form-select rounded-3" required>
                                <option value="">Select Payment Mode</option>
                                <option value="Cash">Cash</option>
                                <option value="UPI">UPI</option>
                                <option value="NEFT">NEFT</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-person me-1"></i> Receptionist Name
                            </label>
                            <input type="text" name="receptionist_name" class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-person me-1"></i> Payment Person
                            </label>
                            <input type="text" name="payment_person" class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-cash-coin me-1"></i> Tariff
                            </label>
                            <input type="number" name="total_amount" class="form-control rounded-3" required>
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <label class="form-label">
                                <i class="bi bi-chat-left-text me-1"></i> Special Requests / Notes
                            </label>
                            <textarea name="notes" class="form-control rounded-3" rows="2"></textarea>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary ml-auto py-2 rounded-3 fw-semibold">
                        Confirm & Save Booking
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
