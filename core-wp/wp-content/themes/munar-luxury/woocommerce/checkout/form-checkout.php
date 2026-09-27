<?php
/**
 * Munar Luxury Bespoke Checkout Template
 *
 * @package Munar_Luxury
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo '<div class="max-w-4xl mx-auto py-12 text-center text-sm text-munar-muted bg-white border border-munar-border p-8">';
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    echo '</div>';
    return;
}
?>

<div class="munar-luxury-checkout max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header & Breadcrumb -->
    <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
        <span class="text-xs uppercase tracking-[0.35em] text-munar-gold font-semibold">VIP Atelier Concierge</span>
        <h1 class="font-editorial text-3xl sm:text-5xl font-light text-munar-black">Bespoke Order Checkout</h1>
        <div class="w-12 h-0.5 bg-munar-gold mx-auto"></div>
        <p class="text-xs sm:text-sm text-munar-muted font-light pt-1">
            Complete your delivery destination to authorize instant Lipa na M-Pesa STK Push or VIP White-Glove Courier.
        </p>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

        <!-- Left Column: Customer & Delivery Details (7 cols) -->
        <div class="lg:col-span-7 space-y-8">
            
            <div class="bg-white p-6 sm:p-10 border border-munar-border/90 shadow-xs space-y-8">
                <?php if ( $checkout->get_checkout_fields() ) : ?>

                    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                    <div id="customer_details" class="space-y-8">
                        <!-- Step 1: Billing & Patron Identity -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 pb-3 border-b border-munar-border">
                                <span class="w-6 h-6 rounded-full bg-munar-black text-white text-[11px] font-semibold flex items-center justify-center">1</span>
                                <h2 class="font-editorial text-2xl text-munar-black font-light tracking-wide">Patron & Delivery Information</h2>
                            </div>
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        </div>

                        <!-- Step 2: Shipping Destination (if distinct) -->
                        <div class="space-y-4 pt-4 border-t border-munar-border/60">
                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                        </div>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                <?php endif; ?>
            </div>

            <!-- VIP Assistance Card -->
            <div class="p-6 bg-munar-sand/50 border border-munar-border/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <p class="text-xs uppercase tracking-wider font-semibold text-munar-black">Need assistance with size or fitting?</p>
                    <p class="text-xs text-munar-muted">Our master atelier stylists in Westlands are on standby.</p>
                </div>
                <a href="https://wa.me/254112855069" target="_blank" class="btn-munar-outline py-2 px-4 text-[10px] whitespace-nowrap bg-white">
                    WhatsApp Concierge
                </a>
            </div>

        </div>

        <!-- Right Column: Order Summary & Payment (5 cols, sticky) -->
        <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-6">
            
            <div class="bg-[#F9F6F0] p-6 sm:p-8 border border-[#E5E0D8] shadow-sm rounded-sm space-y-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-munar-border">
                    <div class="flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-full bg-munar-gold text-white text-[11px] font-semibold flex items-center justify-center">2</span>
                        <h3 id="order_review_heading" class="font-editorial text-2xl text-munar-black font-light">Your Order Summary</h3>
                    </div>
                    <span class="text-[10px] uppercase tracking-widest text-munar-muted">Haute Selection</span>
                </div>

                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

            </div>

            <!-- Security & Guarantee Badges -->
            <div class="p-5 bg-white border border-munar-border/80 space-y-3 text-xs">
                <div class="flex items-center space-x-2.5 text-munar-black font-semibold text-[11px] uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Safaricom Lipa na M-Pesa 256-Bit SSL Encrypted</span>
                </div>
                <div class="grid grid-cols-2 gap-3 pt-2 border-t border-munar-border/60 text-[11px] text-munar-muted">
                    <div class="flex items-center space-x-1.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-munar-gold flex-shrink-0"></i>
                        <span>100% Authentic Haute</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <i data-lucide="scissors" class="w-4 h-4 text-munar-gold flex-shrink-0"></i>
                        <span>Free Westlands Alterations</span>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
