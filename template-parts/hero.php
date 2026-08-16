<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title"><?php echo nl2br( wp_kses_post( get_option('ghb_hero_title') ) ); ?></h1>
        <p class="hero-subtitle"><?php echo esc_html( get_option('ghb_hero_subtitle') ); ?></p>
    </div>

    <!-- Booking Form -->
    <div class="booking-card">
        <div class="booking-header">
            <span class="price-badge">Best Price Guarantee</span>
        </div>
        <form class="booking-form" method="get" action="<?php echo site_url('/available-rooms'); ?>">
            <div class="form-row">
                <div class="form-group">
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
</section>