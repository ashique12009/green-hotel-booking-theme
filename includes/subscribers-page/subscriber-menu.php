<?php 
add_action( 'admin_menu', 'ghb_add_subscriber_my_account_menu' );

function ghb_add_subscriber_my_account_menu() {

    // Logged in user দরকার
    if ( ! is_user_logged_in() ) {
        return;
    }

    $user = wp_get_current_user();

    // শুধু Subscriber role
    if ( ! in_array( 'subscriber', (array) $user->roles ) ) {
        return;
    }

    add_menu_page(
        'My Account',
        'My Account',
        'read',                    // Subscriber capability
        'subscriber-my-account',
        'ghb_subscriber_my_account_callback',
        'dashicons-admin-users',
        3
    );

    add_submenu_page(
        'subscriber-my-account',      // parent slug
        'My Bookings',
        'My Bookings',
        'read',
        'subscriber-my-bookings',
        'ghb_subscriber_my_bookings_page'
    );
}

function ghb_subscriber_my_account_callback() {

    $user = wp_get_current_user();
    ?>

    <div class="wrap">
        <h1>My Account</h1>

        <p>Welcome, <strong><?php echo esc_html( $user->display_name ); ?></strong> 👋</p>

        <hr>

        <h2>Account Details</h2>
        <ul>
            <li>Email: <?php echo esc_html( $user->user_email ); ?></li>
            <li>Username: <?php echo esc_html( $user->user_login ); ?></li>
            <li>Role: Subscriber</li>
        </ul>

        <hr>

        <h2>Actions</h2>
        <p>
            <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="button button-secondary">
                Logout
            </a>
        </p>
    </div>

    <?php
}

function ghb_subscriber_my_bookings_page() {

    if ( ! current_user_can( 'read' ) ) {
        wp_die( 'Unauthorized access' );
    }

    require_once get_stylesheet_directory() . '/includes/subscribers-page/subscriber-class-booking-list-table.php';

    $table = new GHB_My_Bookings_Table();
    $table->prepare_items();

    echo '<div class="wrap">';
        echo '<h1>Room Bookings</h1>';

        echo '<form method="post">';
            $table->display();
        echo '</form>';

    echo '</div>';
    ?>

    <?php
}