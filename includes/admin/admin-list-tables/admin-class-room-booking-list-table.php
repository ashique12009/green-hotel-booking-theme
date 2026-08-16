<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Room_Bookings_List_Table extends WP_List_Table {

    public function get_columns() {
        return [
            'cb'       => '<input type="checkbox" />',
            'id'       => 'ID',
            'room'     => 'Room',
            'customer' => 'Customer',
            'dates'    => 'Dates',
            'status'   => 'Status',
            'created'  => 'Created'
        ];
    }

    protected function column_cb($item) {
        return '<input type="checkbox" name="booking_id[]" value="' . esc_attr($item->id) . '">';
    }

    protected function column_id($item) {
        return esc_html($item->id);
    }

    protected function column_room($item) {
        return get_the_title($item->room_id);
    }

    protected function column_customer($item) {
        return esc_html($item->customer_name) . '<br><small>' . esc_html($item->customer_email) . '</small>';
    }

    protected function column_dates($item) {
        return esc_html($item->checkin) . ' → ' . esc_html($item->checkout);
    }

    protected function column_status($item) {
        $base_url = admin_url('admin.php?page=room-bookings&action=change_status&id=' . $item->id);

        $confirmed_url = wp_nonce_url($base_url . '&new_status=confirmed', 'change_booking_status_' . $item->id);
        $paid_url      = wp_nonce_url($base_url . '&new_status=paid', 'change_booking_status_' . $item->id);
        $cancel_url    = wp_nonce_url($base_url . '&new_status=cancelled', 'change_booking_status_' . $item->id);

        return '<strong>' . esc_html($item->status) . '</strong><br>
            <a href="' . esc_url($confirmed_url) . '" style="color:#0073aa;">Confirmed</a> | 
            <a href="' . esc_url($paid_url) . '" style="color:green;">Paid</a> | 
            <a href="' . esc_url($cancel_url) . '" style="color:red;">Cancelled</a>';
    }

    protected function column_created($item) {
        return esc_html($item->created_at);
    }

    public function prepare_items() {
        global $wpdb;

        $table = $wpdb->prefix . 'room_bookings';

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $total_items = (int) $wpdb->get_var(
            "SELECT COUNT(*) FROM {$table}"
        );

        $this->items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
                FROM {$table}
                ORDER BY created_at DESC
                LIMIT %d OFFSET %d",
                $per_page,
                $offset
            )
        );

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page),
        ]);

        $this->_column_headers = [$this->get_columns(), [], []];
    }

}