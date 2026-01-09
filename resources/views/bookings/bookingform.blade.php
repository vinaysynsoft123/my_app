<!-- Booking Form Modal -->
<div class="modal fade" id="bookingFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable mt-5">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Book Room – <span id="bookingRoomNumber"></span> on <span id="bookingDate"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bookingForm">
                <div class="modal-body">
                    <input type="hidden" name="room_id" id="bookingRoomId">
                    <input type="hidden" name="check_in" id="bookingCheckIn">

                    <div class="mb-3">
                        <label for="guest_name" class="form-label">Guest Name</label>
                        <input type="text" name="guest_name" id="guest_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="guest_email" class="form-label">Guest Email</label>
                        <input type="email" name="guest_email" id="guest_email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="guest_phone" class="form-label">Guest Phone</label>
                        <input type="text" name="guest_phone" id="guest_phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Confirm Booking</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
