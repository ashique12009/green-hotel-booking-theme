<section class="features">
    <div class="container">
        <div class="features-grid">

            <?php
            $features = new WP_Query(array(
                'post_type'      => 'feature',
                'posts_per_page' => 3
            ));

            if ($features->have_posts()) :
                while ($features->have_posts()) : $features->the_post();
            ?>

                <div class="feature-card">
                    <div class="feature-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                    </div>

                    <h3><?php the_title(); ?></h3>
                    <p><?php the_excerpt(); ?></p>
                </div>

            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>

        </div>
    </div>
</section>