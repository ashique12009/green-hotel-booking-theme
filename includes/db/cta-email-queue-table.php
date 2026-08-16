<?php
// Create Email Queue Table
function ghb_create_email_queue_table() {
    global $wpdb;

    $table = $wpdb->prefix . 'cta_email_queue';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message LONGTEXT NOT NULL,
        status ENUM('pending', 'processing', 'sent', 'failed') DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'ghb_create_email_queue_table');