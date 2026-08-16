<?php 

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class GHB_My_Bookings_Table extends WP_List_Table {

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
        return '<strong>' . esc_html($item->status) . '</strong>';
    }

    protected function column_created($item) {
        return esc_html($item->created_at);
    }

    public function prepare_items() {
        global $wpdb;

        $user  = wp_get_current_user();
        $email = $user->user_email;

        $table = $wpdb->prefix . 'room_bookings';

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        // Total items
        $total_items = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM $table WHERE customer_email = %s",
                $email
            )
        );

        // User specific bookings
        $data = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table
                 WHERE customer_email = %s
                 ORDER BY created_at DESC
                 LIMIT %d OFFSET %d",
                $email,
                $per_page,
                $offset
            )
        );

        $this->items = $data;

        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ] );

        $this->_column_headers = [$this->get_columns(), [], []];
    }

}