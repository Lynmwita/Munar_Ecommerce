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
<li <?php wc_product_class( 'group flex flex-col bg-white border border-munar-border/70 overflow-hidden transition-all duration-300 hover:shadow-xl hover:border-munar-gold/60 list-none rounded-none', $product ); ?>>
    
    <div class="relative aspect-[3/4.2] overflow-hidden bg-munar-sand/60">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full h-full overflow-hidden">
            <?php 
            $hero_img = get_post_meta( $product->get_id(), '_munar_hero_image_url', true );
            if ( has_post_thumbnail( $product->get_id() ) ) {
                echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-105' ) );
            } elseif ( ! empty( $hero_img ) ) {
                echo '<img src="' . esc_url( $hero_img ) . '" alt="' . esc_attr( $product->get_name() ) . '" class="w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-105" loading="lazy" />';
            } else {
                echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-105' ) );
            }
            ?>
        </a>

        <?php if ( $product->is_on_sale() ) : ?>
            <span class="absolute top-3 left-3 bg-munar-gold text-white text-[9px] uppercase tracking-widest px-2 py-0.5 font-semibold shadow-sm">Special Offer</span>
        <?php elseif ( $product->is_featured() ) : ?>
            <span class="absolute top-3 left-3 bg-munar-black text-white text-[9px] uppercase tracking-widest px-2 py-0.5 font-medium shadow-sm">Atelier Pick</span>
        <?php endif; ?>

        <button class="absolute top-3 right-3 bg-white/85 backdrop-blur-sm hover:bg-white p-2 rounded-full text-munar-dark hover:text-red-600 transition-colors shadow-sm wishlist-btn" aria-label="Add to Wishlist" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
            <i data-lucide="heart" class="w-3.5 h-3.5"></i>
        </button>
    </div>

    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3 bg-white">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-munar-muted">
                <?php echo wc_get_product_category_list( $product->get_id(), ', ', '', '' ); ?>
            </div>
            <h3 class="font-editorial text-lg sm:text-xl font-normal text-munar-black mt-1 leading-snug line-clamp-2">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="hover:text-munar-gold transition-colors">
                    <?php echo esc_html( $product->get_name() ); ?>
                </a>
            </h3>
        </div>

        <div class="pt-2 border-t border-munar-border/50 flex items-center justify-between gap-2">
            <span class="font-sans font-semibold text-sm text-munar-black whitespace-nowrap">
                <?php echo $product->get_price_html(); ?>
            </span>
            <span class="text-[9px] uppercase tracking-wider text-emerald-800 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-sm font-medium whitespace-nowrap">
                <?php echo $product->is_in_stock() ? 'In Atelier' : 'Bespoke Order'; ?>
            </span>
        </div>

        <div class="pt-1">
            <?php
            woocommerce_template_loop_add_to_cart( array(
                'class' => 'w-full btn-munar-primary text-[10px] sm:text-[11px] py-2.5 px-3 text-center block tracking-widest uppercase font-semibold'
            ) );
            ?>
        </div>
    </div>

</li>
