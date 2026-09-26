<?php
/**
 * Munar Luxury AI Concierge Engine & REST/AJAX Handler
 *
 * Provides intelligent, context-aware luxury styling advice, live catalog search,
 * rich visual product recommendations, out-of-domain query handling, and polite conversational etiquette.
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
 * Helper to render mini product cards inside chat messages
 */
function munar_render_chat_product_card( $product_id ) {
    $product = wc_get_product( $product_id );
    if ( ! $product ) {
        return '';
    }

    $title    = $product->get_name();
    $price    = $product->get_price_html();
    $link     = $product->get_permalink();
    $hero_img = get_post_meta( $product_id, '_munar_hero_image_url', true );
    
    if ( has_post_thumbnail( $product_id ) ) {
        $img_html = get_the_post_thumbnail( $product_id, 'thumbnail', array( 'class' => 'w-12 h-14 object-cover rounded-sm flex-shrink-0' ) );
    } elseif ( ! empty( $hero_img ) ) {
        $img_html = '<img src="' . esc_url( $hero_img ) . '" alt="' . esc_attr( $title ) . '" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />';
    } else {
        $img_html = '<div class="w-12 h-14 bg-munar-sand flex items-center justify-center text-[10px] text-munar-muted rounded-sm flex-shrink-0">Munar</div>';
    }

    return sprintf(
        '<div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
            %s
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-semibold text-munar-black truncate">%s</p>
                <p class="text-[10px] text-munar-gold font-bold mt-0.5">%s</p>
                <a href="%s" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
            </div>
        </div>',
        $img_html,
        esc_html( $title ),
        $price,
        esc_url( $link )
    );
}

/**
 * Process query with comprehensive contextual matching and luxury persona
 */
