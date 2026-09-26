<?php
define('WP_USE_THEMES', false);
require('/opt/lampp/htdocs/wordpress/wp-load.php');

$checkout_id = wc_get_page_id('checkout');
$cart_id = wc_get_page_id('cart');

// 1. Update Checkout page to classic shortcode
wp_update_post(array(
    'ID'           => $checkout_id,
    'post_content' => '[woocommerce_checkout]',
));

// 2. Update Cart page to classic shortcode
wp_update_post(array(
    'ID'           => $cart_id,
    'post_content' => '[woocommerce_cart]',
));

echo "Successfully converted Checkout (ID $checkout_id) and Cart (ID $cart_id) to classic shortcodes!\n";
