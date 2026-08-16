<section class="rooms" id="rooms">
    <div class="container">
        <div class="section-header">
            <h2>Our Rooms & Suites</h2>
            <p>Choose your perfect retreat</p>
        </div>

        <div class="rooms-grid">

            <?php
            $rooms = new WP_Query(array(
                'post_type'      => 'room',
                'posts_per_page' => 3
            ));

            if ($rooms->have_posts()) :
                while ($rooms->have_posts()) : $rooms->the_post();

                $badge     = get_post_meta(get_the_ID(), '_room_badge', true);
                $details   = get_post_meta(get_the_ID(), '_room_details', true);
                $old_price = get_post_meta(get_the_ID(), '_room_old_price', true);
                $new_price = get_post_meta(get_the_ID(), '_room_new_price', true);
            ?>

            <div class="room-card">
                <div class="room-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                    <?php endif; ?>

                    <?php if ($badge) : ?>
                        <span class="room-badge"><?php echo esc_html($badge); ?></span>
                    <?php endif; ?>
                </div>

                <div class="room-content">
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo esc_html($details); ?></p>

                    <div class="room-footer">
                        <div class="room-price">
                            <?php if ($old_price) : ?>
                                <span class="price-old">$<?php echo esc_html($old_price); ?></span>
                            <?php endif; ?>

                            <span class="price-new">$<?php echo esc_html($new_price); ?></span>
                            <span class="price-unit">/night</span>
                        </div>

                        <button class="btn-book" data-room-id="<?php echo get_the_ID(); ?>">Book Now</button>
                    </div>
                </div>
            </div>

            <?php endwhile; wp_reset_postdata(); endif; ?>

        </div>
    </div>
</section>