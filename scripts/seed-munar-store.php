<?php
/**
 * Munar Luxury E-Commerce Database & Product Seeder
 * Automates WooCommerce configuration, categories, luxury demo products,
 * M-Pesa Daraja sandbox settings, shipping methods, and VIP concierge pages.
 */

define('WP_USE_THEMES', false);
define('WP_HTTP_BLOCK_EXTERNAL', false);
define('DISABLE_WP_CRON', true);

// Suppress notices during CLI bootstrapping
error_reporting(E_ERROR | E_PARSE);

require_once('/opt/lampp/htdocs/wordpress/wp-load.php');

echo "🏛️ Initializing Munar Luxury E-Commerce Seeder...\n";

// 1. Activate Munar Theme if files are linked
$theme_slug = 'munar-luxury';
$themes = wp_get_themes();
if (isset($themes[$theme_slug])) {
    switch_theme($theme_slug);
    echo "✅ Theme activated: Munar Luxury Atelier\n";
} else {
    echo "ℹ️ Note: Munar theme not yet linked in /opt/lampp/htdocs/wordpress/wp-content/themes/\n";
}

// 2. Configure WooCommerce General & Currency Settings
echo "⚙️ Configuring Luxury Store & Currency Settings...\n";
update_option('woocommerce_currency', 'KES');
update_option('woocommerce_currency_pos', 'left_space');
update_option('woocommerce_price_thousand_sep', ',');
update_option('woocommerce_price_decimal_sep', '.');
update_option('woocommerce_price_num_decimals', 0);
update_option('woocommerce_weight_unit', 'kg');
update_option('woocommerce_dimension_unit', 'cm');
update_option('woocommerce_enable_reviews', 'yes');
update_option('woocommerce_enable_review_rating', 'yes');
update_option('woocommerce_enable_guest_checkout', 'yes');
update_option('woocommerce_enable_signup_and_login_from_checkout', 'yes');
update_option('woocommerce_default_country', 'KE');

// 3. Configure M-Pesa Payment Gateway Settings
echo "💳 Configuring Safaricom Daraja M-Pesa & VIP Payment Methods...\n";
$mpesa_settings = array(
    'enabled'            => 'yes',
    'title'              => 'Lipa na M-Pesa (Daraja STK Push)',
    'description'        => 'Instant Safaricom M-Pesa STK Push PIN prompt directly on patron device.',
    'environment'        => 'sandbox',
    'business_shortcode' => '174379',
    'passkey'            => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
    'consumer_key'       => 'DEMO_DARAJA_KEY_Munar_Luxury',
    'consumer_secret'    => 'DEMO_DARAJA_SECRET_Munar_Luxury',
);
update_option('woocommerce_munar_mpesa_settings', $mpesa_settings);

// Enable Cash / VIP Delivery payment
$cod_settings = array(
    'enabled'       => 'yes',
    'title'         => 'VIP Delivery & Concierge Payment (Nairobi)',
    'description'   => 'Pay via M-Pesa or Card upon fitting and white-glove courier delivery.',
    'instructions'  => 'Our concierge will contact you to coordinate delivery and fitting time.',
    'enable_for_virtual' => 'yes',
);
update_option('woocommerce_cod_settings', $cod_settings);

// Enable active payment gateways in WooCommerce
$gateways_order = array('munar_mpesa', 'cod');
update_option('woocommerce_gateway_order', $gateways_order);

// 4. Create Product Categories
echo "📁 Setting up Luxury Categories...\n";
$categories = array(
    'womens-atelier' => array(
        'name'        => "Women's Atelier",
        'description' => "Haute couture evening wear, silk gowns, and bespoke tailoring designed for effortless elegance.",
    ),
    'mens-sartorial' => array(
        'name'        => "Men's Sartorial",
        'description' => "Bespoke Italian virgin wool blazers, cashmere knitwear, and architectural sartorial pieces.",
    ),
    'leather-goods' => array(
        'name'        => "Haute Leather Goods",
        'description' => "Handcrafted Tuscan calfskin bags, structured luggage, and minimalist gold-buckle accessories.",
    ),
    'fine-jewelry' => array(
        'name'        => "Fine Jewelry & Timepieces",
        'description' => "18K brushed gold, precision-cut gemstones, and limited-edition handcrafted heirlooms.",
    ),
);

