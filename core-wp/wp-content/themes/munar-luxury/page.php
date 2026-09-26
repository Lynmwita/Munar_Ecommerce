<?php
/**
 * The template for displaying all single posts and pages
 *
 * @package Munar_Luxury
 */

get_header(); ?>

<?php 
$is_wc_page = function_exists('is_cart') && (is_cart() || is_checkout() || is_account_page());
$container_class = $is_wc_page ? 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14' : 'max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16';
?>

<main id="primary" class="site-main <?php echo esc_attr( $container_class ); ?>">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'space-y-8' ); ?>>
            <?php if ( ! $is_wc_page ) : ?>
                <header class="entry-header text-center space-y-4">
                    <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Munar Atelier</span>
                    <h1 class="font-editorial text-4xl sm:text-5xl text-munar-black font-light leading-tight"><?php the_title(); ?></h1>
                    <?php if ( 'post' === get_post_type() ) : ?>
                        <div class="text-xs text-munar-muted uppercase tracking-widest flex items-center justify-center space-x-2">
                            <span>Published <?php echo esc_html( get_the_date() ); ?></span>
                            <span>&bull;</span>
                            <span>By <?php the_author(); ?></span>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="aspect-[16/9] overflow-hidden bg-munar-sand my-8">
                        <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="entry-content <?php echo $is_wc_page ? 'w-full' : 'prose prose-stone max-w-none text-sm sm:text-base leading-relaxed text-munar-dark/90 font-light space-y-4'; ?>">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
