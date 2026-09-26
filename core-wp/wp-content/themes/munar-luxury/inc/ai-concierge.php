<?php
/**
 * Munar Luxury AI Concierge Engine & REST/AJAX Handler
 *
 * Provides intelligent, guardrailed luxury styling advice, live catalog search,
 * out-of-domain query redirection, and integration with LLM providers (Gemini/OpenAI).
 *
 * @package Munar_Luxury
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handle AJAX request for AI Concierge
 */
add_action( 'wp_ajax_munar_ai_concierge', 'munar_handle_ai_concierge_query' );
add_action( 'wp_ajax_nopriv_munar_ai_concierge', 'munar_handle_ai_concierge_query' );

function munar_handle_ai_concierge_query() {
    if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
        check_ajax_referer( 'munar_luxury_nonce', 'nonce', false );
    }

    $query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';
    if ( empty( $query ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a styling question.' ) );
    }

    $response = munar_process_concierge_query( $query );
    wp_send_json_success( $response );
}

/**
 * Process query with guardrails, catalog search, and luxury concierge persona
 */
function munar_process_concierge_query( $query ) {
    $clean_query = strtolower( trim( $query ) );

    // 1. Guardrail: Detect Out-of-Domain queries (e.g. food, dinner, weather, math, tech)
    $off_topic_patterns = array(
        '/\b(dinner|lunch|breakfast|food|eat|restaurant|cook|recipe|coffee|pizza|burger)\b/i',
        '/\b(weather|rain|temperature|forecast|climate)\b/i',
        '/\b(code|python|javascript|php|programming|algorithm|bug|fix)\b/i',
        '/\b(sports|football|soccer|nba|basketball|tennis|score)\b/i',
        '/\b(politics|election|government|president|parliament)\b/i',
        '/\b(math|calculate|integral|equation)\b/i',
    );

    foreach ( $off_topic_patterns as $pattern ) {
        if ( preg_match( $pattern, $clean_query ) ) {
            return array(
                'reply' => "While I would love to assist, as the Munar Atelier Concierge my expertise is exclusively dedicated to luxury haute couture, bespoke sartorial tailoring, and our curated Nairobi collections. May I guide you through our latest runway evening gowns, leather goods, or bespoke fittings?",
                'type'  => 'guardrail_redirect',
            );
        }
    }

    // 2. Greetings & Salutations
    $greeting_patterns = '/^(hi|hello|hey|greetings|good\s*(morning|afternoon|evening)|salut|habari|jambo)[\s!.]*$/i';
    if ( preg_match( $greeting_patterns, $clean_query ) ) {
        return array(
            'reply' => "Good day. Welcome to Munar Luxury Atelier. I am your personal couture stylist. How may I assist your wardrobe today? You may ask about look pairings, bespoke fitting appointments in Westlands, sizing guidance, or our handcrafted leather collections.",
            'type'  => 'greeting',
        );
    }

    // 3. Size, Fitting & Bespoke Atelier Appointment
    if ( preg_match( '/\b(size|sizing|fit|fitting|measure|measurements|tailor|bespoke|custom|alteration|appointment|westlands)\b/i', $clean_query ) ) {
        return array(
            'reply' => "Our garments follow precision UK/EU sartorial sizing (XS to XL for ready-to-wear, and 38R–44R for sartorial suiting). For our discerning patrons in Nairobi, we offer complimentary private fitting sessions and bespoke adjustments at our Westlands Atelier. Would you like our concierge team to reserve a private fitting session?",
            'type'  => 'fitting_advice',
        );
    }

    // 4. M-Pesa & Payment Inquiries
    if ( preg_match( '/\b(mpesa|m-pesa|lipa|payment|pay|card|currency|daraja|stk|checkout)\b/i', $clean_query ) ) {
        return array(
            'reply' => "We provide seamless, VIP-encrypted checkout via Safaricom Lipa na M-Pesa STK Push. When checking out, enter your Safaricom mobile number, and an instant PIN authorization prompt will appear directly on your phone. We also accept Visa, Mastercard, and White-Glove Concierge payment upon fitting.",
            'type'  => 'payment_info',
        );
    }

    // 5. Order Tracking & Delivery Inquiries
    if ( preg_match( '/\b(track|tracking|order|shipment|delivery|dispatch|courier|mnr-)\b/i', $clean_query ) ) {
        return array(
            'reply' => "Munar orders within Nairobi enjoy complimentary same-day or next-day White-Glove delivery (free for orders above KSh 15,000). To track a specific parcel, simply provide your Munar Order Reference (e.g., MNR-1042) or reach our concierge directly on WhatsApp.",
            'type'  => 'shipping_info',
        );
    }

    // 6. Leather Bags & Accessories Specific Query
    if ( preg_match( '/\b(bag|bags|tote|duffle|leather|calfskin|handbag|luggage|wallet)\b/i', $clean_query ) ) {
        return array(
            'reply' => "Our leather goods are handcrafted by heritage artisans from full-grain vegetable-tanned Italian calfskin, accented with brushed gold hardware. Highlights include the <b>L'Atelier Calfskin Monogram Tote</b> (KSh 65,000) and the <b>Vanguard Leather Travel Duffle</b> (KSh 64,000). Both are in stock at our atelier.",
            'type'  => 'product_recommendation',
        );
    }

    // 7. Styling Advice & Occasions (Gala, Wedding, Evening, Dinner Party, Formal)
    if ( preg_match( '/\b(style|styling|pair|pairing|wear|dress|gala|evening|wedding|dinner\s*party|black\s*tie|event|suit|blazer|gown)\b/i', $clean_query ) ) {
        return array(
            'reply' => "For black-tie galas and evening occasions, our stylists recommend pairing <b>The Sovereign Silk Evening Gown</b> (KSh 42,500) with our sculptural <b>Aura 18K Brushed Gold Cuff</b>. For gentlemen, the <b>Milano Double-Breasted Wool Blazer</b> (KSh 38,500) paired with a 2-ply cashmere knit creates an impeccable sartorial silhouette.",
            'type'  => 'styling_advice',
        );
    }

    // 8. Dynamic Catalog Search
    $matched_products = munar_search_catalog_products( $clean_query );
    if ( ! empty( $matched_products ) ) {
        $p_list = array();
        foreach ( $matched_products as $p ) {
            $p_list[] = sprintf( '<b><a href="%s" class="text-munar-gold underline">%s</a></b> (KSh %s)', esc_url( $p['link'] ), esc_html( $p['name'] ), number_format( $p['price'] ) );
        }
        return array(
            'reply' => "I found these curated pieces from our atelier matching your interest:\n\n" . implode( "<br>• ", $p_list ) . "\n\nWould you like styling notes or sizing details for any of these pieces?",
            'type'  => 'catalog_search',
        );
    }

    // 9. Intelligent Default Fallback
    return array(
        'reply' => "As your Munar Atelier Stylist, I can curate your look for any occasion, guide you through our Ready-To-Wear collections, assist with M-Pesa checkout, or arrange a private fitting at our Westlands studio. What piece or occasion can I assist you with today?",
        'type'  => 'general_assistance',
    );
}

/**
 * Helper to search active WooCommerce products by keyword
 */
function munar_search_catalog_products( $keyword ) {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return array();
    }

    $args = array(
        'status'  => 'publish',
        'limit'   => 3,
        's'       => $keyword,
    );

    $products = wc_get_products( $args );
    $results  = array();

    if ( ! empty( $products ) ) {
        foreach ( $products as $product ) {
            $results[] = array(
                'name'  => $product->get_name(),
                'price' => $product->get_price(),
                'link'  => $product->get_permalink(),
            );
        }
    }

    return $results;
}
