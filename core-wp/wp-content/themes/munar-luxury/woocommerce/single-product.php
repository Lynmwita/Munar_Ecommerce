<?php
/**
 * The Template for displaying all single products
 *
 * @package Munar_Luxury
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Breadcrumbs -->
    <div class="mb-8 text-xs text-munar-muted uppercase tracking-widest">
        <?php woocommerce_breadcrumb( array(
            'delimiter'   => ' <span class="opacity-40">&bull;</span> ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Atelier Home', 'breadcrumb', 'munar-luxury' ),
        ) ); ?>
    </div>

    <?php
    while ( have_posts() ) :
        the_post();

        wc_get_template_part( 'content', 'single-product' );

    endwhile; // end of the loop.
    ?>

</div>

<?php
get_footer( 'shop' );
