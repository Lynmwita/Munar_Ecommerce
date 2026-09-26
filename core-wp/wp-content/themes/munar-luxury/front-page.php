<?php
/**
 * Template Name: Luxury Editorial Front Page
 *
 * @package Munar_Luxury
 */

get_header(); ?>

<main id="primary" class="site-main">

    <!-- 1. Hero Editorial Full-Bleed Slider -->
    <section class="relative w-full h-[85vh] sm:h-[90vh] bg-munar-black overflow-hidden">
        <div class="swiper munar-hero-swiper w-full h-full">
            <div class="swiper-wrapper">
                
                <!-- Slide 1: Haute Couture -->
                <div class="swiper-slide relative flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=2000&q=85" alt="Munar Haute Couture" class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.7]">
                    <div class="absolute inset-0 bg-gradient-to-t from-munar-black/80 via-transparent to-munar-black/30"></div>
                    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 text-white space-y-6">
                        <span class="inline-block text-xs uppercase tracking-[0.4em] text-munar-gold font-medium bg-black/40 backdrop-blur-md px-4 py-1.5 border border-munar-gold/30 rounded-full">
                            Collection 2026 &bull; Drop IV
                        </span>
                        <h1 class="font-editorial text-4xl sm:text-6xl md:text-7xl font-light tracking-[0.08em] leading-tight">
                            The Art of Modern African Elegance
                        </h1>
                        <p class="text-sm sm:text-base font-light text-munar-sand/90 max-w-xl mx-auto tracking-wide leading-relaxed">
                            Bespoke silhouettes, sculptural tailoring, and ethically sourced natural silk. Handcrafted in our Nairobi atelier.
                        </p>
                        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : '#' ); ?>" class="btn-munar-gold w-full sm:w-auto">
                                Explore New Arrivals
                            </a>
                            <a href="#lookbook" class="btn-munar-outline border-white text-white hover:bg-white hover:text-munar-black w-full sm:w-auto">
                                View Runway Lookbook
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Handcrafted Leather Bags -->
                <div class="swiper-slide relative flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=2000&q=85" alt="Haute Leather Bags" class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.65]">
                    <div class="absolute inset-0 bg-gradient-to-t from-munar-black/80 via-transparent to-munar-black/30"></div>
                    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 text-white space-y-6">
                        <span class="inline-block text-xs uppercase tracking-[0.4em] text-munar-gold font-medium bg-black/40 backdrop-blur-md px-4 py-1.5 border border-munar-gold/30 rounded-full">
                            Artisanal Leatherwork
                        </span>
                        <h2 class="font-editorial text-4xl sm:text-6xl md:text-7xl font-light tracking-[0.08em] leading-tight">
                            Sculptural Leather & Brass
                        </h2>
                        <p class="text-sm sm:text-base font-light text-munar-sand/90 max-w-xl mx-auto tracking-wide leading-relaxed">
                            Full-grain vegetable-tanned leather accented with custom cast brass hardware inspired by Kenyan heritage geometry.
                        </p>
                        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="<?php echo esc_url( munar_get_cat_url('leather-goods') ); ?>" class="btn-munar-gold w-full sm:w-auto">
                                Shop Leather Bags
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Men's Sartorial Line -->
                <div class="swiper-slide relative flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=2000&q=85" alt="Men's Sartorial Line" class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.7]">
                    <div class="absolute inset-0 bg-gradient-to-t from-munar-black/80 via-transparent to-munar-black/30"></div>
                    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 text-white space-y-6">
                        <span class="inline-block text-xs uppercase tracking-[0.4em] text-munar-gold font-medium bg-black/40 backdrop-blur-md px-4 py-1.5 border border-munar-gold/30 rounded-full">
                            Men's Sartorial Line
                        </span>
                        <h2 class="font-editorial text-4xl sm:text-6xl md:text-7xl font-light tracking-[0.08em] leading-tight">
                            Sharp Tailoring for the Modern Man
                        </h2>
                        <p class="text-sm sm:text-base font-light text-munar-sand/90 max-w-xl mx-auto tracking-wide leading-relaxed">
                            Unconstructed linen blazers, safari jackets, and precision-cut trousers built for equatorial distinction.
                        </p>
                        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="<?php echo esc_url( munar_get_cat_url('mens-sartorial') ); ?>" class="btn-munar-gold w-full sm:w-auto">
                                Discover Men's Collection
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Swiper Controls -->
            <div class="swiper-pagination !bottom-8"></div>
        </div>
    </section>

    <!-- 2. Curated Lookbook Category Stories (Visual Grid) -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-14 space-y-3">
            <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Atelier Departments</span>
            <h2 class="font-editorial text-3xl sm:text-4xl text-munar-black font-light tracking-wide">Curated Collections</h2>
            <div class="w-12 h-0.5 bg-munar-gold mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Category 1: Women's Atelier -->
            <a href="<?php echo esc_url( munar_get_cat_url('womens-atelier') ); ?>" class="group relative block aspect-[4/5] overflow-hidden bg-munar-dark">
                <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=900&q=80" alt="Women's Atelier" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 filter brightness-[0.85] group-hover:brightness-95">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-white">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-munar-gold mb-1">Couture</span>
                    <h3 class="font-editorial text-2xl font-light tracking-wide group-hover:translate-x-1 transition-transform">Women's Wear</h3>
                    <p class="text-xs text-munar-sand/70 font-light mt-1 flex items-center space-x-1">
                        <span>Explore Collection</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </p>
                </div>
            </a>

            <!-- Category 2: Men's Sartorial -->
            <a href="<?php echo esc_url( munar_get_cat_url('mens-sartorial') ); ?>" class="group relative block aspect-[4/5] overflow-hidden bg-munar-dark">
                <img src="https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=900&q=80" alt="Men's Sartorial" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 filter brightness-[0.85] group-hover:brightness-95">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-white">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-munar-gold mb-1">Tailoring</span>
                    <h3 class="font-editorial text-2xl font-light tracking-wide group-hover:translate-x-1 transition-transform">Men's Sartorial</h3>
                    <p class="text-xs text-munar-sand/70 font-light mt-1 flex items-center space-x-1">
                        <span>Explore Pieces</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </p>
                </div>
            </a>

            <!-- Category 3: Haute Leather Bags -->
            <a href="<?php echo esc_url( munar_get_cat_url('leather-goods') ); ?>" class="group relative block aspect-[4/5] overflow-hidden bg-munar-dark">
                <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=900&q=80" alt="Haute Leather Bags" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 filter brightness-[0.85] group-hover:brightness-95">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-white">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-munar-gold mb-1">Accessories</span>
                    <h3 class="font-editorial text-2xl font-light tracking-wide group-hover:translate-x-1 transition-transform">Haute Bags</h3>
                    <p class="text-xs text-munar-sand/70 font-light mt-1 flex items-center space-x-1">
                        <span>Explore Artifacts</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </p>
                </div>
            </a>

            <!-- Category 4: Fine Jewelry & Timepieces -->
            <a href="<?php echo esc_url( munar_get_cat_url('fine-jewelry') ); ?>" class="group relative block aspect-[4/5] overflow-hidden bg-munar-dark">
                <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=900&q=80" alt="Fine Jewelry & Timepieces" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 filter brightness-[0.85] group-hover:brightness-95">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-white">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-munar-gold mb-1">Haute Joaillerie</span>
                    <h3 class="font-editorial text-2xl font-light tracking-wide group-hover:translate-x-1 transition-transform">Fine Jewelry</h3>
                    <p class="text-xs text-munar-sand/70 font-light mt-1 flex items-center space-x-1">
                        <span>Explore Adornments</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </p>
                </div>
            </a>

        </div>
    </section>

    <!-- 3. Featured Runway Pieces (Dynamic Haute Couture Catalog) -->
    <section class="py-20 bg-munar-sand/40 border-y border-munar-border/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div class="space-y-2">
                    <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Haute Selection</span>
                    <h2 class="font-editorial text-3xl sm:text-4xl text-munar-black font-light tracking-wide">Featured Runway Pieces</h2>
                </div>
                <div class="flex items-center space-x-3 text-xs uppercase tracking-[0.2em]">
                    <a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/') ); ?>" class="btn-munar-outline py-2.5 px-5 text-[11px]">
                        View Entire Catalog
                    </a>
                </div>
            </div>

            <!-- Dynamic Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $featured_query = new WP_Query( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 8,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ) );

                if ( $featured_query->have_posts() ) :
                    while ( $featured_query->have_posts() ) :
                        $featured_query->the_post();
                        global $product;
                        ?>
                        <div class="group flex flex-col bg-white border border-munar-border/60 overflow-hidden transition-all duration-300 hover:shadow-lg">
                            <div class="relative aspect-[3/4] overflow-hidden bg-munar-sand">
                                <a href="<?php echo esc_url( get_permalink() ); ?>" class="block w-full h-full">
                                    <?php
                                    $hero_img = get_post_meta( get_the_ID(), '_munar_hero_image_url', true );
                                    if ( has_post_thumbnail() ) {
                                        the_post_thumbnail( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105' ) );
                                    } elseif ( ! empty( $hero_img ) ) {
                                        echo '<img src="' . esc_url( $hero_img ) . '" alt="' . esc_attr( get_the_title() ) . '" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />';
                                    } else {
                                        echo '<div class="w-full h-full flex items-center justify-center bg-munar-sand text-munar-muted"><i data-lucide="image" class="w-8 h-8 opacity-40"></i></div>';
                                    }
                                    ?>
                                </a>
                                <?php if ( $product && $product->is_on_sale() ) : ?>
                                    <span class="absolute top-3 left-3 bg-munar-gold text-white text-[9px] uppercase tracking-widest px-2 py-0.5 font-semibold">Special Offer</span>
                                <?php else : ?>
                                    <span class="absolute top-3 left-3 bg-munar-black text-white text-[9px] uppercase tracking-widest px-2 py-0.5 font-medium">New Drop</span>
                                <?php endif; ?>
                                <button class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm hover:bg-white p-2 rounded-full text-munar-dark hover:text-red-600 transition-colors shadow-sm wishlist-btn" aria-label="Add to Wishlist" data-product-id="<?php echo esc_attr( get_the_ID() ); ?>">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                </button>
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="text-[10px] uppercase tracking-widest text-munar-muted">
                                        <?php echo wc_get_product_category_list( get_the_ID(), ', ', '', '' ); ?>
                                    </div>
                                    <h3 class="font-editorial text-xl font-normal text-munar-black mt-0.5">
                                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="hover:text-munar-gold transition-colors">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                </div>
                                <div class="pt-2 border-t border-munar-border/40 flex items-center justify-between">
                                    <span class="font-sans font-semibold text-sm text-munar-black">
                                        <?php echo $product ? $product->get_price_html() : ''; ?>
                                    </span>
                                    <span class="text-[10px] uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-medium">
                                        <?php echo ( $product && $product->is_in_stock() ) ? 'In Atelier' : 'Bespoke Order'; ?>
                                    </span>
                                </div>
                                <div class="pt-1">
                                    <?php
                                    if ( $product ) {
                                        woocommerce_template_loop_add_to_cart( array(
                                            'class' => 'w-full btn-munar-primary text-[11px] py-2.5 text-center block'
                                        ) );
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- 4. Editorial Campaign / Brand Heritage Split Narrative -->
    <section class="py-24 bg-munar-dark text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="text-xs uppercase tracking-[0.35em] text-munar-gold font-semibold">Atelier Philosophy</span>
                    <h2 class="font-editorial text-3xl sm:text-5xl font-light tracking-wide leading-tight">
                        Precision tailoring rooted in East African heritage.
                    </h2>
                    <p class="text-munar-sand/80 font-light text-sm sm:text-base leading-relaxed">
                        Every Munar creation begins as a study in proportion, structure, and drape. Our master artisans in Nairobi blend classical couture methods with organic African silks, linens, and vegetable-tanned leathers to create silhouettes that command room presence.
                    </p>
                    <div class="grid grid-cols-2 gap-6 pt-4 border-t border-white/10 text-xs">
                        <div class="space-y-1">
                            <p class="font-editorial text-2xl text-munar-gold">100%</p>
                            <p class="text-munar-sand/60 uppercase tracking-widest text-[10px]">Kenyan Ethical Craft</p>
                        </div>
                        <div class="space-y-1">
                            <p class="font-editorial text-2xl text-munar-gold">Bespoke</p>
                            <p class="text-munar-sand/60 uppercase tracking-widest text-[10px]">Private Atelier Fitting</p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <a href="<?php echo esc_url( home_url('/about') ); ?>" class="btn-munar-gold">
                            Read Our Atelier Story
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/5] bg-munar-black overflow-hidden border border-white/10 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1200&q=85" alt="Munar Tailor Atelier" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-munar-gold p-6 text-munar-black shadow-xl hidden sm:block max-w-xs">
                        <p class="font-editorial text-lg italic leading-snug">"True luxury is found in the quiet perfection of the stitch."</p>
                        <p class="text-[10px] uppercase tracking-widest font-sans font-bold mt-2">— Munar Master Tailor</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Interactive Runway Lookbook Carousel -->
    <section id="lookbook" class="py-24 bg-munar-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div class="space-y-2">
                    <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Lookbook Edition</span>
                    <h2 class="font-editorial text-3xl sm:text-4xl text-munar-black font-light tracking-wide">Runway Stories &bull; Edition 2026</h2>
                </div>
                <!-- Slider Nav Buttons -->
                <div class="flex items-center space-x-2">
                    <button class="lookbook-prev p-2.5 border border-munar-border hover:bg-munar-black hover:text-white transition-colors" aria-label="Previous slide">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </button>
                    <button class="lookbook-next p-2.5 border border-munar-border hover:bg-munar-black hover:text-white transition-colors" aria-label="Next slide">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Swiper Container -->
            <div class="swiper munar-lookbook-swiper">
                <div class="swiper-wrapper">
                    
                    <div class="swiper-slide aspect-[3/4] bg-munar-sand overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80" alt="Look 01" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                            <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 01</span>
                            <p class="font-editorial text-xl">The Nairobi Obsidian Trench</p>
                        </div>
                    </div>

                    <div class="swiper-slide aspect-[3/4] bg-munar-sand overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=800&q=80" alt="Look 02" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                            <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 02</span>
                            <p class="font-editorial text-xl">Raw Silk Evening Drape</p>
                        </div>
                    </div>

                    <div class="swiper-slide aspect-[3/4] bg-munar-sand overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1485230895905-ec40ba36b9bc?auto=format&fit=crop&w=800&q=80" alt="Look 03" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                            <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 03</span>
                            <p class="font-editorial text-xl">Monochrome Linen Ensemble</p>
                        </div>
                    </div>

                    <div class="swiper-slide aspect-[3/4] bg-munar-sand overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1492707892479-7bc8d5a4ee93?auto=format&fit=crop&w=800&q=80" alt="Look 04" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                            <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 04</span>
                            <p class="font-editorial text-xl">Sculptural Leather Tote</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- 6. VIP Perks & M-Pesa Security Strip -->
    <section class="py-12 bg-white border-t border-munar-border/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center md:text-left">
                
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-munar-sand flex items-center justify-center text-munar-black flex-shrink-0">
                        <i data-lucide="truck" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs uppercase tracking-wider font-semibold text-munar-black">VIP Courier Delivery</h4>
                        <p class="text-xs text-munar-muted mt-0.5">Complimentary nationwide delivery over KSh 15,000</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700 flex-shrink-0">
                        <i data-lucide="smartphone" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs uppercase tracking-wider font-semibold text-munar-black">Lipa na M-Pesa</h4>
                        <p class="text-xs text-munar-muted mt-0.5">Instant STK Push PIN prompt directly on checkout</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-munar-sand flex items-center justify-center text-munar-black flex-shrink-0">
                        <i data-lucide="scissors" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs uppercase tracking-wider font-semibold text-munar-black">Atelier Fitting Guarantee</h4>
                        <p class="text-xs text-munar-muted mt-0.5">Free alterations at our Westlands Nairobi studio</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-munar-sand flex items-center justify-center text-munar-black flex-shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs uppercase tracking-wider font-semibold text-munar-black">100% Authentic Haute</h4>
                        <p class="text-xs text-munar-muted mt-0.5">Numbered authenticity certificates with each piece</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
