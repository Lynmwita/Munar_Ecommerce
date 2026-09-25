<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @package Munar_Luxury
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Editorial Shop Header -->
    <header class="woocommerce-products-header text-center max-w-2xl mx-auto mb-14 space-y-3">
        <span class="text-xs uppercase tracking-[0.35em] text-munar-gold font-semibold">Ready-To-Wear &amp; Haute Pieces</span>
        <h1 class="woocommerce-products-header__title page-title font-editorial text-4xl sm:text-5xl font-light text-munar-black">
            <?php woocommerce_page_title(); ?>
        </h1>
        <div class="w-12 h-0.5 bg-munar-gold mx-auto"></div>
        <?php
        /**
         * Hook: woocommerce_archive_description.
         */
        do_action( 'woocommerce_archive_description' );
        ?>
    </header>

    <!-- Filter & Sort Bar -->
    <div class="flex flex-col sm:flex-row items-center justify-between pb-6 mb-8 border-b border-munar-border text-xs gap-4">
        <div class="text-munar-muted uppercase tracking-wider text-[11px]">
            <?php woocommerce_result_count(); ?>
        </div>
        <div class="flex items-center space-x-4">
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>

    <?php
    if ( woocommerce_product_loop() ) {

        woocommerce_product_loop_start();

        if ( wc_get_loop_prop( 'total' ) ) {
            while ( have_posts() ) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product' );
            }
        }

        woocommerce_product_loop_end();

        /**
         * Hook: woocommerce_after_shop_loop.
         */
        do_action( 'woocommerce_after_shop_loop' );
    } else {
        /**
         * Hook: woocommerce_no_products_found.
         */
        do_action( 'woocommerce_no_products_found' );
    }
    ?>

</div>

<?php
get_footer( 'shop' );
