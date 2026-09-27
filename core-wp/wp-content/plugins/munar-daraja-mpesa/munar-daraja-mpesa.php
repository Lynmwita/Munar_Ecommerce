<?php
/**
 * Plugin Name: Munar Lipa na M-Pesa Payment Gateway (Send Money & STK)
 * Plugin URI: https://github.com/lynnaz/Munar_Ecommerce
 * Description: Bespoke Lipa na M-Pesa payment gateway for Munar Luxury Atelier supporting Direct Send Money to 0112855069, Pochi la Biashara, and optional Daraja STK Push.
 * Version: 2.0.0
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
            $this->method_title       = __( 'Lipa na M-Pesa (Send Money to 0112855069)', 'munar-daraja-mpesa' );
            $this->method_description = __( 'Direct M-Pesa Send Money payment to Munar Atelier (0112855069) with instant order verification.', 'munar-daraja-mpesa' );

            $this->supports = array(
                'products',
            );

            // Load settings schema & values
            $this->init_form_fields();
            $this->init_settings();

            // Gateway settings
            $this->title         = $this->get_option( 'title', 'Lipa na M-Pesa (Send Money)' );
            $this->description   = $this->get_option( 'description', 'Send payment directly via M-Pesa to 0112855069 (Munar Luxury Atelier).' );
            $this->enabled       = $this->get_option( 'enabled', 'yes' );
            $this->mpesa_number  = $this->get_option( 'mpesa_number', '0112855069' );
            $this->account_name  = $this->get_option( 'account_name', 'Munar Luxury Atelier' );
            $this->payment_type  = $this->get_option( 'payment_type', 'send_money' );

            // Save admin options
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

            // Thank-you page custom status display
            add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page_instructions' ) );

            // Customer email instructions
            add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
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
                    'default'     => __( 'Lipa na M-Pesa (Send Money to 0112855069)', 'munar-daraja-mpesa' ),
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => __( 'Description', 'munar-daraja-mpesa' ),
                    'type'        => 'textarea',
                    'description' => __( 'Payment description displayed during checkout.', 'munar-daraja-mpesa' ),
                    'default'     => __( 'Send payment directly via Safaricom M-Pesa to 0112855069. Your order will be confirmed immediately upon verification.', 'munar-daraja-mpesa' ),
                ),
                'mpesa_number' => array(
                    'title'       => __( 'M-Pesa Recipient Phone Number', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'description' => __( 'The Safaricom M-Pesa number to receive customer payments.', 'munar-daraja-mpesa' ),
                    'default'     => '0112855069',
                ),
                'account_name' => array(
                    'title'       => __( 'Recipient / Account Name', 'munar-daraja-mpesa' ),
                    'type'        => 'text',
                    'description' => __( 'Account or business name shown to customers (e.g. Munar Luxury Atelier).', 'munar-daraja-mpesa' ),
                    'default'     => 'Munar Luxury Atelier',
                ),
                'payment_type' => array(
                    'title'       => __( 'Payment Method Type', 'munar-daraja-mpesa' ),
                    'type'        => 'select',
                    'options'     => array(
                        'send_money' => __( 'Direct Send Money / Pochi la Biashara (0112855069)', 'munar-daraja-mpesa' ),
                        'buy_goods'  => __( 'Buy Goods / Till Number', 'munar-daraja-mpesa' ),
                        'paybill'    => __( 'Paybill Number', 'munar-daraja-mpesa' ),
                    ),
                    'default'     => 'send_money',
                ),
            );
        }

        public function payment_fields() {
            $total_amount = ( WC()->cart ) ? WC()->cart->get_total( 'edit' ) : 0;
            ?>
            <div class="p-5 bg-[#FAF7F2] border border-[#E6DFD5] rounded-sm space-y-4 text-xs text-munar-black">
                
                <!-- Payment Steps Card -->
                <div class="space-y-2 border-b border-[#E6DFD5] pb-4">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[11px] uppercase tracking-wider text-emerald-800 bg-emerald-100/70 px-2.5 py-1 rounded">
                            Safaricom M-Pesa Direct Transfer
                        </span>
                        <span class="text-xs font-semibold text-munar-mocha">
                            Recipient: <?php echo esc_html( $this->account_name ); ?>
                        </span>
                    </div>

                    <p class="text-munar-muted leading-relaxed pt-1">
                        Please follow these quick steps on your phone to complete your order payment:
                    </p>

                    <div class="bg-white p-3.5 border border-[#E6DFD5] rounded space-y-2 font-mono text-[11px]">
                        <div class="flex justify-between items-center">
                            <span class="text-munar-muted font-sans uppercase text-[10px] font-semibold">1. M-Pesa Menu:</span>
                            <span class="font-bold text-munar-black font-sans">Send Money</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-munar-muted font-sans uppercase text-[10px] font-semibold">2. Phone Number:</span>
                            <span class="font-bold text-emerald-700 text-sm tracking-widest bg-emerald-50 px-2 py-0.5 border border-emerald-200 rounded select-all cursor-pointer">
                                <?php echo esc_html( $this->mpesa_number ); ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-munar-muted font-sans uppercase text-[10px] font-semibold">3. Exact Amount:</span>
                            <span class="font-bold text-munar-black text-sm">
                                KSh <?php echo esc_html( number_format( (float) $total_amount, 2 ) ); ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-munar-muted font-sans uppercase text-[10px] font-semibold">4. Enter PIN:</span>
                            <span class="text-munar-muted font-sans">Authorize on your device</span>
                        </div>
                    </div>
                </div>

                <!-- Patron Verification Fields -->
                <div class="space-y-3 pt-1">
                    <div>
                        <label for="munar_sender_phone" class="block text-[11px] uppercase tracking-wider font-semibold text-munar-black mb-1">
                            Your Safaricom Phone Number <span class="text-munar-gold">*</span>
                        </label>
                        <input type="tel" 
                               id="munar_sender_phone" 
                               name="munar_sender_phone" 
                               placeholder="e.g. 0712 345 678 or 0112 855 069" 
                               required 
                               class="w-full bg-white border border-[#E6DFD5] px-3.5 py-2.5 text-xs text-munar-black font-medium focus:outline-none focus:border-munar-gold" />
                    </div>

                    <div>
                        <label for="munar_mpesa_code" class="block text-[11px] uppercase tracking-wider font-semibold text-munar-black mb-1">
                            M-Pesa Transaction Code <span class="text-munar-muted text-[10px] font-normal">(e.g. QGH789KLM1 - optional if paying right now)</span>
                        </label>
                        <input type="text" 
                               id="munar_mpesa_code" 
                               name="munar_mpesa_code" 
                               placeholder="e.g. QGH789KLM1" 
                               class="w-full bg-white border border-[#E6DFD5] px-3.5 py-2.5 text-xs text-munar-black uppercase font-mono tracking-wider focus:outline-none focus:border-munar-gold" />
                    </div>

                    <p class="text-[10px] text-munar-muted leading-relaxed">
                        After sending, your order will be verified and prepared immediately. You can also send the confirmation SMS to our WhatsApp concierge.
                    </p>
                </div>

            </div>
            <?php
        }

        public function validate_fields() {
            if ( empty( $_POST['munar_sender_phone'] ) ) {
                wc_add_notice( __( 'Please provide your Safaricom phone number for M-Pesa payment verification.', 'munar-daraja-mpesa' ), 'error' );
                return false;
            }
            return true;
        }

        public function process_payment( $order_id ) {
            $order = wc_get_order( $order_id );
            $phone = sanitize_text_field( $_POST['munar_sender_phone'] );
            $code  = isset( $_POST['munar_mpesa_code'] ) ? sanitize_text_field( strtoupper( trim( $_POST['munar_mpesa_code'] ) ) ) : '';

            // Save metadata
            $order->update_meta_data( '_munar_mpesa_sender_phone', $phone );
            if ( ! empty( $code ) ) {
                $order->update_meta_data( '_munar_mpesa_receipt_code', $code );
            }

            // Set order status to on-hold awaiting transfer
            $note = sprintf(
                __( 'M-Pesa Send Money order placed. Customer Phone: %s | Transfer to %s (Munar Atelier).', 'munar-daraja-mpesa' ),
                $phone,
                $this->mpesa_number
            );

            if ( ! empty( $code ) ) {
                $note .= sprintf( __( ' Provided M-Pesa Code: %s.', 'munar-daraja-mpesa' ), $code );
            }

            $order->update_status( 'on-hold', $note );
            $order->add_order_note( $note );
            $order->save();

            // Reduce stock
            wc_reduce_stock_levels( $order_id );

            // Empty cart
            WC()->cart->empty_cart();

            // Redirect to thank you page
            return array(
                'result'   => 'success',
                'redirect' => $this->get_return_url( $order ),
            );
        }

        /**
         * Custom instructions on Thank You page
         */
        public function thankyou_page_instructions( $order_id ) {
            $order = wc_get_order( $order_id );
            if ( ! $order ) {
                return;
            }

            $phone = $order->get_meta( '_munar_mpesa_sender_phone' );
            $code  = $order->get_meta( '_munar_mpesa_receipt_code' );
            $total = number_format( (float) $order->get_total(), 2 );
            ?>
            <div class="my-8 p-6 sm:p-8 bg-[#FAF7F2] border border-[#E5E0D8] rounded-sm space-y-6">
                
                <div class="flex items-center space-x-3.5 pb-4 border-b border-[#E6DFD5]">
                    <span class="w-10 h-10 rounded-full bg-emerald-700 text-white flex items-center justify-center font-bold text-sm">
                        M
                    </span>
                    <div>
                        <h3 class="font-editorial text-2xl font-light text-munar-black">
                            M-Pesa Payment Instructions (Send Money)
                        </h3>
                        <p class="text-xs text-munar-muted">
                            Order #<?php echo esc_html( $order->get_order_number() ); ?> &bull; Total: <strong class="text-munar-black">KSh <?php echo esc_html( $total ); ?></strong>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="bg-white p-5 border border-[#E6DFD5] rounded-sm space-y-3 font-mono text-xs">
                        <p class="text-[11px] font-sans font-bold uppercase tracking-wider text-munar-gold pb-1 border-b border-gray-100">
                            Payment Transfer Details
                        </p>
                        <div class="flex justify-between">
                            <span class="text-munar-muted font-sans">Method:</span>
                            <span class="font-bold text-munar-black font-sans">M-Pesa &rarr; Send Money</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-munar-muted font-sans">Send to Number:</span>
                            <span class="font-bold text-emerald-700 text-sm tracking-wider bg-emerald-50 px-2 py-0.5 border border-emerald-200 rounded">
                                <?php echo esc_html( $this->mpesa_number ); ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-munar-muted font-sans">Recipient Name:</span>
                            <span class="font-semibold text-munar-black font-sans"><?php echo esc_html( $this->account_name ); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-munar-muted font-sans">Exact Amount:</span>
                            <span class="font-bold text-munar-black font-sans">KSh <?php echo esc_html( $total ); ?></span>
                        </div>
                        <?php if ( ! empty( $code ) ) : ?>
                            <div class="flex justify-between pt-2 border-t border-gray-100">
                                <span class="text-munar-muted font-sans">Your M-Pesa Code:</span>
                                <span class="font-bold text-emerald-700"><?php echo esc_html( $code ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-4 flex flex-col justify-between">
                        <div class="space-y-2 text-xs text-munar-dark/80 font-light leading-relaxed">
                            <p class="font-medium text-munar-black">Instant Atelier Verification:</p>
                            <p>
                                Once you have sent the payment on M-Pesa, our concierge desk in Westlands will automatically verify your transfer and begin packaging your luxury garment.
                            </p>
                        </div>

                        <div class="pt-2 space-y-2">
                            <a href="https://wa.me/254112855069?text=Hello%20Munar%20Atelier,%20I%20have%20sent%20payment%20of%20KSh%20<?php echo esc_attr( $total ); ?>%20for%20Order%20%23<?php echo esc_attr( $order->get_order_number() ); ?>.%20M-Pesa%20Phone:%20<?php echo esc_attr( $phone ); ?>" 
                               target="_blank" 
                               class="w-full bg-[#25D366] hover:bg-[#1EBE5B] text-white text-xs font-semibold py-3 px-4 rounded-sm flex items-center justify-center space-x-2 transition-colors">
                                <span>Verify via WhatsApp Concierge</span>
                            </a>
                            <p class="text-[10px] text-center text-munar-muted">
                                Fast WhatsApp verification: +254 (0) 112 855 069
                            </p>
                        </div>
                    </div>

                </div>

            </div>
            <?php
        }

        public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
            if ( $order->get_payment_method() !== $this->id ) {
                return;
            }
            $total = number_format( (float) $order->get_total(), 2 );
            echo "\n" . '--- M-PESA PAYMENT DETAILS ---' . "\n";
            echo 'Method: M-Pesa Send Money' . "\n";
            echo 'Send to Mobile Number: ' . $this->mpesa_number . ' (' . $this->account_name . ')' . "\n";
            echo 'Amount to Send: KSh ' . $total . "\n";
            echo 'Order Reference: #' . $order->get_order_number() . "\n";
            echo 'WhatsApp Verification: +254 112 855 069' . "\n\n";
        }
    }

    // Register gateway into WooCommerce list
    add_filter( 'woocommerce_payment_gateways', function( $gateways ) {
        $gateways[] = 'WC_Gateway_Munar_Mpesa';
        return $gateways;
    } );
}
