<section class="cta">
    <div class="container">
        <h2>Ready to Experience Luxury?</h2>
        <p>Book your stay today and receive 20% off your first booking</p>
        <form class="cta-form" id="ctaForm">
            <input type="email" name="email" placeholder="Enter your email" required autocomplete="email" />
            <input type="hidden" name="action" value="ghb_save_cta_email">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('cta_nonce'); ?>">
            <button type="submit" class="btn-primary">Get Started</button>
        </form>
        <p class="cta-message" style="margin: 0; padding: 0; margin-top: 10px;"></p>
    </div>
</section>