<?php 
// Create CTA Newsletter Table
function ghb_create_cta_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'cta_emails';

    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_setup_theme', 'ghb_create_cta_table');