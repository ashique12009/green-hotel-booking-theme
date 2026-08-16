<?php 

function ghb_register_amenities_cpt() {
    register_post_type('amenity', [
        'labels' => [
            'name'          => 'Amenities',
            'singular_name' => 'Amenity',
        ],
        'public'        => true,
        'menu_icon'     => 'dashicons-star-filled',
        'supports'      => ['title', 'custom-fields'],
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'ghb_register_amenities_cpt');
