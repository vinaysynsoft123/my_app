<div class="modal fade" id="roomsModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form method="POST" id="cancelBookingForm">
                @csrf

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-x-circle me-2"></i>
                        Cancel Booking
                    </h5>
                    <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Cancellation Reason -->
                    <div class="mb-3">
                        <label class="form-label">
                            Cancellation Reason <span class="text-danger">*</span>
                        </label>
                        <textarea name="cancellation_reason"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Enter cancellation reason..."
                                  required></textarea>
                    </div>

                    <!-- Refund Amount -->
                    <div class="mb-3">
                        <label class="form-label">Refund Amount (₹)</label>
                        <input type="number"
                               name="refund_amount"
                               class="form-control"
                               placeholder="Enter refund amount"
                               min="0"
                               step="0.01">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-danger">
                        <i class="bi bi-check-circle"></i>
                        Confirm Cancellation
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
