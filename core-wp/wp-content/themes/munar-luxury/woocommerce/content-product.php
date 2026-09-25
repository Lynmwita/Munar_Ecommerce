<?php
/**
 * The template for displaying product content within loops
 *
 * @package Munar_Luxury
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class( 'group flex flex-col bg-white border border-munar-border/60 overflow-hidden transition-all duration-300 hover:shadow-lg list-none', $product ); ?>>
    
    <div class="relative aspect-[3/4] overflow-hidden bg-munar-sand">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full h-full">
            <?php echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105' ) ); ?>
        </a>

        <?php if ( $product->is_on_sale() ) : ?>
            <span class="absolute top-3 left-3 bg-munar-gold text-white text-[9px] uppercase tracking-widest px-2 py-0.5 font-semibold">Special Offer</span>
        <?php elseif ( $product->is_featured() ) : ?>
            <span class="absolute top-3 left-3 bg-munar-black text-white text-[9px] uppercase tracking-widest px-2 py-0.5 font-medium">Atelier Pick</span>
        <?php endif; ?>

        <button class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm hover:bg-white p-2 rounded-full text-munar-dark hover:text-red-600 transition-colors shadow-sm" aria-label="Add to Wishlist">
            <i data-lucide="heart" class="w-4 h-4"></i>
        </button>
    </div>

    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-munar-muted">
                <?php echo wc_get_product_category_list( $product->get_id(), ', ', '', '' ); ?>
            </div>
            <h3 class="font-editorial text-xl font-normal text-munar-black mt-0.5">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="hover:text-munar-gold transition-colors">
                    <?php echo esc_html( $product->get_name() ); ?>
                </a>
            </h3>
        </div>

        <div class="pt-2 border-t border-munar-border/40 flex items-center justify-between">
            <span class="font-sans font-semibold text-sm text-munar-black">
                <?php echo $product->get_price_html(); ?>
            </span>
            <span class="text-[10px] uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-medium">
                <?php echo $product->is_in_stock() ? 'In Atelier' : 'Bespoke Order'; ?>
            </span>
        </div>

        <div class="pt-1">
            <?php
            woocommerce_template_loop_add_to_cart( array(
                'class' => 'w-full btn-munar-primary text-[11px] py-2.5 text-center block'
            ) );
            ?>
        </div>
    </div>

</li>
