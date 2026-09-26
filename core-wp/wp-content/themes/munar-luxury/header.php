<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-munar-cream text-munar-black antialiased selection:bg-munar-gold selection:text-white' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">

    <!-- Announcement Bar -->
    <div class="bg-munar-black text-munar-sand text-[11px] uppercase tracking-[0.25em] py-2 px-4 text-center border-b border-white/10 font-medium">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <span class="hidden md:inline-block text-[10px] text-munar-gold tracking-[0.3em]">Bespoke Atelier Nairobi</span>
            <div class="flex items-center space-x-2 mx-auto md:mx-0">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-munar-gold animate-pulse"></span>
                <span>Complimentary Delivery Nationwide on orders over KSh 15,000</span>
            </div>
            <span class="hidden md:inline-block text-[10px] text-munar-sand/70 tracking-[0.2em]">Lipa na M-Pesa Verified</span>
        </div>
    </div>

    <!-- Main Luxury Navigation Header -->
    <header id="masthead" class="site-header sticky top-0 z-40 bg-munar-cream/90 backdrop-blur-md border-b border-munar-border/60 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Left: Brand Logo Lockup -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center space-x-3 group" aria-label="Munar - Quiet Luxe">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/munar-logo-circle-transparent.png' ); ?>" 
                             alt="Munar - Quiet Luxe" 
                             class="h-11 w-11 sm:h-13 sm:w-13 object-contain rounded-full transition-transform duration-300 group-hover:scale-105 shadow-sm" />
                        <div class="flex flex-col items-start leading-none">
                            <span class="font-editorial text-2xl sm:text-3xl font-semibold tracking-[0.14em] text-munar-mocha group-hover:text-munar-gold transition-colors duration-300">
                                MUNAR
                            </span>
                            <span class="text-[7.5px] sm:text-[8.5px] uppercase tracking-[0.24em] font-bold text-munar-mocha/80 group-hover:text-munar-gold transition-colors self-end mt-0.5 pr-0.5">
                                QUIET, LUXE
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Center: Curated Navigation Links & Dropdowns -->
                <nav class="hidden lg:flex items-center space-x-8 font-sans text-xs uppercase tracking-[0.2em] font-medium text-munar-black">
                    
                    <!-- Collections Dropdown -->
                    <div class="relative group py-6">
                        <a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/') ); ?>" class="flex items-center space-x-1 hover:text-munar-gold transition-colors duration-200">
                            <span>Collections</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-60 group-hover:rotate-180 transition-transform duration-200"></i>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full w-64 bg-munar-cream border border-munar-border shadow-xl p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 rounded-sm">
                            <ul class="space-y-3 normal-case tracking-normal">
                                <li><a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? add_query_arg('orderby', 'date', wc_get_page_permalink('shop')) : home_url('/shop/') ); ?>" class="text-sm font-medium hover:text-munar-gold transition-colors flex items-center justify-between">New Arrivals <span class="text-[9px] uppercase tracking-wider bg-munar-gold/10 text-munar-gold px-1.5 py-0.5 rounded">Drop 04</span></a></li>
                                <li><a href="<?php echo esc_url( munar_get_cat_url('womens-atelier') ); ?>" class="text-sm text-munar-muted hover:text-munar-black transition-colors">Women's Atelier</a></li>
                                <li><a href="<?php echo esc_url( munar_get_cat_url('mens-sartorial') ); ?>" class="text-sm text-munar-muted hover:text-munar-black transition-colors">Men's Sartorial</a></li>
                                <li><a href="<?php echo esc_url( munar_get_cat_url('leather-goods') ); ?>" class="text-sm text-munar-muted hover:text-munar-black transition-colors">Haute Leather Goods</a></li>
                                <li><a href="<?php echo esc_url( munar_get_cat_url('fine-jewelry') ); ?>" class="text-sm text-munar-muted hover:text-munar-black transition-colors">Fine Jewelry & Timepieces</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Apparel -->
                    <a href="<?php echo esc_url( munar_get_cat_url('womens-atelier') ); ?>" class="hover:text-munar-gold transition-colors duration-200">Women's Wear</a>
                    <a href="<?php echo esc_url( munar_get_cat_url('mens-sartorial') ); ?>" class="hover:text-munar-gold transition-colors duration-200">Men's Sartorial</a>
                    <a href="<?php echo esc_url( munar_get_cat_url('leather-goods') ); ?>" class="hover:text-munar-gold transition-colors duration-200">Leather Bags</a>
                    <a href="<?php echo esc_url( munar_get_cat_url('fine-jewelry') ); ?>" class="hover:text-munar-gold transition-colors duration-200">Jewelry</a>
                    <a href="<?php echo esc_url( home_url('/#lookbook') ); ?>" class="hover:text-munar-gold transition-colors duration-200">Lookbook</a>
                </nav>

                <!-- Right: Action Cluster -->
                <div class="flex items-center space-x-5 sm:space-x-6 text-munar-black">
                    <!-- Search Trigger -->
                    <button id="search-modal-trigger" aria-label="Search Catalog" class="hover:text-munar-gold transition-colors">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>

                    <!-- Wishlist -->
                    <a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/') ); ?>" aria-label="Wishlist" class="hover:text-munar-gold transition-colors hidden sm:inline-block" title="Curated Atelier Catalog">
                        <i data-lucide="heart" class="w-5 h-5"></i>
                    </a>

                    <!-- Currency / Region Pill -->
                    <div class="hidden xl:flex items-center space-x-1.5 text-[11px] uppercase tracking-wider font-semibold border border-munar-border px-2.5 py-1 rounded-full bg-white/50 text-munar-dark">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>KES (KSh)</span>
                    </div>

                    <!-- Slide-over Mini Cart Drawer Trigger -->
                    <button id="cart-drawer-trigger" aria-label="Open Shopping Bag" class="relative hover:text-munar-gold transition-colors flex items-center">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span class="cart-count absolute -top-1.5 -right-1.5 bg-munar-gold text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                            <?php echo function_exists('WC') && WC()->cart ? esc_html( WC()->cart->get_cart_contents_count() ) : '0'; ?>
                        </span>
                    </button>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-trigger" aria-label="Open Menu" class="lg:hidden hover:text-munar-gold transition-colors">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Luxury Search Modal Overlay -->
    <div id="munar-search-modal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 flex items-start justify-center pt-24 px-4">
        <div class="bg-munar-cream w-full max-w-2xl border border-munar-border shadow-2xl p-8 rounded-sm transform -translate-y-4 transition-transform duration-300" id="munar-search-content">
            <div class="flex items-center justify-between pb-4 border-b border-munar-border">
                <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Search Munar Atelier</span>
                <button id="search-modal-close" class="p-1 text-munar-muted hover:text-munar-black transition-colors" aria-label="Close Search">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form role="search" method="get" class="mt-6 flex items-center gap-3" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="hidden" name="post_type" value="product" />
                <div class="relative flex-1">
                    <i data-lucide="search" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-munar-muted"></i>
                    <input type="search" name="s" id="munar-search-input" placeholder="Search silk gowns, linen blazers, leather bags..." class="w-full bg-white border border-munar-border pl-12 pr-4 py-3.5 text-sm text-munar-black placeholder:text-munar-muted/60 focus:outline-none focus:border-munar-gold" autocomplete="off" />
                </div>
                <button type="submit" class="btn-munar-gold py-3.5 px-6 text-xs">Search</button>
            </form>
            <div class="mt-4 flex items-center space-x-2 text-[11px] text-munar-muted">
                <span class="font-medium">Trending:</span>
                <a href="<?php echo esc_url( munar_get_cat_url('womens-atelier') ); ?>" class="hover:text-munar-gold underline">Silk Gowns</a>
                <span>&bull;</span>
                <a href="<?php echo esc_url( munar_get_cat_url('mens-sartorial') ); ?>" class="hover:text-munar-gold underline">Wool Blazers</a>
                <span>&bull;</span>
                <a href="<?php echo esc_url( munar_get_cat_url('leather-goods') ); ?>" class="hover:text-munar-gold underline">Calfskin Totes</a>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-nav-drawer" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="absolute inset-y-0 left-0 max-w-xs w-full bg-munar-cream shadow-2xl p-6 flex flex-col justify-between transform -translate-x-full transition-transform duration-300" id="mobile-nav-content">
            <div>
                <div class="flex items-center justify-between pb-6 border-b border-munar-border">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center space-x-2.5">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/munar-logo-circle-transparent.png' ); ?>" 
                             alt="Munar - Quiet Luxe" 
                             class="h-10 w-10 object-contain rounded-full shadow-xs" />
                        <div class="flex flex-col items-start leading-none">
                            <span class="font-editorial text-xl font-semibold tracking-[0.14em] text-munar-mocha">MUNAR</span>
                            <span class="text-[7px] uppercase tracking-[0.22em] font-bold text-munar-mocha/80 self-end mt-0.5">QUIET, LUXE</span>
                        </div>
                    </a>
                    <button id="mobile-nav-close" class="p-1 hover:text-munar-gold">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                <nav class="mt-8 space-y-4 text-sm uppercase tracking-[0.2em] font-medium">
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="block py-1 hover:text-munar-gold">Home</a>
                    <a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/') ); ?>" class="block py-1 hover:text-munar-gold">All Collections</a>
                    <a href="<?php echo esc_url( munar_get_cat_url('womens-atelier') ); ?>" class="block py-1 hover:text-munar-gold">Women's Atelier</a>
                    <a href="<?php echo esc_url( munar_get_cat_url('mens-sartorial') ); ?>" class="block py-1 hover:text-munar-gold">Men's Sartorial</a>
                    <a href="<?php echo esc_url( munar_get_cat_url('leather-goods') ); ?>" class="block py-1 hover:text-munar-gold">Haute Leather Bags</a>
                    <a href="<?php echo esc_url( munar_get_cat_url('fine-jewelry') ); ?>" class="block py-1 hover:text-munar-gold">Fine Jewelry</a>
                    <a href="<?php echo esc_url( home_url('/#lookbook') ); ?>" class="block py-1 hover:text-munar-gold">Runway Lookbook</a>
                    <a href="<?php echo esc_url( home_url('/about/') ); ?>" class="block py-1 hover:text-munar-gold">Atelier Story</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="block py-1 hover:text-munar-gold">Atelier Contact</a>
                </nav>
            </div>
            <div class="pt-6 border-t border-munar-border space-y-3">
                <p class="text-xs uppercase tracking-widest text-munar-muted">Customer Atelier Support</p>
                <a href="https://wa.me/254700000000" target="_blank" class="flex items-center space-x-2 text-xs font-medium text-emerald-700 hover:underline">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Direct WhatsApp Atelier</span>
                </a>
            </div>
        </div>
    </div>