function munar_process_concierge_query( $query ) {
    $clean_query = strtolower( trim( $query ) );

    // Normalize common typos (e.g. finf -> find, thabk -> thank)
    $normalized = preg_replace( '/\b(finf|fnd)\b/i', 'find', $clean_query );
    $normalized = preg_replace( '/\b(thabk|thx|thanx|tnx)\b/i', 'thank', $normalized );

    // 1. Gratitude, Thanks & Polite Sign-offs
    if ( preg_match( '/\b(thank|thanks|appreciate|grateful|asante|merci)\b/i', $normalized ) ||
         preg_match( '/^(no\s*thank|no\s*thanks|good\s*thank|all\s*good|that\s*is\s*all|bye|goodbye)[\s!.]*$/i', $normalized ) ) {
        $thank_replies = array(
            "You are most welcome! It is our absolute pleasure at Munar Atelier. If you need any further styling advice or wish to schedule a private fitting in Westlands, we are always at your service.",
            "My pleasure! May your day be as distinguished as our couture. Reach out anytime you wish to explore new arrivals or curated looks.",
            "Always a pleasure. Enjoy discovering the collection, and feel free to reach out whenever you need bespoke styling guidance."
        );
        return array(
            'reply' => $thank_replies[ array_rand( $thank_replies ) ],
            'type'  => 'gratitude',
        );
    }

    // 2. Affirmations & Acknowledgments (ok, sounds good, cool, understood)
    if ( preg_match( '/^(ok|okay|alright|sure|sounds\s*good|cool|perfect|noted|understood|sawa)[\s!.]*$/i', $normalized ) ) {
        return array(
            'reply' => "Splendid! Let me know if you would like to explore our Women's Atelier, Men's Sartorial pieces, Haute Leather Goods, or book a private fitting.",
            'type'  => 'affirmation',
        );
    }

    // 3. True Out-of-Domain Guardrails (Coding, Math, Cooking recipes, Weather, Politics)
    // NOTE: Does NOT block fashion/occasion terms like dinner, evening, party, gala!
    $strict_off_topic = array(
        '/\b(how\s*to\s*cook|recipe|bake\s*cake|pizza|burger|fast\s*food)\b/i',
        '/\b(weather\s*forecast|rain\s*today|temperature|climate\s*change)\b/i',
        '/\b(python|javascript|php\s*code|algorithm|software\s*bug|github\s*issue)\b/i',
        '/\b(football\s*score|premier\s*league|nba\s*score|champions\s*league)\b/i',
        '/\b(election|parliament|president|politics|political\s*party)\b/i',
        '/\b(calculate|solve\s*equation|integral|calculus|math\s*problem)\b/i',
    );

    foreach ( $strict_off_topic as $pattern ) {
        if ( preg_match( $pattern, $normalized ) ) {
            return array(
                'reply' => "While I would love to chat about that, as your Munar Atelier Stylist my focus is strictly dedicated to luxury fashion, bespoke tailoring, and our curated Nairobi collections. May I guide you through our runway evening gowns, sartorial blazers, or handcrafted leather goods?",
                'type'  => 'guardrail_redirect',
            );
        }
    }

    // 4. Greetings & Welcomes
    if ( preg_match( '/^(hi|hello|hey|greetings|good\s*(morning|afternoon|evening)|salut|habari|jambo|sup)[\s!.]*$/i', $normalized ) ) {
        return array(
            'reply' => "Good day. Welcome to Munar Luxury Atelier Nairobi. I am your personal couture stylist. How may I elevate your wardrobe today? You can ask me to view Men's or Women's collections, request dinner & gala outfit pairings, inquire about leather bags, or book a bespoke fitting.",
            'type'  => 'greeting',
        );
    }

    // 5. Picture / Photo / Visual Showcase Requests
    if ( preg_match( '/\b(picture|pictures|photo|photos|image|images|show\s*me|see|look\s*like|send\s*me)\b/i', $normalized ) &&
         ! preg_match( '/\b(track|order|delivery)\b/i', $normalized ) ) {
        
        $cards  = munar_render_chat_product_card( 204 ); // Silk Gown
        $cards .= munar_render_chat_product_card( 205 ); // Wool Blazer
        $cards .= munar_render_chat_product_card( 206 ); // Calfskin Tote
        $cards .= munar_render_chat_product_card( 208 ); // Gold Cuff

        return array(
            'reply' => "Here is a curated glimpse of our signature runway pieces currently available in the atelier:<br>" . $cards . "<p class='mt-2 text-xs'>You can click any piece to view full sizing details and runway photos, or visit our <a href='" . esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/') ) . "' class='text-munar-gold underline font-medium'>Full Collections Catalog</a>.</p>",
            'type'  => 'visual_showcase',
        );
    }

    // 6. Men's Wear & Sartorial Tailoring (e.g. "find for me mens wear", "men's clothes", "blazers for men")
    if ( preg_match( '/\b(men|mens|men\'s|gentleman|gentlemen|sartorial|blazer|turtleneck|suit|suits|trousers)\b/i', $normalized ) ) {
        $cards  = munar_render_chat_product_card( 205 ); // Milano Wool Blazer
        $cards .= munar_render_chat_product_card( 209 ); // Cashmere Turtleneck
        $cards .= munar_render_chat_product_card( 210 ); // Leather Travel Duffle

        return array(
            'reply' => "Here are our signature Men's Sartorial pieces tailored for modern distinction:<br>" . $cards . "<p class='mt-2 text-xs'>Each piece is handcrafted from premium wool and fine cashmere. We also provide bespoke fitting adjustments at our Westlands studio.</p>",
            'type'  => 'mens_wear',
        );
    }

    // 7. Women's Wear & Haute Couture (e.g. "women clothes", "gowns", "dresses", "silk gown")
    if ( preg_match( '/\b(women|womens|women\'s|lady|ladies|gown|gowns|dress|dresses|skirt|couture|trench)\b/i', $normalized ) ) {
        $cards  = munar_render_chat_product_card( 204 ); // Silk Evening Gown
        $cards .= munar_render_chat_product_card( 207 ); // Belted Trench Coat
        $cards .= munar_render_chat_product_card( 206 ); // Calfskin Monogram Tote

        return array(
            'reply' => "Here are our highlighted Women's Atelier runway creations:<br>" . $cards . "<p class='mt-2 text-xs'>Crafted with ethically sourced mulberry silk and pure cashmere, designed to command presence.</p>",
            'type'  => 'womens_wear',
        );
    }

    // 8. Occasions: Dinner, Gala, Evening, Wedding, Cocktail, Date Night
    if ( preg_match( '/\b(dinner|gala|evening|wedding|cocktail|date\s*night|party|event|black\s*tie|soiree|reception)\b/i', $normalized ) ) {
        $cards  = munar_render_chat_product_card( 204 ); // Silk Evening Gown
        $cards .= munar_render_chat_product_card( 208 ); // Gold Cuff
        $cards .= munar_render_chat_product_card( 205 ); // Wool Blazer

        return array(
            'reply' => "For an exquisite dinner or evening affair, our stylists recommend these standout ensembles:<br>" . $cards . "<p class='mt-2 text-xs'>Pair <b>The Sovereign Silk Evening Gown</b> with the <b>Aura 18K Gold Cuff</b> for effortless radiance. For gentlemen, the <b>Milano Double-Breasted Wool Blazer</b> delivers timeless sartorial sharpness.</p>",
            'type'  => 'occasion_styling',
        );
    }

    // 9. Handcrafted Leather Bags & Travel Goods
    if ( preg_match( '/\b(bag|bags|tote|duffle|leather|calfskin|handbag|purse|luggage|travel\s*bag)\b/i', $normalized ) ) {
        $cards  = munar_render_chat_product_card( 206 ); // Calfskin Tote
        $cards .= munar_render_chat_product_card( 210 ); // Travel Duffle

        return array(
            'reply' => "Our leather artifacts are handcrafted from full-grain Tuscan calfskin with custom brass hardware:<br>" . $cards . "<p class='mt-2 text-xs'>Both pieces are in stock at our atelier with complimentary nationwide delivery.</p>",
            'type'  => 'leather_goods',
        );
    }

    // 10. Fine Jewelry & Timepieces
    if ( preg_match( '/\b(jewelry|jewellery|gold|cuff|ring|rings|sapphire|cufflink|signet|accessory|accessories)\b/i', $normalized ) ) {
        $cards  = munar_render_chat_product_card( 208 ); // Gold Cuff
        $cards .= munar_render_chat_product_card( 211 ); // Sapphire Signet Ring

        return array(
            'reply' => "Our Fine Jewelry & Timepiece collection features hand-cast 18K gold and precious gemstones:<br>" . $cards,
            'type'  => 'fine_jewelry',
        );
    }

    // 11. Size, Fitting & Bespoke Atelier Appointment
    if ( preg_match( '/\b(size|sizing|fit|fitting|measure|measurements|tailor|bespoke|custom|alteration|appointment|westlands|visit)\b/i', $normalized ) ) {
        return array(
            'reply' => "Our ready-to-wear pieces follow precision UK/EU sizing (XS to XL, and 38R–44R for sartorial tailoring).<br><br>For our patrons in Nairobi, we offer <b>complimentary private fitting sessions</b> and bespoke adjustments at our Westlands Atelier.<br><br><a href='" . esc_url( home_url('/contact/') ) . "' class='btn-munar-gold text-[10px] py-1.5 px-3 inline-block'>Book Atelier Fitting</a> or message us directly on WhatsApp.",
            'type'  => 'fitting_advice',
        );
    }

    // 12. Lipa na M-Pesa & Payment
    if ( preg_match( '/\b(mpesa|m-pesa|lipa|payment|pay|card|currency|daraja|stk|checkout|visa|mastercard)\b/i', $normalized ) ) {
        return array(
            'reply' => "We provide seamless, encrypted checkout via <b>Safaricom Lipa na M-Pesa STK Push</b>. Simply enter your mobile number at checkout and an instant PIN prompt will appear on your phone. We also accept Visa, Mastercard, and Cash on Fitting.",
            'type'  => 'payment_info',
        );
    }

    // 13. Order Tracking & Delivery
    if ( preg_match( '/\b(track|tracking|order|shipment|delivery|dispatch|courier|mnr-)\b/i', $normalized ) ) {
        return array(
            'reply' => "We offer complimentary <b>White-Glove VIP Courier delivery</b> across Kenya on orders over KSh 15,000 (same-day or next-day in Nairobi).<br><br>To track an existing dispatch, please share your 6-digit Order Reference (e.g. <b>#MNR-1042</b>) or message our concierge desk on WhatsApp.",
            'type'  => 'shipping_info',
        );
    }

    // 14. Dynamic Catalog Keyword Search (Fallback for specific product terms)
    $matched = munar_search_catalog_products( $clean_query );
    if ( ! empty( $matched ) ) {
        $cards = '';
        foreach ( $matched as $pid ) {
            $cards .= munar_render_chat_product_card( $pid );
        }
        return array(
            'reply' => "I found these matching pieces in our atelier catalog:<br>" . $cards,
            'type'  => 'catalog_search',
        );
    }

    // 15. Intelligent Default Guidance
    return array(
        'reply' => "As your Munar Atelier Stylist, I am here to assist your wardrobe. Would you like me to show you:<br><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Show me mens wear'>Men's Sartorial Tailoring</a><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Show me womens wear'>Women's Haute Couture Gowns</a><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Show me leather bags'>Handcrafted Leather Bags</a><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Book private fitting'>Bespoke Fitting in Westlands</a>",
        'type'  => 'general_assistance',
    );
}

/**
 * Search product IDs by keyword
 */
function munar_search_catalog_products( $keyword ) {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return array();
    }

    $args = array(
        'status' => 'publish',
        'limit'  => 3,
        's'      => $keyword,
        'return' => 'ids',
    );

    return wc_get_products( $args );
}
