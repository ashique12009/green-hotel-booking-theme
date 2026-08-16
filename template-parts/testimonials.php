<section class="testimonials" id="reviews">
    <div class="container">
        <div class="section-header">
            <h2>Guest Experiences</h2>
            <p>What our guests say about their stay</p>
        </div>

        <div class="testimonials-grid">
            <?php
            $testimonials = new WP_Query([
                'post_type'      => 'guest-exp',
                'posts_per_page' => 3,
            ]);

            if ($testimonials->have_posts()) :
                while ($testimonials->have_posts()) : $testimonials->the_post();

                    $stars    = (int) get_post_meta(get_the_ID(), 'guest_stars', true);
                    $review   = get_post_meta(get_the_ID(), 'guest_review', true);
                    $location = get_post_meta(get_the_ID(), 'guest_location', true);
                    $image    = get_post_meta(get_the_ID(), 'guest_image', true);
                    ?>
                    <div class="testimonial-card">

                        <div class="stars">
                            <?php echo str_repeat('★', $stars); ?>
                        </div>

                        <p class="testimonial-text">
                            "<?php echo esc_html($review); ?>"
                        </p>

                        <div class="testimonial-author">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
                            <div>
                                <strong><?php the_title(); ?></strong>
                                <span><?php echo esc_html($location); ?></span>
                            </div>
                        </div>

                    </div>
                <?php endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>