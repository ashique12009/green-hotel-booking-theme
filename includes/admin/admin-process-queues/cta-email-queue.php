<?php
// Queue email to subscribers when a new post is published
function ghb_queue_new_post_email($new_status, $old_status, $post) {

    // Only trigger when post is published
    if ($old_status === 'publish' || $new_status !== 'publish') {
        return;
    }

    if ($post->post_type !== 'post') {
        return;
    }

    // If already queued, skip
    if (get_post_meta($post->ID, '_ghb_email_queued', true)) {
        return;
    }

    // Mark post as queued
    add_post_meta($post->ID, '_ghb_email_queued', 1, true);

    global $wpdb;
    $subscribers = $wpdb->get_col(
        "SELECT email FROM {$wpdb->prefix}cta_emails"
    );

    if (empty($subscribers)) return;

    $subject = 'New Post Published: ' . get_the_title($post->ID);
    $message = "
        <h2>{$post->post_title}</h2>
        <p>A new post has been published on our website.</p>
        <p><a href='" . get_permalink($post->ID) . "'>Read the full post</a></p>
    ";

    // Put this emails into the Queue (no wp_mail will send here!)
    foreach ($subscribers as $email) {
        $wpdb->insert(
            $wpdb->prefix . 'cta_email_queue',
            [
                'email'   => $email,
                'subject' => $subject,
                'message' => $message,
                'status'  => 'pending'
            ]
        );
    }
}
add_action('transition_post_status', 'ghb_queue_new_post_email', 10, 3);

// Process Email Queue - Safe Version
function ghb_now_process_email_queue() {

    if (get_transient('ghb_email_cron_lock')) {
        return;
    }

    set_transient('ghb_email_cron_lock', 1, 5 * MINUTE_IN_SECONDS);

    global $wpdb;
    $table = $wpdb->prefix . 'cta_email_queue';

    $emails = $wpdb->get_results(
        "SELECT * FROM $table WHERE status='pending' ORDER BY id ASC LIMIT 50"
    );

    if (empty($emails)) {
        delete_transient('ghb_email_cron_lock');
        return;
    }

    $headers = ['Content-Type: text/html; charset=UTF-8'];

    foreach ($emails as $item) {

        // Mark processing
        $wpdb->update(
            $table,
            ['status' => 'processing'],
            ['id' => $item->id]
        );

        // Send email
        $sent = wp_mail($item->email, $item->subject, $item->message, $headers);

        // Update status
        $wpdb->update(
            $table,
            ['status' => $sent ? 'sent' : 'failed'],
            ['id' => $item->id]
        );
    }

    delete_transient('ghb_email_cron_lock');
}
add_action('ghb_process_email_queue', 'ghb_now_process_email_queue');

// Add custom cron schedule
add_filter('cron_schedules', function ($schedules) {
    $schedules['every_2_minute'] = [
        'interval' => 120,
        'display'  => 'Every 2 Minute'
    ];
    return $schedules;
});

// Schedule event
add_action('after_switch_theme', function () {
    if (!wp_next_scheduled('ghb_process_email_queue')) {
        wp_schedule_event(time() + 60, 'every_2_minute', 'ghb_process_email_queue');
    }
});