<?php
/*
Template Name: Checkout
*/

get_header();
global $wpdb;

/* -----------------------------
 * 0. Logged in user
 * ----------------------------- */
$current_user = is_user_logged_in() ? wp_get_current_user() : null;

/* -----------------------------
 * 1. Validate URL params
 * ----------------------------- */
$room_id  = isset($_GET['room_id']) ? (int) $_GET['room_id'] : 0;
$checkin  = isset($_GET['checkin']) ? sanitize_text_field($_GET['checkin']) : '';
$checkout = isset($_GET['checkout']) ? sanitize_text_field($_GET['checkout']) : '';
$guests   = isset($_GET['guests']) ? (int) $_GET['guests'] : 1;

if ( ! $room_id || ! $checkin || ! $checkout ) {
    echo '<div class="booking-error-wrapper">';
    echo '<p>Invalid booking request.</p>';
    echo '</div>';
    get_footer();
    return;
}

/* -----------------------------
 * 2. Load room
 * ----------------------------- */
$room = get_post($room_id);

if ( ! $room || $room->post_type !== 'room' ) {
    echo '<div class="booking-error-wrapper">';
    echo '<p>Room not found.</p>';
    echo '</div>';
    get_footer();
    return;
}

$price_per_night = (float) get_post_meta($room_id, '_room_new_price', true);

/* -----------------------------
 * 3. Calculate nights & price
 * ----------------------------- */
$checkin_date  = new DateTime($checkin);
$checkout_date = new DateTime($checkout);
$nights        = $checkin_date->diff($checkout_date)->days;

if ( $nights <= 0 ) {
    echo '<div class="booking-error-wrapper">';
    echo '<p>Invalid date selection.</p>';
    echo '</div>';
    get_footer();
    return;
}

$total_price = $nights * $price_per_night;

/* ---------------------------------
 * 4. Availability re-check
 * --------------------------------- */
if ( ! ghb_is_room_available($room_id, $checkin, $checkout) ) {
    echo '<div class="booking-error-wrapper">';
    echo '<p>Sorry, this room is no longer available.</p>';
    echo '</div>';
    get_footer();
    return;
}

/* -----------------------------
 * 4. Handle booking submit
 * ----------------------------- */
if ( isset($_POST['confirm_booking']) ) {

    check_admin_referer('confirm_booking_nonce');

    $name  = sanitize_text_field($_POST['customer_name']);
    $email = sanitize_email($_POST['customer_email']);
    $payment_intent = sanitize_text_field($_POST['payment_intent_id']);

    if ( empty($name) || empty($email) || empty($payment_intent) ) {
        echo '<div class="booking-error-wrapper">';
        echo '<p>Missing required data.</p>';
        echo '</div>';
    } else {
        $data = [
            'room_id'        => $room_id,
            'checkin'        => $checkin,
            'checkout'       => $checkout,
            'qty'            => 1,
            'customer_name'  => $name,
            'customer_email' => $email,
            'status'         => 'confirmed',
            'paid_amount'    => $total_price,
            'currency'       => 'EUR',
            'payment_status' => 'paid',
            'payment_method' => 'stripe_test',
            'transaction_id' => $payment_intent,
        ];

        ghb_insert_booking($data);

        // Send booking confirmation email
        $email_subject = 'Booking Confirmation';
        $email_message = ghb_get_email_template('booking-confirmation', [
            'name'       => $name,
            'room_title' => $room->post_title,
            'checkin'    => $checkin,
            'checkout'   => $checkout,
            'nights'     => $nights,
            'total_price'=> $total_price,
        ]);
        ghb_insert_booking_confirmation_into_queue($email, $email_subject, $email_message);

        echo '<div class="booking-confirmation-wrapper">';
        echo '<h2>✅ Booking Confirmed</h2>';
        echo '<p>Your payment was successful.</p>';
        echo '</div>';
        get_footer();
        return;
    }
}
?>

<section class="checkout-section ptop100 pbot50 minh300">
<div class="container">

<h1>Checkout</h1>

<h3><?php echo esc_html($room->post_title); ?></h3>
<p>Check-in: <?php echo esc_html($checkin); ?></p>
<p>Check-out: <?php echo esc_html($checkout); ?></p>
<p>Nights: <?php echo esc_html($nights); ?></p>
<p><strong>Total: €<?php echo esc_html($total_price); ?></strong></p>

<hr>

<form method="post" id="checkout-form" class="checkout-form">
    <?php wp_nonce_field('confirm_booking_nonce'); ?>

    <p>
        <label>Name *</label>
        <input type="text" name="customer_name" required
        value="<?php echo $current_user ? esc_attr($current_user->display_name) : ''; ?>">
    </p>

    <p>
        <label>Email *</label>
        <input type="email" name="customer_email" required
        value="<?php echo $current_user ? esc_attr($current_user->user_email) : ''; ?>">
    </p>

    <!-- Stripe Card UI -->
    <h3>Payment (Test Mode)</h3>
    <div id="card-element" style="max-width:400px;"></div>
    <div id="card-errors" style="color:red;margin-top:10px;"></div>

    <input type="hidden" name="payment_intent_id" id="payment_intent_id">

    <button type="button" id="pay-now" class="btn-confirm">
        Pay €<?php echo esc_html($total_price); ?>
    </button>

    <button type="submit" name="confirm_booking" id="final-submit" style="display:none;">
        Confirm Booking
    </button>
</form>

</div>
</section>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');

document.getElementById('pay-now').addEventListener('click', function () {
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({
            action: 'ghb_create_payment_intent',
            amount: '<?php echo (int)($total_price * 100); ?>'
        })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert('Payment initialization failed');
            return;
        }

        stripe.confirmCardPayment(data.data.clientSecret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: document.querySelector('[name="customer_name"]').value,
                    email: document.querySelector('[name="customer_email"]').value
                }
            }
        }).then(function(result) {
            if (result.error) {
                document.getElementById('card-errors').innerText = result.error.message;
            } else {
                document.getElementById('payment_intent_id').value = result.paymentIntent.id;
                document.getElementById('final-submit').click();
            }
        });
    });
});
</script>

<?php get_footer(); ?>