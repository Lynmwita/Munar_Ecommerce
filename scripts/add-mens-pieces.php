<?php
/**
 * Add 4 New Men's Sartorial Pieces to Munar Luxury Platform
 */

define('WP_USE_THEMES', false);
define('DISABLE_WP_CRON', true);
error_reporting(E_ERROR | E_PARSE);

require_once '/opt/lampp/htdocs/wordpress/wp-load.php';

echo "Adding 4 New Men's Sartorial Pieces...\n";

$cat = get_term_by('slug', 'mens-sartorial', 'product_cat');
if (!$cat) {
    die("Category mens-sartorial not found!\n");
}

$site_url = home_url();
$theme_img_base = $site_url . '/wp-content/themes/munar-luxury/assets/images/products/';

$new_pieces = array(
    array(
        'name'        => 'The Savile Row Camel Hair Overcoat',
        'sku'         => 'MNR-MS-004',
        'price'       => '65000',
        'sale'        => '58000',
        'stock'       => 6,
        'image_file'  => 'the-savile-row-camel-hair-overcoat.jpg',
        'short_desc'  => 'Hand-tailored double-breasted camel hair overcoat with peaked lapels, genuine horn buttons, and pure cupro silk lining.',
        'description' => '<p>The pinnacle of timeless sartorial outerwear. Crafted from ultra-soft, pure baby camel hair with an exceptionally warm yet featherlight handfeel. Featuring bold peaked lapels, structured roped shoulders, hand-carved horn buttons, and full cupro interior lining.</p><ul><li>100% Pure Baby Camel Hair Outer</li><li>100% Breathable Cupro Silk Lining</li><li>Double-breasted 6x2 button silhouette</li><li>Deep flapped welt pockets and ticket pocket</li><li>Hand-tailored in Nairobi by master bespoke tailors</li></ul>',
    ),
    array(
        'name'        => 'Bespoke Silk & Linen Safari Overshirt',
        'sku'         => 'MNR-MS-005',
        'price'       => '38000',
        'sale'        => '',
        'stock'       => 8,
        'image_file'  => 'bespoke-silk-linen-safari-overshirt.jpg',
        'short_desc'  => 'Structured safari overshirt tailored from hand-spun East African linen and mulberry silk with pleated bellows chest pockets.',
        'description' => '<p>An effortless nod to East African heritage and contemporary gentleman elegance. Blending crisp Belgian linen with mulberry raw silk, this structured utility overshirt features quadruple pleated bellows pockets, horn closures, and a convertible camp collar.</p><ul><li>65% Hand-spun Linen, 35% Raw Mulberry Silk</li><li>Quadruple 3D pleated bellows chest and hip pockets</li><li>Natural horn buttons with reinforced cross-stitching</li><li>Relaxed tailored drape suitable for layering</li><li>Dry clean or gentle cold hand wash</li></ul>',
    ),
    array(
        'name'        => 'Nairobi Atelier Silk-Velvet Smoking Jacket',
        'sku'         => 'MNR-MS-006',
        'price'       => '54000',
        'sale'        => '49000',
        'stock'       => 4,
        'image_file'  => 'nairobi-atelier-silk-velvet-smoking-jacket.jpg',
        'short_desc'  => 'Midnight emerald silk-velvet evening dinner jacket with black grosgrain shawl lapel, turnback cuffs, and braided frog closure.',
        'description' => '<p>Crafted for distinguished black-tie evenings and high-society receptions. Sumptuous deep emerald Italian silk velvet accented by a lustrous midnight-black grosgrain silk shawl collar and matching turnback gauntlet cuffs, finished with traditional handmade frogging.</p><ul><li>Italian Silk-Rayon Plush Velvet in Emerald Midnight</li><li>Black Grosgrain Silk Shawl Lapel & Gauntlet Cuffs</li><li>Hand-braided artisanal frog front closure</li><li>Dual interior cigar and timepiece pockets</li><li>Custom tailored by Munar Couture</li></ul>',
    ),
    array(
        'name'        => 'Italian Merino Wool Tailored Knit Polo',
        'sku'         => 'MNR-MS-007',
        'price'       => '26000',
        'sale'        => '',
        'stock'       => 10,
        'image_file'  => 'italian-merino-wool-tailored-knit-polo.jpg',
        'short_desc'  => '18-gauge extra-fine Italian Merino wool knit long-sleeve polo with seamless collar and mother-of-pearl buttons.',
        'description' => '<p>Sleek sartorial casual luxury. Spun from 18-gauge ultra-fine Italian Merino wool with natural temperature-regulating properties. Finished with a clean seamless fashion collar, 3-button placket set with genuine Australian mother-of-pearl buttons, and ribbed hems.</p><ul><li>100% Extra-fine 18-Gauge Italian Merino Wool</li><li>Genuine Australian Mother-of-Pearl buttons</li><li>Ribbed cuffs and waistband with shape-retention elastane</li><li>Silky soft touch directly against skin</li><li>Hand wash cold and dry flat</li></ul>',
    ),
);

foreach ($new_pieces as $data) {
    $existing_id = wc_get_product_id_by_sku($data['sku']);
    if ($existing_id) {
        $product = wc_get_product($existing_id);
        echo "Updating existing: {$data['name']} (ID: $existing_id)\n";
    } else {
        $product = new WC_Product_Simple();
        echo "Creating new product: {$data['name']}\n";
    }

    $product->set_name($data['name']);
    $product->set_sku($data['sku']);
    $product->set_regular_price($data['price']);
    if (!empty($data['sale'])) {
        $product->set_sale_price($data['sale']);
        $product->set_price($data['sale']);
    } else {
        $product->set_sale_price('');
        $product->set_price($data['price']);
    }
    $product->set_short_description($data['short_desc']);
    $product->set_description($data['description']);
    $product->set_manage_stock(true);
    $product->set_stock_quantity($data['stock']);
    $product->set_stock_status('instock');
    $product->set_status('publish');
    $product->set_category_ids(array($cat->term_id));

    $product_id = $product->save();

    $hero_url = $theme_img_base . $data['image_file'];
    update_post_meta($product_id, '_munar_hero_image_url', $hero_url);
    echo " Saved product $product_id with hero image $hero_url\n";
}

echo "✅ All 4 Men's Sartorial pieces successfully configured!\n";
