<?php 
require_once 'includes/db/db-operations.php';
require_once 'includes/db/hotel-booking-table.php';
require_once 'includes/db/cta-newsletter-table.php';
require_once 'includes/db/cta-email-queue-table.php';

require_once 'includes/custom-post-types/hotel-features-custom-post-type.php';
require_once 'includes/custom-post-types/hotel-rooms-custom-post-type.php';
require_once 'includes/custom-post-types/hotel-amenities-custom-post-type.php';
require_once 'includes/custom-post-types/hotel-guest-exp-custom-post-type.php';

require_once 'includes/admin/admin-list-tables/admin-hotel-room-booking-functions.php';
require_once 'includes/admin/admin-settings/home-page/settings-menu.php';
require_once 'includes/admin/admin-menu/menu-setup.php';
require_once 'includes/admin/admin-process-queues/cta-email-queue.php';

require_once 'includes/frontend/hotel-booking-functions.php';
require_once 'includes/frontend/cta-newsletter.php';

require_once 'includes/subscribers-page/subscriber-menu.php';
require_once 'includes/stripe-payment-handle/stripe-payment.php';

add_theme_support('post-thumbnails');
add_theme_support('title-tag');

function ghb_assets() {
    wp_enqueue_style(
        'main-style',
        get_stylesheet_uri()
    );

    wp_enqueue_script(
        'menu-js',
        get_template_directory_uri() . '/assets/js/menu.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'cta-js',
        get_template_directory_uri() . '/assets/js/cta-newsletter.js',
        ['jquery'],
        null,
        true
    );

    wp_enqueue_script(
        'booking-modal-js',
        get_template_directory_uri() . '/assets/js/booking-modal.js',
        [],
        null,
        true
    );

    wp_localize_script(
        'cta-js',
        'ghbCta',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]
    );
}

add_action('wp_enqueue_scripts', 'ghb_assets');

function write_log( $data ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        $log_file = WP_CONTENT_DIR . '/debug.log';

        if ( is_array( $data ) || is_object( $data ) ) {
            error_log( print_r( $data, true ), 3, $log_file );
        } else {
            error_log( $data . PHP_EOL, 3, $log_file );
        }
    }
}

// Available rooms page template
function create_all_rooms_page() {

    $slug = 'all-rooms';

    // Check if page already exists
    if ( ! get_page_by_path( $slug ) ) {

        $page_id = wp_insert_post([
            'post_title'   => 'All Rooms',
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => ''
        ]);

        // Assign page template (optional but good practice)
        if ( $page_id && ! is_wp_error($page_id) ) {
            update_post_meta(
                $page_id,
                '_wp_page_template',
                'page-all-rooms.php'
            );
        }
    }
}
add_action('after_switch_theme', 'create_all_rooms_page');

// Available rooms page template
function create_available_rooms_page() {

    $slug = 'available-rooms';

    // Check if page already exists
    if ( ! get_page_by_path( $slug ) ) {

        $page_id = wp_insert_post([
            'post_title'   => 'Available Rooms',
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => ''
        ]);

        // Assign page template (optional but good practice)
        if ( $page_id && ! is_wp_error($page_id) ) {
            update_post_meta(
                $page_id,
                '_wp_page_template',
                'page-available-rooms.php'
            );
        }
    }
}
add_action('after_switch_theme', 'create_available_rooms_page');

// Checkout page template
function create_checkout_page() {

    $slug = 'checkout';

    // Check if page already exists
    if ( ! get_page_by_path( $slug ) ) {

        $page_id = wp_insert_post([
            'post_title'   => 'Checkout',
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => ''
        ]);

        // Assign page template (optional but good practice)
        if ( $page_id && ! is_wp_error($page_id) ) {
            update_post_meta(
                $page_id,
                '_wp_page_template',
                'page-checkout.php'
            );
        }
    }
}
add_action('after_switch_theme', 'create_checkout_page');

// Load email template
function ghb_get_email_template($template_name, $vars = []) {

    $template_path = get_stylesheet_directory() . '/includes/email-templates/' . $template_name . '.php';

    if ( ! file_exists($template_path) ) {
        return '';
    }

    extract($vars); // make variables available inside template

    ob_start();
    include $template_path;
    return ob_get_clean();
}