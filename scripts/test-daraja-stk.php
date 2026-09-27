<?php
/**
 * Munar Daraja M-Pesa Diagnostic & STK Push Test Utility
 */

define('WP_USE_THEMES', false);
require_once('/opt/lampp/htdocs/wordpress/wp-load.php');

if (!class_exists('WC_Payment_Gateway')) {
    die("WooCommerce is required.\n");
}

$gateways = WC()->payment_gateways->payment_gateways();
if (!isset($gateways['munar_mpesa'])) {
    die("Munar M-Pesa Gateway is not active.\n");
}

$gateway = $gateways['munar_mpesa'];

echo "====================================================\n";
echo "   MUNAR DARAJA M-PESA GATEWAY DIAGNOSTIC TOOL\n";
echo "====================================================\n";
echo "Environment:        " . $gateway->environment . "\n";
echo "Shortcode:          " . $gateway->shortcode . "\n";
echo "Consumer Key:       " . (empty($gateway->consumer_key) ? "[NOT CONFIGURED]" : substr($gateway->consumer_key, 0, 8) . "...") . "\n";
echo "Consumer Secret:    " . (empty($gateway->consumer_sec) ? "[NOT CONFIGURED]" : substr($gateway->consumer_sec, 0, 8) . "...") . "\n";
echo "Online Passkey:     " . (empty($gateway->passkey) ? "[NOT CONFIGURED]" : substr($gateway->passkey, 0, 10) . "...") . "\n";
echo "Custom Callback:    " . (empty($gateway->custom_callback_url) ? "[DEFAULT: " . home_url('/?wc-api=munar_mpesa_callback') . "]" : $gateway->custom_callback_url) . "\n";
echo "----------------------------------------------------\n";

if (empty($gateway->consumer_key) || empty($gateway->consumer_sec)) {
    echo "️  STATUS: Gateway is running in DEMO MODE.\n";
    echo "    To test live STK pushes to a real phone, add your Consumer Key\n";
    echo "    and Secret under WP Admin > WooCommerce > Settings > Payments > Lipa na M-Pesa.\n";
    echo "====================================================\n";
    exit(0);
}

// Test OAuth Token Generation
echo "Testing Daraja OAuth Access Token...\n";
$base_url = ($gateway->environment === 'production') ? 'https://api.safaricom.co.ke' : 'https://sandbox.safaricom.co.ke';
$credentials = base64_encode($gateway->consumer_key . ':' . $gateway->consumer_sec);

$response = wp_remote_get($base_url . '/oauth/v1/generate?grant_type=client_credentials', array(
    'headers' => array(
        'Authorization' => 'Basic ' . $credentials,
    ),
    'timeout' => 20,
));

if (is_wp_error($response)) {
    echo " OAuth Connection Failed: " . $response->get_error_message() . "\n";
    exit(1);
}

$code = wp_remote_retrieve_response_code($response);
$body = json_decode(wp_remote_retrieve_body($response), true);

if ($code === 200 && !empty($body['access_token'])) {
    echo " OAuth Authentication Succeeded! Access token acquired (expires in {$body['expires_in']}s).\n";
} else {
    echo " OAuth Authentication Failed (HTTP $code): " . ($body['errorMessage'] ?? 'Check Consumer Key & Secret') . "\n";
}

echo "====================================================\n";
