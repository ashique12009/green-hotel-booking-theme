<?php

add_action('wp_ajax_ghb_create_payment_intent', 'ghb_create_payment_intent');
add_action('wp_ajax_nopriv_ghb_create_payment_intent', 'ghb_create_payment_intent');

function ghb_create_payment_intent() {

    if ( ! isset($_POST['amount']) ) {
        wp_send_json_error('Invalid amount');
    }

    require_once get_stylesheet_directory() . '/assets/stripe-php-sdk/init.php'; // Stripe PHP SDK
    \Stripe\Stripe::setApiKey( STRIPE_SECRET_KEY );

    $amount = (int) $_POST['amount']; // cents

    try {
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'eur',
        ]);

        wp_send_json_success([
            'clientSecret' => $intent->client_secret
        ]);

    } catch ( Exception $e ) {
        wp_send_json_error( $e->getMessage() );
    }
}