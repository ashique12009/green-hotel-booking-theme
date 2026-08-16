<?php 
// Add Home Page Settings menu
function ghb_add_home_page_settings_menu() {
    add_menu_page(
        'Home Page Settings',
        'Home Page Settings',
        'manage_options',
        'home-page-settings',
        'ghb_home_page_settings_page',
        'dashicons-admin-home',
        20
    );
}
add_action( 'admin_menu', 'ghb_add_home_page_settings_menu' );

// Callback function to display the settings page
function ghb_home_page_settings_page() {

    // Save settings
    if ( isset($_POST['ghb_home_settings_nonce']) &&
         wp_verify_nonce($_POST['ghb_home_settings_nonce'], 'ghb_save_home_settings') ) {

        update_option(
            'ghb_hero_title',
            wp_kses_post($_POST['ghb_hero_title'])
        );

        update_option(
            'ghb_hero_subtitle',
            sanitize_textarea_field($_POST['ghb_hero_subtitle'])
        );

        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    $hero_title    = get_option('ghb_hero_title', 'Experience Luxury Like Never Before');
    $hero_subtitle = get_option('ghb_hero_subtitle', 'Discover the perfect blend of comfort, elegance, and world-class hospitality at Azure Haven Hotel');
    ?>

    <div class="wrap">
        <h1>Home Page Settings</h1>

        <form method="post">
            <?php wp_nonce_field('ghb_save_home_settings', 'ghb_home_settings_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="ghb_hero_title">Hero Title</label>
                    </th>
                    <td>
                        <textarea id="ghb_hero_title"
                                  name="ghb_hero_title"
                                  rows="4"
                                  class="large-text"><?php echo esc_textarea($hero_title); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="ghb_hero_subtitle">Hero Subtitle</label>
                    </th>
                    <td>
                        <textarea id="ghb_hero_subtitle"
                                  name="ghb_hero_subtitle"
                                  rows="4"
                                  class="large-text"><?php echo esc_textarea($hero_subtitle); ?></textarea>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>

<?php
}