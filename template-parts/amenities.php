<section class="amenities" id="amenities">
    <div class="container">
        <div class="section-header">
            <h2>What We Offer</h2>
            <p>Everything you need for an unforgettable stay</p>
        </div>

        <div class="amenities-grid">
            <?php
            $amenities = new WP_Query([
                'post_type'      => 'amenity',
                'posts_per_page' => -1,
            ]);

            if ($amenities->have_posts()) :
                while ($amenities->have_posts()) : $amenities->the_post();
                    $icon = get_post_meta(get_the_ID(), 'amenity_icon', true);
                    ?>
                    <div class="amenity-item">
                        <span class="amenity-icon"><?php echo esc_html($icon); ?></span>
                        <span><?php the_title(); ?></span>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <button class="btn-secondary">
            View All Amenities
        </button>
    </div>
</section>