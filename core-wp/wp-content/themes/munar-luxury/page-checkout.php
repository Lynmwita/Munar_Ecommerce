<?php
/**
 * Template Name: Munar Luxury Checkout Page
 * The template for displaying the bespoke WooCommerce checkout page
 *
 * @package Munar_Luxury
 */

get_header(); ?>

<main id="primary" class="site-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'space-y-6' ); ?>>
            <div class="entry-content w-full">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
