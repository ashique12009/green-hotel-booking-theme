<?php 

function ghb_create_booking_table() {
    global $wpdb;

    $table = $wpdb->prefix . 'room_bookings';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        room_id BIGINT UNSIGNED NOT NULL,
        checkin DATE NOT NULL,
        checkout DATE NOT NULL,
        qty INT NOT NULL DEFAULT 1,
        customer_name VARCHAR(190),
        customer_email VARCHAR(190),
        status VARCHAR(50) DEFAULT 'confirmed' COMMENT 'confirmed, paid, cancelled',
        paid_amount DECIMAL(10,2),
        currency VARCHAR(10),
        payment_status VARCHAR(20) COMMENT 'pending, paid, failed, refunded',
        payment_method VARCHAR(50) COMMENT 'paypal, stripe, cash',
        transaction_id VARCHAR(100),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY room_id (room_id)
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'ghb_create_booking_table');