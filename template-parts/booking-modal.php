<div id="bookingModal" class="booking-modal">
    <div class="booking-modal-content">
        <span class="booking-close">&times;</span>

        <!-- Booking Form -->
        <div class="booking-card">
            <div class="booking-header">
                <h3>Book Your Stay</h3>
            </div>
            <form class="booking-form" method="get" action="<?php echo site_url('/checkout'); ?>">
                <div class="form-row">
                    <div class="form-group">
                        <input type="hidden" name="room_id" id="room_id">
                        <label for="checkin">Check-in</label>
                        <input type="date" id="checkin" name="checkin">
                    </div>
                    <div class="form-group">
                        <label for="checkout">Check-out</label>
                        <input type="date" id="checkout" name="checkout">
                    </div>
                </div>
                <div class="form-group">
                    <label for="guests">Guests</label>
                    <select id="guests" name="guests">
                        <option value="1">1 Guest</option>
                        <option value="2" selected>2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                    </select>
                </div>
                <button type="submit" class="btn-reserve">Check Availability</button>
                <p class="booking-note">Free cancellation within 24 hours</p>
            </form>
        </div>
    </div>
</div>