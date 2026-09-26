<?php
define('WP_USE_THEMES', false);
require('/opt/lampp/htdocs/wordpress/wp-load.php');

$checkout_id = wc_get_page_id('checkout');
$cart_id = wc_get_page_id('cart');
$checkout_post = get_post($checkout_id);
$cart_post = get_post($cart_id);

echo "Checkout ID: $checkout_id\n";
echo "Checkout Post Content:\n" . $checkout_post->post_content . "\n\n";

echo "Cart ID: $cart_id\n";
echo "Cart Post Content:\n" . $cart_post->post_content . "\n\n";
