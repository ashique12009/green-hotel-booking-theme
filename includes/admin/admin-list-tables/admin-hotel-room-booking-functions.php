<?php 
add_action('admin_menu', function () {
    add_menu_page(
        'Room Bookings',
        'Bookings',
        'manage_options',
        'room-bookings',
        'render_room_bookings_page',
        'dashicons-calendar-alt',
        26
    );
});

function render_room_bookings_page() {

    require_once get_stylesheet_directory() . '/includes/admin/admin-list-tables/admin-class-room-booking-list-table.php';

    $table = new Room_Bookings_List_Table();
    $table->prepare_items();

    echo '<div class="wrap">';
        echo '<h1>Room Bookings</h1>';

        echo '<form method="post">';
            $table->display();
        echo '</form>';

    echo '</div>';
}

// Handle status change action
add_action('admin_init', function () {
    if (
        isset($_GET['action'], $_GET['id'], $_GET['new_status']) &&
        $_GET['action'] === 'change_status' &&
        current_user_can('manage_options')
    ) {
        global $wpdb;

        $id = (int) $_GET['id'];
        $new_status = sanitize_text_field($_GET['new_status']);

        // Security nonce check
        if ( ! wp_verify_nonce($_GET['_wpnonce'], 'change_booking_status_' . $id) ) {
            wp_die('Security check failed');
        }

        // Only allow these values
        $allowed_statuses = ['confirmed', 'paid', 'cancelled'];

        if ( ! in_array($new_status, $allowed_statuses, true) ) {
            wp_die('Invalid status');
        }

        $table = $wpdb->prefix . 'room_bookings';

        $wpdb->update(
            $table,
            ['status' => $new_status],
            ['id' => $id],
            ['%s'],
            ['%d']
        );

        wp_redirect(admin_url('admin.php?page=room-bookings'));
        exit;
    }
});