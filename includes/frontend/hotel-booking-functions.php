<?php 

function ghb_is_room_available($room_id, $checkin, $checkout) {
    global $wpdb;

    $table = $wpdb->prefix . 'room_bookings';

    // total rooms from CPT
    $total_rooms = (int) get_post_meta($room_id, '_room_total_room_number', true);

    // already booked rooms in date range
    $booked = (int) $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT COALESCE(SUM(qty), 0)
            FROM {$table}
            WHERE room_id = %d
            AND status IN ('confirmed', 'paid')
            AND checkin < %s
            AND checkout > %s
            ",
            $room_id,
            $checkout, // user input checkout date
            $checkin   // user input checkin date
        )
    );

    $booked = (int) $booked;

    return ($total_rooms > $booked);
}

function ghb_insert_booking($data) {
    global $wpdb;

    $table = $wpdb->prefix . 'room_bookings';

    $wpdb->insert(
        $table,
        [
            'room_id'       => $data['room_id'],
            'checkin'       => $data['checkin'],
            'checkout'      => $data['checkout'],
            'qty'           => $data['qty'],
            'customer_name' => $data['customer_name'],
            'customer_email'=> $data['customer_email'],
            'status'        => $data['status'],
            'paid_amount'   => $data['paid_amount'],
            'currency'      => $data['currency'],
            'payment_status'=> $data['payment_status'],
            'payment_method'=> $data['payment_method'],
            'transaction_id'=> $data['transaction_id'],
            'created_at'    => current_time('mysql')
        ],
        ['%d','%s','%s','%d','%s','%s','%s','%f','%s','%s','%s','%s','%s']
    );
}

function ghb_insert_booking_confirmation_into_queue($email, $subject, $message) {
    global $wpdb;

    $table = $wpdb->prefix . 'cta_email_queue';

    $wpdb->insert(
        $table,
        [
            'email'   => $email,
            'subject' => $subject,
            'message' => $message,
            'status'  => 'pending'
        ]
    );
}