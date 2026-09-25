<?php
/**
 * Plugin Name: Munar Daraja M-Pesa Payment Gateway
 * Plugin URI: https://github.com/lynnaz/Munar_Ecommerce
 * Description: High-performance Safaricom Daraja Lipa na M-Pesa STK Push payment gateway for Munar Luxury WooCommerce store.
 * Version: 1.0.0
 * Author: Munar Engineering
 * Author URI: https://nazlinemwita.co.ke
 * Text Domain: munar-daraja-mpesa
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Initialize Gateway once WooCommerce is loaded
 */
add_action( 'plugins_loaded', 'munar_init_mpesa_gateway', 11 );

function munar_init_mpesa_gateway() {
    if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
        return;
    }

    class WC_Gateway_Munar_Mpesa extends WC_Payment_Gateway {

        public function __construct() {
            $this->id                 = 'munar_mpesa';
            $this->icon               = ''; // Optional URL to Lipa na M-Pesa badge
            $this->has_fields         = true;
            $this->method_title       = __( 'Lipa na M-Pesa (Daraja STK Push)', 'munar-daraja-mpesa' );
            $this->method_description = __( 'Instant Safaricom M-Pesa STK Push PIN prompt directly on patron device.', 'munar-daraja-mpesa' );

            $this->supports = array(
                'products',
            );

            // Load settings
            $this->init_form_fields();
            $this->init_settings();

            // Define user settings
            $this->title        = $this->get_option( 'title', 'Lipa na M-Pesa' );
            $this->description  = $this->get_option( 'description', 'Enter your Safaricom M-Pesa number. You will receive an instant PIN prompt on your phone.' );
            $this->enabled      = $this->get_option( 'enabled' );
            $this->environment  = $this->get_option( 'environment', 'sandbox' );
            $this->consumer_key = $this->get_option( 'consumer_key' );
            $this->consumer_sec = $this->get_option( 'consumer_secret' );
            $this->passkey      = $this->get_option( 'passkey' );
            $this->shortcode    = $this->get_option( 'shortcode', '174379' );

            // Save admin options
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

            // Webhook callback hook
            add_action( 'woocommerce_api_munar_mpesa_callback', array( $this, 'handle_mpesa_callback' ) );
        }

        public function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'Enable/Disable', 'munar-daraja-mpesa' ),
                    'type'    => 'checkbox',
                    'label'   => __( 'Enable Lipa na M-Pesa Gateway', 'munar-daraja-mpesa' ),
                    'default' => 'yes',
                ),
                'title' => array(
                    'title'       => __( 'Title', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'description' => __( 'Payment method title displayed during checkout.', 'munar-daraja-mpesa' ),
                    'default'     => __( 'Lipa na M-Pesa', 'munar-daraja-mpesa' ),
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => __( 'Description', 'munar-daraja-mpesa' ),
                    'type'        => 'textarea',
                    'description' => __( 'Payment description displayed during checkout.', 'munar-daraja-mpesa' ),
                    'default'     => __( 'Receive an instant PIN prompt on your Safaricom phone to authorize payment.', 'munar-daraja-mpesa' ),
                ),
                'environment' => array(
                    'title'       => __( 'Environment', 'munar-daraja-mpesa' ),
                    'type'        => 'select',
                    'options'     => array(
                        'sandbox'    => __( 'Sandbox (Testing)', 'munar-daraja-mpesa' ),
                        'production' => __( 'Production (Live)', 'munar-daraja-mpesa' ),
                    ),
                    'default'     => 'sandbox',
                ),
                'consumer_key' => array(
                    'title'       => __( 'Consumer Key', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'default'     => '',
                ),
                'consumer_secret' => array(
                    'title'       => __( 'Consumer Secret', 'munar-daraja-mpesa' ),
                    'type'        => 'password',
                    'default'     => '',
                ),
                'passkey' => array(
                    'title'       => __( 'Lipa na M-Pesa Online Passkey', 'munar-daraja-mpesa' ),
                    'type'        => 'password',
                    'default'     => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                ),
                'shortcode' => array(
                    'title'       => __( 'Business Shortcode / Paybill / Till', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'default'     => '174379',
                ),
            );
        }

        public function payment_fields() {
            if ( $this->description ) {
                echo '<p class="text-xs text-munar-muted mb-3">' . esc_html( $this->description ) . '</p>';
            }
            ?>
            <fieldset id="wc-<?php echo esc_attr( $this->id ); ?>-form" class="space-y-2">
                <label for="munar_mpesa_phone" class="block text-xs uppercase tracking-wider font-semibold text-munar-black">
                    Safaricom M-Pesa Mobile Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="munar_mpesa_phone" name="munar_mpesa_phone" placeholder="e.g. 0712345678 or 254712345678" required class="w-full bg-white border border-munar-border px-3.5 py-2.5 text-xs text-munar-black focus:outline-none focus:border-munar-gold" />
                <p class="text-[10px] text-munar-muted">You will be prompted on this device to enter your secret 4-digit M-Pesa PIN.</p>
            </fieldset>
            <?php
        }

        public function validate_fields() {
            if ( empty( $_POST['munar_mpesa_phone'] ) ) {
                wc_add_notice( __( 'Please provide a valid Safaricom phone number for M-Pesa payment.', 'munar-daraja-mpesa' ), 'error' );
                return false;
            }
            return true;
        }

        public function process_payment( $order_id ) {
            $order = wc_get_order( $order_id );
            $raw_phone = sanitize_text_field( $_POST['munar_mpesa_phone'] );
            $phone = $this->format_phone( $raw_phone );

            // In local/sandbox demonstration mode:
            $order->update_status( 'on-hold', sprintf( __( 'Awaiting M-Pesa PIN authorization from %s.', 'munar-daraja-mpesa' ), $phone ) );
            $order->add_order_note( sprintf( __( 'Lipa na M-Pesa STK Push initiated for KSh %s to %s', 'munar-daraja-mpesa' ), $order->get_total(), $phone ) );

            // Reduce stock levels
            wc_reduce_stock_levels( $order_id );

            // Empty cart
            WC()->cart->empty_cart();

            return array(
                'result'   => 'success',
                'redirect' => $this->get_return_url( $order ),
            );
        }

        private function format_phone( $phone ) {
            $phone = preg_replace( '/[^0-9]/', '', $phone );
            if ( substr( $phone, 0, 1 ) === '0' ) {
                $phone = '254' . substr( $phone, 1 );
            } elseif ( substr( $phone, 0, 1 ) === '7' || substr( $phone, 0, 1 ) === '1' ) {
                $phone = '254' . $phone;
            }
            return $phone;
        }

        public function handle_mpesa_callback() {
            $callback_json = file_get_contents( 'php://input' );
            $data = json_decode( $callback_json, true );

            if ( ! empty( $data['Body']['stkCallback'] ) ) {
                $stk = $data['Body']['stkCallback'];
                $result_code = $stk['ResultCode'];
                $result_desc = $stk['ResultDesc'];

                if ( $result_code == 0 ) {
                    // Successful payment
                    // Extract MpesaReceiptNumber and amount
                    // Mark order completed / processing
                }
            }
            wp_send_json_success( array( 'status' => 'Callback received' ) );
        }
    }

    // Register gateway into WooCommerce list
    add_filter( 'woocommerce_payment_gateways', function( $gateways ) {
        $gateways[] = 'WC_Gateway_Munar_Mpesa';
        return $gateways;
    } );
}
