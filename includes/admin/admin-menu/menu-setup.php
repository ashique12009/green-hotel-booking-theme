<?php 
// Menu register
function ghb_register_menus() {
    register_nav_menus([
        'primary-header-menu' => 'Primary Header Menu',
    ]);

    register_nav_menus([
        'footer-quick-links' => 'Footer Quick Links',
    ]);

    register_nav_menus([
        'footer-support-links' => 'Footer Support Links',
    ]);
}
add_action('after_setup_theme', 'ghb_register_menus');

// Menu items creation
function ghb_create_primary_menu_programmatically() {

    if ( ! wp_get_nav_menu_object('Primary Header Menu') ) {

        $menu_id = wp_create_nav_menu('Primary Header Menu');

        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => 'Home',
            'menu-item-url'    => home_url('/'),
            'menu-item-status' => 'publish'
        ]);

        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => 'Rooms',
            'menu-item-url'    => '#rooms',
            'menu-item-status' => 'publish'
        ]);

        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => 'Amenities',
            'menu-item-url'    => '#amenities',
            'menu-item-status' => 'publish'
        ]);

        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => 'Reviews',
            'menu-item-url'    => '#reviews',
            'menu-item-status' => 'publish'
        ]);

        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => 'Location',
            'menu-item-url'    => '#location',
            'menu-item-status' => 'publish'
        ]);

        // IMPORTANT: assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary-header-menu'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_setup_theme', 'ghb_create_primary_menu_programmatically');

// Footer quick link menu
function ghb_create_footer_quick_links_menu() {

    $menu_name = 'Footer Quick Links';

    // Check if menu already exists
    $menu = wp_get_nav_menu_object($menu_name);

    if ( ! $menu ) {
        // Create menu
        $menu_id = wp_create_nav_menu($menu_name);

        // Menu items
        $items = [
            ['About Us', '#about'],
            ['Rooms & Suites', '#rooms'],
            ['Dining', '#dining'],
            ['Spa & Wellness', '#spa'],
        ];

        foreach ($items as $item) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'  => $item[0],
                'menu-item-url'    => $item[1],
                'menu-item-status' => 'publish',
            ]);
        }

        // IMPORTANT: assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['footer-quick-links'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_setup_theme', 'ghb_create_footer_quick_links_menu');

// Footer support link menu
function ghb_create_footer_support_links_menu() {

    $menu_name = 'Footer Support Links';

    // Check if menu already exists
    $menu = wp_get_nav_menu_object($menu_name);

    if ( ! $menu ) {
        // Create menu
        $menu_id = wp_create_nav_menu($menu_name);

        // Menu items
        $items = [
            ['FAQs', '#faqs'],
            ['Contact Us', '#contact'],
            ['Privacy Policy', '#privacy'],
            ['Terms of Service', '#terms'],
        ];

        foreach ($items as $item) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'  => $item[0],
                'menu-item-url'    => $item[1],
                'menu-item-status' => 'publish',
            ]);
        }

        // IMPORTANT: assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['footer-support-links'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_setup_theme', 'ghb_create_footer_support_links_menu');