<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#" class="logo">
                <span class="logo-icon">◈</span>
                <?php echo get_bloginfo('name') ? get_bloginfo('name') : 'Your Hotel Name'; ?>
                </a>
                <p><?php echo get_bloginfo('description') ? get_bloginfo('description') : 'Experience the pinnacle of luxury hospitality at Your Hotel Name.'; ?></p>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-quick-links',
                        'container'      => false,
                        'menu_class'     => 'footer-links',
                        'fallback_cb'    => false,
                    ]);
                ?>
            </div>
            <div class="footer-links">
                <h4>Support</h4>
                <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-support-links',
                        'container'      => false,
                        'menu_class'     => 'footer-links',
                        'fallback_cb'    => false,
                    ]);
                ?>
            </div>
            <div class="footer-contact">
                <h4>Contact</h4>
                <p>123 Ocean Drive<br>Miami Beach, FL 33139</p>
                <p>+1 (555) 123-4567</p>
                <p>ashique12009@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Your Hotel Name Goes Here. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>