$cat_ids = array();
foreach ($categories as $slug => $data) {
    $term = get_term_by('slug', $slug, 'product_cat');
    if (!$term) {
        $created = wp_insert_term($data['name'], 'product_cat', array(
            'slug'        => $slug,
            'description' => $data['description'],
        ));
        if (!is_wp_error($created)) {
            $cat_ids[$slug] = $created['term_id'];
            echo "  + Created category: {$data['name']}\n";
        }
    } else {
        $cat_ids[$slug] = $term->term_id;
        echo "  = Existing category: {$data['name']}\n";
    }
}

// 5. Luxury Product Catalog Definition
$products = array(
    array(
        'name'        => 'The Sovereign Silk Evening Gown',
        'slug'        => 'sovereign-silk-evening-gown',
        'cat'         => 'womens-atelier',
        'price'       => 42500,
        'regular'     => 48000,
        'sku'         => 'MNR-W-001',
        'short_desc'  => 'Floor-length 100% mulberry silk gown with architectural back drape and brushed gold accent hardware.',
        'desc'        => 'The Sovereign Silk Gown epitomizes modern haute couture. Masterfully cut on the bias from high-grade heavyweight mulberry silk (22 momme), this gown flows effortlessly with each movement. Features hand-finished delicate French seams, an architectural low-back drape, and discreet side zipper closure.',
        'featured'    => 'yes',
        'image_url'   => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Size'  => array('XS', 'S', 'M', 'L'),
            'Color' => array('Onyx Black', 'Ivory Silk'),
        ),
    ),
    array(
        'name'        => 'Milano Double-Breasted Wool Blazer',
        'slug'        => 'milano-double-breasted-wool-blazer',
        'cat'         => 'mens-sartorial',
        'price'       => 38500,
        'regular'     => 38500,
        'sku'         => 'MNR-M-002',
        'short_desc'  => 'Tailored double-breasted jacket sculpted from Italian virgin wool with natural horn buttons and pure silk interior.',
        'desc'        => 'Crafted in collaboration with heritage Italian mills, the Milano Blazer pairs commanding peak lapels with a soft canvassed shoulder for unmatched comfort and silhouette. Lined in custom jacquard silk with four interior pockets.',
        'featured'    => 'yes',
        'image_url'   => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Size'  => array('38R', '40R', '42R', '44R'),
            'Color' => array('Midnight Navy', 'Charcoal Onyx'),
        ),
    ),
    array(
        'name'        => "L'Atelier Calfskin Monogram Tote",
        'slug'        => 'latelier-calfskin-monogram-tote',
        'cat'         => 'leather-goods',
        'price'       => 65000,
        'regular'     => 65000,
        'sku'         => 'MNR-L-003',
        'short_desc'  => 'Handcrafted full-grain Tuscan calfskin tote featuring brushed gold hardware and protective leather base studs.',
        'desc'        => 'An icon of Munar leather craftsmanship. Every L\'Atelier Tote requires 18 hours of meticulous hand-stitching by master artisans in Florence. Built from vegetable-tanned full-grain leather that develops a magnificent patina over time. Includes detachable matching zippered pouch and padded laptop compartment.',
        'featured'    => 'yes',
        'image_url'   => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Color' => array('Cognac Brown', 'Onyx Black', 'Warm Sand'),
        ),
    ),
    array(
        'name'        => 'Cashmere Belted Trench Coat',
        'slug'        => 'cashmere-belted-trench-coat',
        'cat'         => 'womens-atelier',
        'price'       => 54000,
        'regular'     => 54000,
        'sku'         => 'MNR-W-004',
        'short_desc'  => 'Double-faced Mongolian cashmere trench with oversized storm collar and removable tie belt.',
        'desc'        => 'A timeless statement of understated luxury. Unlined to showcase the exquisite double-faced cashmere weave, this coat delivers featherlight warmth with a dramatic, fluid silhouette. Features deep welt pockets and tailored raglan sleeves.',
        'featured'    => 'yes',
        'image_url'   => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Size'  => array('XS', 'S', 'M', 'L'),
            'Color' => array('Camel Sand', 'Onyx Black'),
        ),
    ),
    array(
        'name'        => 'Aura 18K Brushed Gold Cuff',
        'slug'        => 'aura-18k-brushed-gold-cuff',
        'cat'         => 'fine-jewelry',
        'price'       => 29000,
        'regular'     => 29000,
        'sku'         => 'MNR-J-005',
        'short_desc'  => 'Hand-forged 18K recycled yellow gold bracelet with architectural satin brushed finish.',
        'desc'        => 'Designed as a sculptural everyday piece, the Aura Cuff balances bold geometric proportions with minimalist comfort. Each cuff is individually cast in solid 18K yellow gold and finished with a distinctive brushed satin texture.',
        'featured'    => 'no',
        'image_url'   => 'https://images.unsplash.com/photo-1611591475155-42e523299711?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Size' => array('Small (15cm)', 'Medium (17cm)', 'Large (19cm)'),
        ),
    ),
    array(
        'name'        => 'Grand Sartorial Cashmere Turtleneck',
        'slug'        => 'grand-sartorial-cashmere-turtleneck',
        'cat'         => 'mens-sartorial',
        'price'       => 22500,
        'regular'     => 22500,
        'sku'         => 'MNR-M-006',
        'short_desc'  => 'Spun from 2-ply Scottish cashmere for an ultra-soft handle with subtle ribbed collar and cuffs.',
        'desc'        => 'The ultimate layering staple for discerning wardrobes. Knit on vintage looms from long-staple Grade-A cashmere fibers that resist pilling and soften with age.',
        'featured'    => 'no',
        'image_url'   => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1617137984095-74e4e5e3613f?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Size'  => array('S', 'M', 'L', 'XL'),
            'Color' => array('Alabaster Cream', 'Onyx Black', 'Heather Grey'),
        ),
    ),
    array(
        'name'        => 'Vanguard Leather Travel Duffle',
        'slug'        => 'vanguard-leather-travel-duffle',
        'cat'         => 'leather-goods',
        'price'       => 64000,
        'regular'     => 72000,
        'sku'         => 'MNR-L-007',
        'short_desc'  => 'Cabin-sized architectural weekend bag in vegetable-tanned leather with dual interior garment compartments.',
        'desc'        => 'Engineered for seamless intercontinental travel. Meets global airline carry-on standards while providing ample capacity for 4-day journeys. Reinforced riveted handles, TSA-approved padlock loops, and water-resistant coated cotton lining.',
        'featured'    => 'yes',
        'image_url'   => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1547949003-9792a18a2601?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Color' => array('Espresso Brown', 'Onyx Black'),
        ),
    ),
    array(
        'name'        => 'Solstice Sapphire Signet Ring',
        'slug'        => 'solstice-sapphire-signet-ring',
        'cat'         => 'fine-jewelry',
        'price'       => 35000,
        'regular'     => 35000,
        'sku'         => 'MNR-J-008',
        'short_desc'  => 'Solid 18K gold featuring a natural midnight-blue Ceylon sapphire bezel set by master jewelers.',
        'desc'        => 'A modern heirloom featuring a 1.2-carat ethically sourced natural Ceylon sapphire mounted in a weighty 18K solid yellow gold band. Each gemstone possesses unique natural inclusions certifying its organic provenance.',
        'featured'    => 'no',
        'image_url'   => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=1200&q=80',
        'gallery'     => array(
            'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?auto=format&fit=crop&w=1200&q=80',
        ),
        'attributes'  => array(
            'Ring Size' => array('US 6', 'US 7', 'US 8', 'US 9', 'US 10'),
        ),
    ),
);

