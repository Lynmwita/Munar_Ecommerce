<?php
/**
 * The main template file
 *
 * @package Munar_Luxury
 */

get_header(); ?>

<main id="primary" class="site-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <?php if ( have_posts() ) : ?>
        <header class="page-header mb-12 text-center">
            <h1 class="font-editorial text-4xl text-munar-black font-light"><?php single_post_title(); ?></h1>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white border border-munar-border/60 p-6 flex flex-col justify-between' ); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="aspect-[16/10] overflow-hidden mb-4 bg-munar-sand">
                            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <span class="text-[10px] uppercase tracking-widest text-munar-gold"><?php echo esc_html( get_the_date() ); ?></span>
                        <h2 class="font-editorial text-2xl text-munar-black font-normal mt-1 mb-2">
                            <a href="<?php the_permalink(); ?>" class="hover:text-munar-gold transition-colors"><?php the_title(); ?></a>
                        </h2>
                        <div class="text-xs text-munar-muted font-light line-clamp-3">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-munar-border/40">
                        <a href="<?php the_permalink(); ?>" class="text-xs uppercase tracking-widest text-munar-black hover:text-munar-gold font-medium inline-flex items-center space-x-1">
                            <span>Read Story</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="mt-12 text-center">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <div class="text-center py-24 text-munar-muted">
            <h2 class="font-editorial text-3xl text-munar-black mb-2">No Content Found</h2>
            <p class="text-xs uppercase tracking-widest">Return to our homepage</p>
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-munar-primary text-xs mt-6">Return Home</a>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
