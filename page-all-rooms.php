<?php
/*
Template Name: All Rooms
*/
get_header();

/* -------------------------
 * 3. Query rooms by guests
 * ------------------------- */
$args = [
    'post_type'      => 'room',
    'posts_per_page' => -1,
];

$rooms = new WP_Query($args);
?>

<div class="available-rooms-wrapper">
    <section class="available-rooms-header ptop100 pbot50">
        <div class="container">
            <h1>Available Rooms</h1>

            <hr>

            <?php if ( $rooms->have_posts() ) : ?>

                <div class="rooms-grid mtop10">

                    <?php
                    while ( $rooms->have_posts() ) :
                        $rooms->the_post();

                        $room_id     = get_the_ID();
                        $new_price   = get_post_meta($room_id, '_room_new_price', true);
                        $old_price   = get_post_meta($room_id, '_room_old_price', true);
                        $room_size   = get_post_meta($room_id, '_room_details', true);

                        /* -------------------------
                        * 4. Availability check
                        * (temporary always true)
                        * ------------------------- */
                        $is_available = true; // later replace with real function

                        if ( ! $is_available ) {
                            continue;
                        }
                    ?>

                    <div class="room-card">
                        <h2><?php the_title(); ?></h2>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="room-image">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="room-content-inner">
                            <ul class="room-meta">
                                <?php if ($room_size) : ?>
                                    <li><strong>Room Size:</strong> <?php echo esc_html($room_size); ?></li>
                                <?php endif; ?>

                                <li><strong>Guests:</strong> Up to <?php echo esc_html(get_post_meta($room_id, '_room_max_guest_number', true)); ?></li>
                            </ul>

                            <div class="room-price">
                                <?php if ($old_price) : ?>
                                    <del><?php echo esc_html($old_price); ?></del>
                                <?php endif; ?>

                                <?php if ($new_price) : ?>
                                    <span><?php echo esc_html($new_price); ?> € / night</span>
                                <?php endif; ?>
                            </div>

                            <a class="btn-book mtop5 dib"
                                href="<?php echo esc_url(
                                    site_url('/checkout') .
                                    '?room_id=' . $room_id .
                                    '&checkin=' . $checkin .
                                    '&checkout=' . $checkout .
                                    '&guests=' . $guests
                                ); ?>">
                                Book Now
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p>No rooms available for your selected dates.</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php
wp_reset_postdata();
get_footer();