// 6. Insert or Update Products
echo "🛍️ Seeding Curated Luxury Products...\n";
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

foreach ($products as $pdata) {
    // Check if product already exists by slug
    $existing = get_page_by_path($pdata['slug'], OBJECT, 'product');
    
    $product_id = 0;
    if ($existing) {
        $product_id = $existing->ID;
        echo "  = Updating product: {$pdata['name']} (ID: $product_id)\n";
    } else {
        $product_id = wp_insert_post(array(
            'post_title'   => $pdata['name'],
            'post_name'    => $pdata['slug'],
            'post_content' => $pdata['desc'],
            'post_excerpt' => $pdata['short_desc'],
            'post_status'  => 'publish',
            'post_type'    => 'product',
        ));
        echo "  + Created product: {$pdata['name']} (ID: $product_id)\n";
    }

    if ($product_id && !is_wp_error($product_id)) {
        // Set Product Type to simple
        wp_set_object_terms($product_id, 'simple', 'product_type');

        // Assign Category
        if (isset($cat_ids[$pdata['cat']])) {
            wp_set_object_terms($product_id, (int)$cat_ids[$pdata['cat']], 'product_cat');
        }

        // Set WooCommerce Postmeta
        update_post_meta($product_id, '_visibility', 'visible');
        update_post_meta($product_id, '_stock_status', 'instock');
        update_post_meta($product_id, '_manage_stock', 'no');
        update_post_meta($product_id, '_sku', $pdata['sku']);
        update_post_meta($product_id, '_price', $pdata['price']);
        update_post_meta($product_id, '_regular_price', $pdata['regular']);
        if ($pdata['price'] < $pdata['regular']) {
            update_post_meta($product_id, '_sale_price', $pdata['price']);
        } else {
            delete_post_meta($product_id, '_sale_price');
        }

        // Featured flag
        if ($pdata['featured'] === 'yes') {
            wp_set_object_terms($product_id, 'featured', 'product_visibility', true);
        }

        // Store custom editorial photo URL directly for fast zero-latency loading
        update_post_meta($product_id, '_munar_hero_image_url', $pdata['image_url']);
        update_post_meta($product_id, '_munar_gallery_urls', $pdata['gallery']);

        // Set Product Attributes
        if (!empty($pdata['attributes'])) {
            $product_attributes = array();
            $position = 0;
            foreach ($pdata['attributes'] as $attr_name => $values) {
                $product_attributes[sanitize_title($attr_name)] = array(
                    'name'         => $attr_name,
                    'value'        => implode(' | ', $values),
                    'position'     => $position++,
                    'is_visible'   => 1,
                    'is_variation' => 0,
                    'is_taxonomy'  => 0,
                );
            }
            update_post_meta($product_id, '_product_attributes', $product_attributes);
        }
    }
}

