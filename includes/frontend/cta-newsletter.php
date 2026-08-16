<?php
// Function to insert email into the CTA Newsletter Table
function ghb_save_cta_email() {

    check_ajax_referer('cta_nonce', 'nonce');

    if ( empty($_POST['email']) || ! is_email($_POST['email']) ) {
        wp_send_json_error('Invalid email');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'cta_emails';

    $email = sanitize_email($_POST['email']);

    // Check duplicate
    $exists = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id FROM $table WHERE email = %s",
            $email
        )
    );

    if ( $exists ) {
        wp_send_json_error('This email is already subscribed.');
    }

    $wpdb->insert($table, [
        'email' => $email,
    ]);

    // Optional: notify admin
    $to = get_option('admin_email');
    $subject = 'New CTA Signup';

    $message = ghb_get_email_template('cta-admin-email-notification', [
        'email' => $email,
    ]);

    $headers = array(
        'Content-Type: text/html; charset=UTF-8'
    );

    wp_mail($to, $subject, $message, $headers);

    wp_send_json_success('Thank you for subscribing!');
}

add_action('wp_ajax_ghb_save_cta_email', 'ghb_save_cta_email');
add_action('wp_ajax_nopriv_ghb_save_cta_email', 'ghb_save_cta_email');

// CTA newsletter admin email settings
// Looking to send emails in production? Check out our Email API/SMTP product!
function ghb_mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = '8c47d5a7abace5';
    $phpmailer->Password = '7b69ef42c5e37e';
}

add_action('phpmailer_init', 'ghb_mailtrap');