<?php 

function ghb_register_guest_exp_cpt() {
    register_post_type('guest-exp', [
        'labels' => [
            'name'          => 'Guest Experiences',
            'singular_name' => 'Guest Experience',
        ],
        'public'        => true,
        'menu_icon'     => 'dashicons-testimonial',
        'supports'      => ['title', 'thumbnail'],
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'ghb_register_guest_exp_cpt');

function ghb_guest_exp_metabox() {
    add_meta_box(
        'guest_exp_details',
        'Guest Details',
        'ghb_guest_exp_metabox_callback',
        'guest-exp',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'ghb_guest_exp_metabox');

function ghb_guest_exp_metabox_callback($post) {
    ?>
    <p>
        <label>Stars (1–5)</label><br>
        <input type="number" name="guest_stars" min="1" max="5"
               value="<?php echo esc_attr(get_post_meta($post->ID, 'guest_stars', true)); ?>">
    </p>

    <p>
        <label>Review Text</label><br>
        <textarea name="guest_review" rows="4" style="width:100%;"><?php
            echo esc_textarea(get_post_meta($post->ID, 'guest_review', true));
        ?></textarea>
    </p>

    <p>
        <label>Guest Location</label><br>
        <input type="text" name="guest_location"
               value="<?php echo esc_attr(get_post_meta($post->ID, 'guest_location', true)); ?>">
    </p>

    <p>
        <label>Guest Image URL</label><br>
        <input type="text" name="guest_image"
               value="<?php echo esc_attr(get_post_meta($post->ID, 'guest_image', true)); ?>">
    </p>
    <?php
}

function ghb_save_guest_exp_meta($post_id) {

    if (isset($_POST['guest_stars'])) {
        update_post_meta($post_id, 'guest_stars', sanitize_text_field($_POST['guest_stars']));
    }

    if (isset($_POST['guest_review'])) {
        update_post_meta($post_id, 'guest_review', sanitize_textarea_field($_POST['guest_review']));
    }

    if (isset($_POST['guest_location'])) {
        update_post_meta($post_id, 'guest_location', sanitize_text_field($_POST['guest_location']));
    }

    if (isset($_POST['guest_image'])) {
        update_post_meta($post_id, 'guest_image', esc_url_raw($_POST['guest_image']));
    }
}
add_action('save_post', 'ghb_save_guest_exp_meta');