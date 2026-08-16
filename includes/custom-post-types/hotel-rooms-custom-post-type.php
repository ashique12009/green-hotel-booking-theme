<?php 

function ghb_register_rooms_cpt() {

    $labels = array(
        'name'               => 'Rooms',
        'singular_name'      => 'Room',
        'add_new'            => 'Add New Room',
        'add_new_item'       => 'Add New Room',
        'edit_item'          => 'Edit Room',
        'new_item'           => 'New Room',
        'view_item'          => 'View Room',
        'search_items'       => 'Search Rooms',
        'menu_name'          => 'Rooms'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array('title', 'thumbnail'),
        'has_archive'        => false,
        'rewrite'            => array('slug' => 'rooms'),
        'show_in_rest'       => true
    );

    register_post_type('room', $args);
}
add_action('init', 'ghb_register_rooms_cpt');

// Room detail
function ghb_room_custom_meta_boxes() {
    add_meta_box(
        'room_details',
        'Room Details',
        'ghb_room_meta_box_callback',
        'room',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'ghb_room_custom_meta_boxes');

function ghb_room_meta_box_callback($post) {

    $badge     = get_post_meta($post->ID, '_room_badge', true);
    $details   = get_post_meta($post->ID, '_room_details', true);
    $old_price = get_post_meta($post->ID, '_room_old_price', true);
    $new_price = get_post_meta($post->ID, '_room_new_price', true);
    $max_guest_number = get_post_meta($post->ID, '_room_max_guest_number', true);
    $total_room_number = get_post_meta($post->ID, '_room_total_room_number', true);
    ?>

    <p>
        <label><strong>Badge (Optional)</strong></label><br>
        <input type="text" name="room_badge" value="<?php echo esc_attr($badge); ?>" placeholder="Most Popular">
    </p>

    <p>
        <label><strong>Room Details</strong></label><br>
        <input type="text" name="room_details" value="<?php echo esc_attr($details); ?>" placeholder="45 sq m • King Bed • City View" style="width:100%;">
    </p>

    <p>
        <label><strong>Old Price ($)</strong></label><br>
        <input type="number" name="room_old_price" value="<?php echo esc_attr($old_price); ?>">
    </p>

    <p>
        <label><strong>New Price ($)</strong></label><br>
        <input type="number" name="room_new_price" value="<?php echo esc_attr($new_price); ?>">
    </p>

    <p>
        <label><strong>Max Guest Number</strong></label><br>
        <input type="number" name="room_max_guest_number" value="<?php echo esc_attr($max_guest_number); ?>">
    </p>

    <p>
        <label><strong>Total Room Number</strong></label><br>
        <input type="number" name="room_total_room_number" value="<?php echo esc_attr($total_room_number); ?>">
    </p>

    <?php
}

function ghb_save_room_meta_fields($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['room_badge'])) {
        update_post_meta($post_id, '_room_badge', sanitize_text_field($_POST['room_badge']));
    }

    if (isset($_POST['room_details'])) {
        update_post_meta($post_id, '_room_details', sanitize_text_field($_POST['room_details']));
    }

    if (isset($_POST['room_old_price'])) {
        update_post_meta($post_id, '_room_old_price', sanitize_text_field($_POST['room_old_price']));
    }

    if (isset($_POST['room_new_price'])) {
        update_post_meta($post_id, '_room_new_price', sanitize_text_field($_POST['room_new_price']));
    }

    if (isset($_POST['room_max_guest_number'])) {
        update_post_meta($post_id, '_room_max_guest_number', sanitize_text_field($_POST['room_max_guest_number']));
    }

    if (isset($_POST['room_total_room_number'])) {
        update_post_meta($post_id, '_room_total_room_number', sanitize_text_field($_POST['room_total_room_number']));
    }
}
add_action('save_post', 'ghb_save_room_meta_fields');