// 7. Ensure WooCommerce core pages are assigned
echo "📄 Verifying WooCommerce Core Pages...\n";
$shop_page = get_page_by_path('shop');
if ($shop_page) {
    update_option('woocommerce_shop_page_id', $shop_page->ID);
}
$cart_page = get_page_by_path('cart');
if ($cart_page) {
    update_option('woocommerce_cart_page_id', $cart_page->ID);
}
$checkout_page = get_page_by_path('checkout');
if ($checkout_page) {
    update_option('woocommerce_checkout_page_id', $checkout_page->ID);
}
$account_page = get_page_by_path('my-account');
if ($account_page) {
    update_option('woocommerce_myaccount_page_id', $account_page->ID);
}

// 8. Setup VIP Concierge / Lookbook Page
$lookbook_page = get_page_by_path('lookbook');
if (!$lookbook_page) {
    $lb_id = wp_insert_post(array(
        'post_title'   => 'Haute Couture Lookbook',
        'post_name'    => 'lookbook',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '<!-- wp:heading {"level":1} --><h1>The Munar 2026/2027 Runway Edition</h1><!-- /wp:heading --><p>An exploration of fluid architectural tailoring and nocturnal elegance.</p>',
    ));
    echo "  + Created Lookbook page (ID: $lb_id)\n";
}

echo "\n✨ ==================================================\n";
echo "🎉 Munar Luxury Store Seeded Successfully!\n";
echo "🛍️ 8 Haute Couture products created with prices in KSh.\n";
echo "💳 Safaricom Daraja M-Pesa & VIP Concierge payments configured.\n";
echo "====================================================\n";
