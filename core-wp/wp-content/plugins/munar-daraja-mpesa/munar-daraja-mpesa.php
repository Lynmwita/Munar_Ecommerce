<?php
/**
 * Plugin Name: Munar Daraja M-Pesa Payment Gateway
 * Plugin URI: https://github.com/lynnaz/Munar_Ecommerce
 * Description: High-performance Safaricom Daraja Lipa na M-Pesa STK Push payment gateway for Munar Luxury WooCommerce store with real-time STK push, token caching, webhook callbacks, and Ngrok local tunnel support.
 * Version: 1.1.0
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
            $this->icon               = ''; 
            $this->has_fields         = true;
            $this->method_title       = __( 'Lipa na M-Pesa (Daraja STK Push)', 'munar-daraja-mpesa' );
            $this->method_description = __( 'Instant Safaricom M-Pesa STK Push PIN prompt directly on patron mobile phone.', 'munar-daraja-mpesa' );

            $this->supports = array(
                'products',
            );

            // Load settings schema & values
            $this->init_form_fields();
            $this->init_settings();

            // Define gateway settings
            $this->title               = $this->get_option( 'title', 'Lipa na M-Pesa' );
            $this->description         = $this->get_option( 'description', 'Receive an instant PIN prompt on your Safaricom phone to authorize payment.' );
            $this->enabled             = $this->get_option( 'enabled', 'yes' );
            $this->environment         = $this->get_option( 'environment', 'sandbox' );
            $this->consumer_key        = trim( $this->get_option( 'consumer_key', '' ) );
            $this->consumer_sec        = trim( $this->get_option( 'consumer_secret', '' ) );
            $this->passkey             = trim( $this->get_option( 'passkey', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919' ) );
            $this->shortcode           = trim( $this->get_option( 'shortcode', '174379' ) );
            $this->custom_callback_url = trim( $this->get_option( 'custom_callback_url', '' ) );

            // Save admin options
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

            // Webhook callback endpoint hook: /?wc-api=munar_mpesa_callback
            add_action( 'woocommerce_api_munar_mpesa_callback', array( $this, 'handle_mpesa_callback' ) );

            // REST API callback alternative: /wp-json/daraja/v1/callback
            add_action( 'rest_api_init', array( $this, 'register_rest_callback' ) );

            // Thank-you page custom status display
            add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page_instructions' ) );
        }

        public function init_form_fields() {
            $default_callback = add_query_arg( 'wc-api', 'munar_mpesa_callback', home_url( '/' ) );

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
                    'default'     => __( 'Lipa na M-Pesa (Daraja STK Push)', 'munar-daraja-mpesa' ),
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => __( 'Description', 'munar-daraja-mpesa' ),
                    'type'        => 'textarea',
                    'description' => __( 'Payment description displayed during checkout.', 'munar-daraja-mpesa' ),
                    'default'     => __( 'Enter your Safaricom M-Pesa phone number below. An instant payment request will appear on your phone screen asking for your M-Pesa PIN.', 'munar-daraja-mpesa' ),
                ),
                'environment' => array(
                    'title'       => __( 'Environment', 'munar-daraja-mpesa' ),
                    'type'        => 'select',
                    'options'     => array(
                        'sandbox'    => __( 'Sandbox (Testing - daraja.safaricom.co.ke)', 'munar-daraja-mpesa' ),
                        'production' => __( 'Production (Live API)', 'munar-daraja-mpesa' ),
                    ),
                    'default'     => 'sandbox',
                    'description' => __( 'Select Sandbox for testing or Production for live customer transactions.', 'munar-daraja-mpesa' ),
                ),
                'consumer_key' => array(
                    'title'       => __( 'Consumer Key', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'description' => __( 'Safaricom Daraja App Consumer Key.', 'munar-daraja-mpesa' ),
                    'default'     => '',
                ),
                'consumer_secret' => array(
                    'title'       => __( 'Consumer Secret', 'munar-daraja-mpesa' ),
                    'type'        => 'password',
                    'description' => __( 'Safaricom Daraja App Consumer Secret.', 'munar-daraja-mpesa' ),
                    'default'     => '',
                ),
                'passkey' => array(
                    'title'       => __( 'Online Passkey', 'munar-daraja-mpesa' ),
                    'type'        => 'password',
                    'description' => __( 'Lipa na M-Pesa Online Passkey provided in your Daraja portal.', 'munar-daraja-mpesa' ),
                    'default'     => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                ),
                'shortcode' => array(
                    'title'       => __( 'Business Shortcode (Paybill / Till)', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'description' => __( 'Sandbox default is 174379. Replace with your live Paybill or Buygoods number.', 'munar-daraja-mpesa' ),
                    'default'     => '174379',
                ),
                'custom_callback_url' => array(
                    'title'       => __( 'Webhook Callback URL (Ngrok / Public Domain)', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'description' => sprintf(
                        __( 'Default local endpoint: <code>%s</code>.<br><strong>Crucial for Localhost:</strong> Safaricom cannot send callbacks to localhost. When testing locally, run <code>ngrok http 80</code> and paste your Ngrok public URL here (e.g. <code>https://xxxx.ngrok-free.app/?wc-api=munar_mpesa_callback</code>).', 'munar-daraja-mpesa' ),
                        esc_html( $default_callback )
                    ),
                    'default'     => '',
                ),
            );
        }

        public function payment_fields() {
            if ( $this->description ) {
                echo '<p class="text-xs text-munar-muted mb-3">' . wp_kses_post( $this->description ) . '</p>';
            }
            ?>
            <fieldset id="wc-<?php echo esc_attr( $this->id ); ?>-form" class="space-y-3 bg-[#FAF7F2] p-4 border border-[#E6DFD5] rounded-sm">
                <div class="flex items-center justify-between">
                    <label for="munar_mpesa_phone" class="block text-xs uppercase tracking-wider font-semibold text-munar-black">
                        Safaricom M-Pesa Number <span class="text-munar-gold">*</span>
                    </label>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 border border-emerald-200 rounded">
                        STK Push Ready
                    </span>
                </div>
                <div class="relative">
                    <input type="tel" 
                           id="munar_mpesa_phone" 
                           name="munar_mpesa_phone" 
                           value="<?php echo esc_attr( isset( $_POST['munar_mpesa_phone'] ) ? sanitize_text_field( $_POST['munar_mpesa_phone'] ) : '' ); ?>" 
                           placeholder="0712 345 678 or 2547..." 
                           required 
                           class="w-full bg-white border border-[#E6DFD5] px-4 py-3 text-sm text-munar-black font-medium focus:outline-none focus:border-munar-gold" />
                </div>
                <p class="text-[11px] text-munar-muted leading-relaxed">
                    A prompt will appear instantly on this Safaricom phone requesting your 4-digit M-Pesa PIN for <strong class="text-munar-black">KSh <?php echo WC()->cart ? esc_html( number_format( (float) WC()->cart->get_total( 'edit' ), 2 ) ) : '0.00'; ?></strong>.
                </p>
            </fieldset>
            <?php
        }

        public function validate_fields() {
            if ( empty( $_POST['munar_mpesa_phone'] ) ) {
                wc_add_notice( __( 'Please provide a valid Safaricom phone number for M-Pesa payment.', 'munar-daraja-mpesa' ), 'error' );
                return false;
            }
            $phone = preg_replace( '/[^0-9]/', '', sanitize_text_field( $_POST['munar_mpesa_phone'] ) );
            if ( strlen( $phone ) < 9 ) {
                wc_add_notice( __( 'The provided phone number is too short for Safaricom M-Pesa.', 'munar-daraja-mpesa' ), 'error' );
                return false;
            }
            return true;
        }

        public function process_payment( $order_id ) {
            $order = wc_get_order( $order_id );
            $raw_phone = sanitize_text_field( $_POST['munar_mpesa_phone'] );
            $phone = $this->format_phone( $raw_phone );

            // Save phone to order meta
            $order->update_meta_data( '_munar_mpesa_phone', $phone );

            // Status set to Pending Payment (not Processing/Completed) while awaiting PIN authorization
            $order->update_status( 'pending', sprintf( __( 'Lipa na M-Pesa STK Push dispatched to %s. Awaiting patron PIN confirmation.', 'munar-daraja-mpesa' ), $phone ) );

            // Dispatch live STK Push if API credentials exist
            $stk_result = $this->send_stk_push( $order, $phone );

            if ( is_wp_error( $stk_result ) ) {
                $order->add_order_note( sprintf( __( 'Daraja STK Push Notice: %s', 'munar-daraja-mpesa' ), $stk_result->get_error_message() ) );
            } else {
                if ( ! empty( $stk_result['CheckoutRequestID'] ) ) {
                    $order->update_meta_data( '_munar_mpesa_checkout_id', $stk_result['CheckoutRequestID'] );
                    $order->add_order_note( sprintf( __( 'M-Pesa STK Request Sent. CheckoutRequestID: %s', 'munar-daraja-mpesa' ), $stk_result['CheckoutRequestID'] ) );
                }
            }

            $order->save();

            // Reduce stock levels
            wc_reduce_stock_levels( $order_id );

            // Empty shopping cart
            WC()->cart->empty_cart();

            // Redirect to Order Received thank you page
            return array(
                'result'   => 'success',
                'redirect' => $this->get_return_url( $order ),
            );
        }

        /**
         * Dispatch Daraja STK Push Request
         */
        private function send_stk_push( $order, $phone ) {
            if ( empty( $this->consumer_key ) || empty( $this->consumer_sec ) ) {
                // In demo / staging mode without API keys configured:
                return new WP_Error( 'demo_mode', __( 'Demo Mode: API keys not configured. Order placed in Pending Payment status.', 'munar-daraja-mpesa' ) );
            }

            $token = $this->get_oauth_token();
            if ( is_wp_error( $token ) ) {
                return $token;
            }

            $base_url = ( 'production' === $this->environment )
                ? 'https://api.safaricom.co.ke'
                : 'https://sandbox.safaricom.co.ke';

            $timestamp = date( 'YmdHis' );
            $password  = base64_encode( $this->shortcode . $this->passkey . $timestamp );
            $amount    = (int) ceil( (float) $order->get_total() );

            $callback_url = ! empty( $this->custom_callback_url )
                ? $this->custom_callback_url
                : add_query_arg( 'wc-api', 'munar_mpesa_callback', home_url( '/' ) );

            $payload = array(
                'BusinessShortCode' => $this->shortcode,
                'Password'          => $password,
                'Timestamp'         => $timestamp,
                'TransactionType'   => 'CustomerPayBillOnline',
                'Amount'            => $amount,
                'PartyA'            => $phone,
                'PartyB'            => $this->shortcode,
                'PhoneNumber'       => $phone,
                'CallBackURL'       => $callback_url,
                'AccountReference'  => 'Munar MNR-' . $order->get_id(),
                'TransactionDesc'   => 'Munar Luxury Atelier Order ' . $order->get_id(),
            );

            $response = wp_remote_post( $base_url . '/mpesa/stkpush/v1/processrequest', array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ),
                'body'    => wp_json_encode( $payload ),
                'timeout' => 30,
            ) );

            if ( is_wp_error( $response ) ) {
                return $response;
            }

            $response_code = wp_remote_retrieve_response_code( $response );
            $raw_body      = wp_remote_retrieve_body( $response );
            $body          = json_decode( $raw_body, true );

            if ( $response_code !== 200 || ! empty( $body['errorCode'] ) ) {
                $err_msg = ! empty( $body['errorMessage'] ) ? $body['errorMessage'] : ( ! empty( $body['ResponseDescription'] ) ? $body['ResponseDescription'] : 'HTTP Error ' . $response_code );
                return new WP_Error( 'daraja_api_error', $err_msg . ' (Code: ' . ( $body['errorCode'] ?? $response_code ) . ')' );
            }

            if ( isset( $body['ResponseCode'] ) && $body['ResponseCode'] !== '0' ) {
                return new WP_Error( 'stk_rejected', $body['ResponseDescription'] ?? 'Request rejected by Safaricom' );
            }

            return $body;
        }

        /**
         * Fetch or retrieve cached OAuth Access Token
         */
        private function get_oauth_token() {
            $transient_key = 'munar_daraja_token_' . $this->environment;
            $cached_token  = get_transient( $transient_key );

            if ( $cached_token ) {
                return $cached_token;
            }

            $base_url = ( 'production' === $this->environment )
                ? 'https://api.safaricom.co.ke'
                : 'https://sandbox.safaricom.co.ke';

            $credentials = base64_encode( $this->consumer_key . ':' . $this->consumer_sec );

            $response = wp_remote_get( $base_url . '/oauth/v1/generate?grant_type=client_credentials', array(
                'headers' => array(
                    'Authorization' => 'Basic ' . $credentials,
                ),
                'timeout' => 20,
            ) );

            if ( is_wp_error( $response ) ) {
                return $response;
            }

            $body = json_decode( wp_remote_retrieve_body( $response ), true );

            if ( ! empty( $body['access_token'] ) ) {
                // Cache token for 50 minutes (Daraja tokens typically expire in 3600 seconds)
                set_transient( $transient_key, $body['access_token'], 3000 );
                return $body['access_token'];
            }

            return new WP_Error( 'token_error', __( 'Failed to authenticate with Safaricom Daraja API. Please verify Consumer Key and Secret.', 'munar-daraja-mpesa' ) );
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

        /**
         * Handle Webhook Callbacks from Safaricom
         */
        public function handle_mpesa_callback() {
            $callback_json = file_get_contents( 'php://input' );
            $data = json_decode( $callback_json, true );

            if ( ! empty( $data['Body']['stkCallback'] ) ) {
                $stk         = $data['Body']['stkCallback'];
                $result_code = isset( $stk['ResultCode'] ) ? (int) $stk['ResultCode'] : -1;
                $result_desc = isset( $stk['ResultDesc'] ) ? sanitize_text_field( $stk['ResultDesc'] ) : '';
                $checkout_id = isset( $stk['CheckoutRequestID'] ) ? sanitize_text_field( $stk['CheckoutRequestID'] ) : '';

                // Locate matching order by checkout request ID
                $orders = wc_get_orders( array(
                    'meta_key'   => '_munar_mpesa_checkout_id',
                    'meta_value' => $checkout_id,
                    'limit'      => 1,
                ) );

                if ( ! empty( $orders ) ) {
                    $order = $orders[0];

                    if ( $result_code === 0 ) {
                        // Success ResultCode 0
                        $receipt_number = '';
                        if ( ! empty( $stk['CallbackMetadata']['Item'] ) ) {
                            foreach ( $stk['CallbackMetadata']['Item'] as $item ) {
                                if ( 'MpesaReceiptNumber' === $item['Name'] ) {
                                    $receipt_number = sanitize_text_field( $item['Value'] );
                                }
                            }
                        }

                        $order->payment_complete( $receipt_number );
                        $order->update_status( 'processing', sprintf( __( 'Lipa na M-Pesa Confirmed. Receipt: %s', 'munar-daraja-mpesa' ), $receipt_number ) );
                        $order->add_order_note( sprintf( __( 'Safaricom M-Pesa Payment Received! Transaction Receipt: %s, Description: %s', 'munar-daraja-mpesa' ), $receipt_number, $result_desc ) );
                    } else {
                        // User cancelled, wrong PIN, or insufficient funds
                        $order->update_status( 'failed', sprintf( __( 'M-Pesa payment failed/cancelled: %s (Code: %d)', 'munar-daraja-mpesa' ), $result_desc, $result_code ) );
                    }
                }
            }

            wp_send_json_success( array( 'status' => 'Callback processed' ) );
        }

        public function register_rest_callback() {
            register_rest_route( 'daraja/v1', '/callback', array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'handle_mpesa_callback' ),
                'permission_callback' => '__return_true',
            ) );
        }

        /**
         * Custom instructions on Thank You page
         */
        public function thankyou_page_instructions( $order_id ) {
            $order = wc_get_order( $order_id );
            if ( ! $order ) {
                return;
            }

            $phone = $order->get_meta( '_munar_mpesa_phone' );
            $status = $order->get_status();
            ?>
            <div class="my-8 p-6 bg-[#FAF7F2] border border-[#E5E0D8] rounded-sm space-y-4">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-full <?php echo ( 'processing' === $status || 'completed' === $status ) ? 'bg-emerald-600' : 'bg-munar-gold'; ?> text-white flex items-center justify-center font-bold text-xs">
                        <?php echo ( 'processing' === $status || 'completed' === $status ) ? '✓' : '⚡'; ?>
                    </span>
                    <div>
                        <h4 class="font-editorial text-xl font-medium text-munar-black">
                            <?php if ( 'processing' === $status || 'completed' === $status ) : ?>
                                M-Pesa Payment Confirmed
                            <?php else : ?>
                                M-Pesa PIN Authorization Dispatched
                            <?php endif; ?>
                        </h4>
                        <p class="text-xs text-munar-muted">
                            Order #<?php echo esc_html( $order->get_order_number() ); ?> &bull; Total: KSh <?php echo esc_html( number_format( (float) $order->get_total(), 2 ) ); ?>
                        </p>
                    </div>
                </div>

                <?php if ( 'pending' === $status || 'on-hold' === $status ) : ?>
                    <p class="text-xs text-munar-dark/80 leading-relaxed font-light">
                        An STK PIN prompt was sent to your phone (<strong><?php echo esc_html( $phone ? $phone : 'registered number' ); ?></strong>). Please unlock your phone and input your M-Pesa PIN. As soon as payment clears, your atelier order will automatically advance to production.
                    </p>
                    <div class="pt-2 flex items-center space-x-3 text-xs">
                        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="btn-munar-primary py-2 px-4 text-[10px]">
                            Retry M-Pesa Payment
                        </a>
                        <a href="https://wa.me/254700000000?text=Hello%20Munar,%20inquiring%20about%20Order%20%23<?php echo esc_attr( $order->get_order_number() ); ?>" target="_blank" class="text-xs text-munar-muted hover:text-munar-black underline">
                            Contact Concierge
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
    }

    // Register gateway into WooCommerce
    add_filter( 'woocommerce_payment_gateways', function( $gateways ) {
        $gateways[] = 'WC_Gateway_Munar_Mpesa';
        return $gateways;
    } );
}
