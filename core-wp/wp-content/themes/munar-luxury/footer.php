    <!-- Main Site Footer -->
    <footer id="colophon" class="site-footer bg-munar-black text-munar-cream pt-20 pb-12 border-t border-white/10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 pb-16 border-b border-white/10">
                
                <!-- Col 1 & 2: Brand Heritage & Newsletter -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="space-y-3">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center space-x-3.5 group inline-flex" aria-label="Munar - Quiet Luxe">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/munar-logo-circle-transparent.png' ); ?>" 
                                 alt="Munar - Quiet Luxe" 
                                 class="h-14 w-14 object-contain rounded-full border border-white/10 shadow-md" />
                            <div class="flex flex-col items-start leading-none">
                                <span class="font-editorial text-3xl sm:text-4xl tracking-[0.14em] text-munar-linen group-hover:text-munar-gold transition-colors">MUNAR</span>
                                <span class="text-[8.5px] uppercase tracking-[0.24em] font-bold text-munar-linen/80 group-hover:text-munar-gold self-end mt-1 pr-0.5 transition-colors">QUIET, LUXE</span>
                            </div>
                        </a>
                        <p class="text-xs uppercase tracking-[0.25em] text-munar-gold font-medium pt-1">Modern African Luxury Atelier</p>
                    </div>
                    <p class="text-sm text-munar-sand/70 font-light leading-relaxed max-w-sm">
                        Crafting timeless silhouettes and bespoke sartorial garments for the modern tastemaker. Hand-tailored in Nairobi with ethical heritage materials.
                    </p>
                    <div class="space-y-3 pt-2">
                        <p class="text-xs uppercase tracking-[0.2em] text-white font-medium">Join the Private Atelier Circle</p>
                        <div class="flex max-w-md">
                            <input type="email" placeholder="Enter your email address" class="bg-white/5 border border-white/20 px-4 py-3 text-xs text-white placeholder:text-white/40 focus:outline-none focus:border-munar-gold flex-1 transition-colors">
                            <button class="btn-munar-gold text-xs px-6">Subscribe</button>
                        </div>
                    </div>
                </div>

                <!-- Col 3: Atelier Collections -->
                <div class="space-y-4">
                    <h4 class="text-xs uppercase tracking-[0.25em] text-munar-gold font-semibold">Collections</h4>
                    <ul class="space-y-2.5 text-xs text-munar-sand/80 font-light tracking-wide">
                        <li><a href="<?php echo esc_url( munar_get_cat_url('womens-atelier') ); ?>" class="hover:text-white transition-colors">Women's Haute Couture</a></li>
                        <li><a href="<?php echo esc_url( munar_get_cat_url('mens-sartorial') ); ?>" class="hover:text-white transition-colors">Men's Sartorial Line</a></li>
                        <li><a href="<?php echo esc_url( munar_get_cat_url('leather-goods') ); ?>" class="hover:text-white transition-colors">Handcrafted Leather Bags</a></li>
                        <li><a href="<?php echo esc_url( munar_get_cat_url('fine-jewelry') ); ?>" class="hover:text-white transition-colors">Fine Jewelry & Timepieces</a></li>
                        <li><a href="<?php echo esc_url( home_url('/#lookbook') ); ?>" class="hover:text-white transition-colors">Runway Lookbook 2026</a></li>
                    </ul>
                </div>

                <!-- Col 4: Client Care & Services -->
                <div class="space-y-4">
                    <h4 class="text-xs uppercase tracking-[0.25em] text-munar-gold font-semibold">Client Care</h4>
                    <ul class="space-y-2.5 text-xs text-munar-sand/80 font-light tracking-wide">
                        <li><a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="hover:text-white transition-colors">Bespoke Fitting Booking</a></li>
                        <li><a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="hover:text-white transition-colors">Shipping & Concierge Courier</a></li>
                        <li><a href="<?php echo esc_url( function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/') ); ?>" class="hover:text-white transition-colors">Lipa na M-Pesa & Security</a></li>
                        <li><a href="<?php echo esc_url( home_url('/about/') ); ?>" class="hover:text-white transition-colors">Atelier Heritage & Care</a></li>
                        <li><button type="button" id="track-order-footer-btn" class="hover:text-white transition-colors text-left">Track Order (#MNR-...)</button></li>
                    </ul>
                </div>

                <!-- Col 5: Atelier Location -->
                <div class="space-y-4">
                    <h4 class="text-xs uppercase tracking-[0.25em] text-munar-gold font-semibold">Flagship Atelier</h4>
                    <p class="text-xs text-munar-sand/80 font-light leading-relaxed">
                        Westlands Commercial Precinct<br>
                        Nairobi, Kenya<br>
                        Private viewing by appointment.
                    </p>
                    <div class="pt-2 text-xs space-y-1">
                        <p class="text-munar-sand/60">Concierge Desk:</p>
                        <p class="text-white font-medium">+254 (0) 700 000 000</p>
                        <p class="text-munar-sand/60 pt-1">Email:</p>
                        <p class="text-white font-medium">concierge@munar.ke</p>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom Bar -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-munar-sand/50 gap-4">
                <p>&copy; <?php echo esc_html( date('Y') ); ?> MUNAR Luxury Atelier. All rights reserved. Registered in Kenya.</p>
                <div class="flex items-center space-x-6">
                    <span class="text-[11px] uppercase tracking-wider text-munar-sand/40">Secure Payments via:</span>
                    <span class="font-bold text-emerald-400 tracking-wider">LIPA NA M-PESA</span>
                    <span>&bull;</span>
                    <span class="font-semibold text-white">VISA</span>
                    <span>&bull;</span>
                    <span class="font-semibold text-white">MASTERCARD</span>
                </div>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<!-- Slide-over Mini Cart Drawer -->
<div id="munar-cart-drawer" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="absolute inset-y-0 right-0 max-w-md w-full bg-munar-cream shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300" id="munar-cart-content">
        <!-- Drawer Header -->
        <div class="p-6 border-b border-munar-border flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i data-lucide="shopping-bag" class="w-5 h-5 text-munar-black"></i>
                <h3 class="font-editorial text-2xl text-munar-black font-light tracking-wide">Your Shopping Bag</h3>
            </div>
            <button id="cart-drawer-close" class="p-1.5 hover:text-munar-gold transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Free Delivery Progress Meter -->
        <div class="bg-munar-sand px-6 py-3 border-b border-munar-border text-xs">
            <div class="flex items-center justify-between text-[11px] uppercase tracking-wider text-munar-muted mb-1.5">
                <span>Free Express Delivery (KSh 15,000)</span>
                <span class="font-semibold text-munar-black" id="free-shipping-status">Eligible</span>
            </div>
            <div class="w-full bg-munar-border h-1.5 rounded-full overflow-hidden">
                <div class="bg-munar-gold h-full rounded-full transition-all duration-500 w-full"></div>
            </div>
        </div>

        <!-- Cart Items Container (Populated via WooCommerce fragments) -->
        <div id="munar-cart-drawer-items" class="p-6 space-y-4 overflow-y-auto max-h-[calc(100vh-260px)] flex-1">
            <?php if ( function_exists('WC') && WC()->cart && ! WC()->cart->is_empty() ) : ?>
                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : 
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
                ?>
                    <div class="flex items-center space-x-4 pb-4 border-b border-munar-border/60">
                        <div class="w-16 h-20 bg-munar-sand flex-shrink-0 overflow-hidden">
                            <?php echo $_product->get_image( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-serif text-base text-munar-black truncate"><?php echo esc_html( $_product->get_name() ); ?></h4>
                            <p class="text-xs text-munar-muted">Qty: <?php echo esc_html( $cart_item['quantity'] ); ?></p>
                            <p class="text-xs font-semibold text-munar-black mt-1"><?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?></p>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
            <?php else : ?>
                <div class="text-center py-16 text-munar-muted">
                    <i data-lucide="shopping-bag" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
                    <p class="font-editorial text-2xl text-munar-black mb-1">Your bag is empty</p>
                    <p class="text-xs uppercase tracking-widest text-munar-muted mb-6">Explore our curated runway pieces</p>
                    <a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink( 'shop' ) : home_url('/') ); ?>" class="btn-munar-primary text-xs">Explore Shop</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Drawer Footer with Subtotal & Checkout -->
        <div class="p-6 border-t border-munar-border bg-white/50 space-y-4">
            <div class="flex items-center justify-between text-sm">
                <span class="uppercase tracking-widest text-xs text-munar-muted">Subtotal</span>
                <span class="font-semibold text-lg text-munar-black" id="munar-cart-subtotal">
                    <?php echo function_exists('WC') && WC()->cart ? WC()->cart->get_cart_subtotal() : 'KSh 0.00'; ?>
                </span>
            </div>
            <div class="space-y-2">
                <a href="<?php echo esc_url( function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '#' ); ?>" class="w-full btn-munar-primary text-center block">
                    Proceed to Lipa na M-Pesa Checkout
                </a>
                <a href="<?php echo esc_url( function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#' ); ?>" class="w-full text-center block text-xs uppercase tracking-widest text-munar-muted hover:text-munar-black pt-1">
                    View Full Shopping Bag
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Floating VIP WhatsApp Button (Bottom Left) -->
<a href="https://wa.me/254700000000?text=Hello%20Munar%20Atelier,%20I%20would%20like%20to%20inquire%20about%20a%20luxury%20garment." target="_blank" aria-label="Direct WhatsApp Concierge" class="fixed bottom-6 left-6 z-40 bg-[#25D366] text-white p-3.5 rounded-full shadow-2xl hover:scale-110 transition-transform duration-300 flex items-center group">
    <i data-lucide="message-circle" class="w-6 h-6"></i>
    <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-300 ease-in-out text-xs font-semibold pl-0 group-hover:pl-2">
        VIP WhatsApp Care
    </span>
</a>

<!-- Floating AI Concierge Trigger (Bottom Right) -->
<button id="ai-concierge-trigger" aria-label="AI Shopping Concierge" class="fixed bottom-6 right-6 z-40 bg-munar-black text-white p-3.5 rounded-full shadow-2xl border border-munar-gold/40 hover:scale-110 transition-transform duration-300 flex items-center group">
    <i data-lucide="sparkles" class="w-6 h-6 text-munar-gold"></i>
    <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-300 ease-in-out text-xs font-semibold pl-0 group-hover:pl-2 text-munar-sand">
        AI Stylist Concierge
    </span>
</button>

<!-- AI Concierge Modal -->
<div id="ai-concierge-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
    <div class="bg-munar-cream max-w-lg w-full rounded-sm border border-munar-border shadow-2xl overflow-hidden flex flex-col h-[520px]">
        <div class="bg-munar-black p-4 text-white flex items-center justify-between border-b border-white/10">
            <div class="flex items-center space-x-3">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/munar-logo-circle-transparent.png' ); ?>" 
                     alt="Munar" 
                     class="h-9 w-9 object-contain rounded-full border border-munar-gold/30 shadow-xs" />
                <div>
                    <h4 class="font-editorial text-xl font-light">Munar AI Shopping Concierge</h4>
                    <p class="text-[10px] uppercase tracking-widest text-munar-gold">Styling &bull; Stock &bull; Order Tracking</p>
                </div>
            </div>
            <button id="ai-concierge-close" class="p-1 text-white/70 hover:text-white">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div id="ai-chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3 text-xs">
            <div class="bg-white p-3.5 rounded-sm border border-munar-border/60 max-w-[85%] text-munar-dark">
                <p class="font-medium text-munar-gold mb-1">Munar Concierge:</p>
                <p>Greetings! I am your personal Munar luxury concierge. I can assist you with sizing recommendations, outfit pairings for special events, checking garment availability, or tracking your order.</p>
            </div>
        </div>
        <div class="p-3 bg-white/70 border-t border-munar-border flex space-x-2">
            <input type="text" id="ai-chat-input" placeholder="Ask for styling advice, or type order #MNR-..." class="flex-1 bg-white border border-munar-border px-3.5 py-2 text-xs text-munar-black focus:outline-none focus:border-munar-gold">
            <button id="ai-chat-send" class="btn-munar-gold text-xs px-4 py-2">Ask</button>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
</body>
</html>
