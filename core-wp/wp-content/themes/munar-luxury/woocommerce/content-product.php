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
<li <?php wc_product_class( 'group flex flex-col bg-[#121212] border border-[rgba(197,168,128,0.2)] overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-[rgba(197,168,128,0.5)] hover:shadow-2xl list-none', $product ); ?>>
    
    <div class="relative aspect-[3/4] overflow-hidden bg-[#1a1a1a]">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full h-full">
            <?php 
            $hero_img = get_post_meta( $product->get_id(), '_munar_hero_image_url', true );
            if ( has_post_thumbnail( $product->get_id() ) ) {
                echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105' ) );
            } elseif ( ! empty( $hero_img ) ) {
                echo '<img src="' . esc_url( $hero_img ) . '" alt="' . esc_attr( $product->get_name() ) . '" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />';
            } else {
                echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105' ) );
            }
            ?>
        </a>

        <?php if ( $product->is_on_sale() ) : ?>
            <span class="absolute top-3 left-3 bg-[#C5A880] text-[#0D0D0D] text-[9px] uppercase tracking-widest px-2 py-0.5 font-bold">Special Offer</span>
        <?php elseif ( $product->is_featured() ) : ?>
            <span class="absolute top-3 left-3 bg-[#0D0D0D] text-[#F9F6F0] border border-[rgba(197,168,128,0.4)] text-[9px] uppercase tracking-widest px-2 py-0.5 font-medium">Atelier Pick</span>
        <?php endif; ?>

        <button class="absolute top-3 right-3 bg-black/60 backdrop-blur-sm hover:bg-black p-2 rounded-full text-[#F9F6F0] hover:text-[#C5A880] transition-colors shadow-sm wishlist-btn" aria-label="Add to Wishlist" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
            <i data-lucide="heart" class="w-4 h-4"></i>
        </button>
    </div>

    <div class="p-5 flex-1 flex flex-col justify-between space-y-3 bg-[#121212]">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-[#C5A880]/80">
                <?php echo wc_get_product_category_list( $product->get_id(), ', ', '', '' ); ?>
            </div>
            <h3 class="font-editorial text-xl font-normal text-[#F9F6F0] mt-0.5">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="hover:text-[#C5A880] transition-colors">
                    <?php echo esc_html( $product->get_name() ); ?>
                </a>
            </h3>
        </div>

        <div class="pt-2 border-t border-[rgba(197,168,128,0.15)] flex items-center justify-between">
            <span class="font-sans font-semibold text-sm text-[#C5A880]">
                <?php echo $product->get_price_html(); ?>
            </span>
            <span class="text-[10px] uppercase tracking-wider text-emerald-400 bg-emerald-950/60 border border-emerald-800/40 px-2 py-0.5 rounded font-medium">
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
