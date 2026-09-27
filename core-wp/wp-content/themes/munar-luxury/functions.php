<?php
/**
 * Munar Luxury Atelier Theme Functions
 *
 * @package Munar_Luxury
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'MUNAR_THEME_VERSION', '1.0.0' );
define( 'MUNAR_THEME_DIR', get_template_directory() );
define( 'MUNAR_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function munar_luxury_theme_setup() {
    // Add default title tag support
    add_theme_support( 'title-tag' );

    // Enable post thumbnails
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 800, 1000, true ); // Luxury portrait ratio (4:5)
    add_image_size( 'munar-lookbook', 1200, 1500, true );
    add_image_size( 'munar-square', 800, 800, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary-menu'   => __( 'Primary Luxury Navigation', 'munar-luxury' ),
        'lookbook-menu'  => __( 'Curated Lookbook Menu', 'munar-luxury' ),
        'footer-atelier' => __( 'Footer Atelier Column', 'munar-luxury' ),
        'footer-client'  => __( 'Footer Client Care Column', 'munar-luxury' ),
    ) );

    // HTML5 markup support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Custom Logo
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // WooCommerce Support
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 600,
        'single_image_width'    => 1000,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'max_rows'        => 6,
            'default_columns' => 3,
            'min_columns'     => 2,
            'max_columns'     => 4,
        ),
    ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'munar_luxury_theme_setup' );

/**
 * Enqueue Styles and Scripts
 */
function munar_luxury_enqueue_assets() {
    // Google Fonts: Cormorant Garamond (Editorial Serif) & Plus Jakarta Sans
    wp_enqueue_style(
        'munar-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Tailwind CSS via CDN for rapid high-fidelity UI rendering
    wp_enqueue_script(
        'munar-tailwind',
        'https://cdn.tailwindcss.com',
        array(),
        '3.4.1',
        false
    );

    // Tailwind Configuration Script
    wp_add_inline_script( 'munar-tailwind', "
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        munar: {
                            black: '#0D0D0D',
                            dark: '#141414',
                            mocha: '#4A2F24',
                            mochaDark: '#382218',
                            linen: '#EBDCCB',
                            cream: '#FAF7F2',
                            sand: '#F0EBE1',
                            gold: '#C5A880',
                            goldDark: '#9D815D',
                            border: '#E6DFD5',
                            muted: '#736B63',
                        }
                    },
                    fontFamily: {
                        editorial: ['\"Cormorant Garamond\"', 'Georgia', 'serif'],
                        sans: ['\"Plus Jakarta Sans\"', 'sans-serif'],
                    }
                }
            }
        }
    " );

    // Swiper CSS & JS for luxury sliders and lookbooks
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );
    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Lucide Icons
    wp_enqueue_script(
        'lucide-icons',
        'https://unpkg.com/lucide@latest',
        array(),
        'latest',
        true
    );

    // Main Theme CSS
    wp_enqueue_style(
        'munar-main-style',
        get_stylesheet_uri(),
        array(),
        MUNAR_THEME_VERSION
    );

    // Custom Theme JavaScript
    wp_enqueue_script(
        'munar-luxury-core',
        MUNAR_THEME_URI . '/assets/js/munar-luxury.js',
        array( 'jquery', 'swiper-js' ),
        MUNAR_THEME_VERSION,
        true
    );

    // Localize Script for AJAX Cart & M-Pesa operations
    wp_localize_script( 'munar-luxury-core', 'munar_ajax', array(
        'ajax_url'    => admin_url( 'admin-ajax.php' ),
        'nonce'       => wp_create_nonce( 'munar_luxury_nonce' ),
        'currency'    => 'KSh',
        'free_ship_threshold' => 15000,
        'cart_url'    => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#',
        'checkout_url'=> function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '#',
    ) );
}
add_action( 'wp_enqueue_scripts', 'munar_luxury_enqueue_assets' );

/**
 * Add WooCommerce Mini-Cart Drawer Fragments
 */
function munar_luxury_cart_fragments( $fragments ) {
    if ( function_exists( 'WC' ) ) {
        ob_start();
        ?>
        <span class="cart-count absolute -top-1.5 -right-1.5 bg-munar-gold text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
            <?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>
        </span>
        <?php
        $fragments['.cart-count'] = ob_get_clean();

        ob_start();
        ?>
        <div id="munar-cart-drawer-items" class="p-6 space-y-4 overflow-y-auto max-h-[calc(100vh-260px)]">
            <?php if ( WC()->cart->is_empty() ) : ?>
                <div class="text-center py-16 text-munar-muted">
                    <i data-lucide="shopping-bag" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
                    <p class="font-editorial text-2xl text-munar-black mb-1">Your bag is empty</p>
                    <p class="text-xs uppercase tracking-widest text-munar-muted mb-6">Explore our curated collections</p>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-munar-primary text-xs">Explore Shop</a>
                </div>
            <?php else : ?>
                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : 
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
                        $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
                ?>
                    <div class="flex items-center space-x-4 pb-4 border-b border-munar-border/60">
                        <div class="w-16 h-20 bg-munar-sand flex-shrink-0 overflow-hidden">
                            <?php echo $_product->get_image( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-serif text-base text-munar-black truncate">
                                <a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo esc_html( $_product->get_name() ); ?></a>
                            </h4>
                            <p class="text-xs text-munar-muted">Qty: <?php echo esc_html( $cart_item['quantity'] ); ?></p>
                            <p class="text-xs font-semibold text-munar-black mt-1"><?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?></p>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
            <?php endif; ?>
        </div>
        <?php
        $fragments['#munar-cart-drawer-items'] = ob_get_clean();
    }
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'munar_luxury_cart_fragments' );

/**
 * Custom Currency Symbol Formatting
 */
add_filter( 'woocommerce_currency_symbol', 'munar_custom_currency_symbol', 10, 2 );
function munar_custom_currency_symbol( $currency_symbol, $currency ) {
    if ( 'KES' === $currency ) {
        $currency_symbol = 'KSh ';
    }
    return $currency_symbol;
}

/**
 * Include AI Stylist Concierge Engine
 */
require_once MUNAR_THEME_DIR . '/inc/ai-concierge.php';

/**
 * Helper to retrieve WooCommerce category archive permalinks safely
 */
function munar_get_cat_url( $slug ) {
    $term = get_term_by( 'slug', $slug, 'product_cat' );
    if ( $term && ! is_wp_error( $term ) ) {
        $link = get_term_link( $term );
        if ( ! is_wp_error( $link ) ) {
            return $link;
        }
    }
    $term_by_name = get_term_by( 'name', $slug, 'product_cat' );
    if ( $term_by_name && ! is_wp_error( $term_by_name ) ) {
        $link = get_term_link( $term_by_name );
        if ( ! is_wp_error( $link ) ) {
            return $link;
        }
    }
    return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
}

