<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class() ;?>>
    <!-- Navigation -->
    <header class="header">
        <nav class="nav">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <span class="logo-icon">◈</span>
                <?php bloginfo('name'); ?>
            </a>

            <!-- Dynamic Menu -->
            <?php
            wp_nav_menu([
                'theme_location' => 'primary-header-menu',
                'container'      => false,
                'menu_class'     => 'nav-links',
                'fallback_cb'    => false,
            ]);
            ?>

            <div class="nav-actions">
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=subscriber-my-account' ) ); ?>" class="btn-text">
                        My Account
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="btn-text">
                        Login
                    </a>
                <?php endif; ?>

                <a href="<?php echo esc_url(site_url('/all-rooms')); ?>" class="btn-primary">Book Now</a>
            </div>

            <button class="mobile-menu-btn" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </header>
