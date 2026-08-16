<?php
/**
 * The template for displaying all pages
 *
 * @package Green_Hotel_Booking
 */

get_header();
?>

<main id="primary" class="site-main container minh300 ptop100 pbot50">

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'your-text-domain' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>

            </article>

            <?php
        endwhile;
    endif;
    ?>

</main>

<?php
get_footer();