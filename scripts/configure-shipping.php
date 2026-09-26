<?php
/**
 * Configure Munar Luxury Shipping Zones in WooCommerce
 */
define('WP_USE_THEMES', false);
require_once('/opt/lampp/htdocs/wordpress/wp-load.php');

echo "🚚 Configuring Luxury Shipping Zones...\n";

$zones = WC_Shipping_Zones::get_zones();
echo "Existing zones count: " . count($zones) . "\n";

if (empty($zones)) {
    // 1. Zone 1: Nairobi Metropolitan
    $nairobi_zone = new WC_Shipping_Zone();
    $nairobi_zone->set_zone_name('Nairobi Metropolitan (White-Glove VIP Courier)');
    $nairobi_zone->set_zone_order(1);
    $nairobi_zone->add_location('KE:KE-30', 'state'); // Nairobi county code
    $nairobi_zone_id = $nairobi_zone->save();
    
    // Add Free Shipping (min amount KSh 15,000)
    $free_shipping_id = $nairobi_zone->add_shipping_method('free_shipping');
    $free_shipping = WC_Shipping_Zones::get_shipping_method($free_shipping_id);
    if ($free_shipping) {
        $free_shipping->init_instance_settings();
        $free_shipping->instance_settings['title'] = 'Complimentary VIP White-Glove Courier (Orders over KSh 15,000)';
        $free_shipping->instance_settings['requires'] = 'min_amount';
        $free_shipping->instance_settings['min_amount'] = 15000;
        update_option($free_shipping->get_instance_option_key(), $free_shipping->instance_settings);
    }

    // Add Flat Rate for Nairobi orders under threshold
    $flat_id = $nairobi_zone->add_shipping_method('flat_rate');
    $flat = WC_Shipping_Zones::get_shipping_method($flat_id);
    if ($flat) {
        $flat->init_instance_settings();
        $flat->instance_settings['title'] = 'Standard Atelier Courier (Nairobi Same-Day)';
        $flat->instance_settings['cost'] = 500;
        update_option($flat->get_instance_option_key(), $flat->instance_settings);
    }
    
    // 2. Zone 2: Rest of Kenya
    $kenya_zone = new WC_Shipping_Zone();
    $kenya_zone->set_zone_name('Rest of Kenya (Express Secured Courier)');
    $kenya_zone->set_zone_order(2);
    $kenya_zone->add_location('KE', 'country');
    $kenya_zone_id = $kenya_zone->save();
    
    $kenya_flat_id = $kenya_zone->add_shipping_method('flat_rate');
    $kenya_flat = WC_Shipping_Zones::get_shipping_method($kenya_flat_id);
    if ($kenya_flat) {
        $kenya_flat->init_instance_settings();
        $kenya_flat->instance_settings['title'] = 'Nationwide Express Secured Courier';
        $kenya_flat->instance_settings['cost'] = 1200;
        update_option($kenya_flat->get_instance_option_key(), $kenya_flat->instance_settings);
    }

    echo "✅ Created Nairobi Metropolitan and Rest of Kenya VIP shipping zones!\n";
} else {
    echo "ℹ️ Shipping zones already configured:\n";
    foreach ($zones as $z) {
        echo "  - " . $z['zone_name'] . "\n";
    }
}
