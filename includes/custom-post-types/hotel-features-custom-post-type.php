<?php 
function ghb_register_features_cpt() {

    $labels = array(
        'name'               => 'Features',
        'singular_name'      => 'Feature',
        'add_new'            => 'Add New Feature',
        'add_new_item'       => 'Add New Feature',
        'edit_item'          => 'Edit Feature',
        'new_item'           => 'New Feature',
        'view_item'          => 'View Feature',
        'search_items'       => 'Search Features',
        'not_found'          => 'No Features found',
        'menu_name'          => 'Features'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ),
        'has_archive'        => false,
        'rewrite'            => array('slug' => 'features'),
        'show_in_rest'       => true
    );

    register_post_type('feature', $args);
}

add_action('init', 'ghb_register_features_cpt');
