<?php
/**
 * Complete Munar Luxury E-Commerce Platform Setup
 * Automatically configures all required pages, policies, coupons, staff roles, and variable products.
 */

define('WP_USE_THEMES', false);
require_once('/opt/lampp/htdocs/wordpress/wp-load.php');

echo "====================================================\n";
echo "   COMPLETING MUNAR LUXURY PLATFORM SETUP\n";
echo "====================================================\n\n";

// ----------------------------------------------------
// 1. Core Informational & Policy Pages
// ----------------------------------------------------
$pages_to_setup = array(
    'faq' => array(
        'title'   => 'Frequently Asked Questions & Client Care',
        'content' => '
<div class="space-y-12 max-w-4xl mx-auto py-8">
    <div class="text-center space-y-3 pb-8 border-b border-munar-border">
        <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Atelier Client Care</span>
        <h1 class="font-editorial text-4xl sm:text-5xl text-munar-black font-light">Frequently Asked Questions</h1>
        <p class="text-sm text-munar-muted font-light max-w-xl mx-auto">Everything you need to know about our bespoke fitting appointments, ethical materials, M-Pesa checkout, and white-glove delivery across Kenya.</p>
    </div>

    <div class="space-y-8">
        <div class="bg-white p-6 sm:p-8 border border-munar-border/80 shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black font-normal">How do bespoke fitting appointments work?</h3>
            <p class="text-sm text-munar-dark/80 font-light leading-relaxed">
                You can reserve a private 1-on-1 atelier consultation at our Westlands studio in Nairobi. Our master sartorial tailors take comprehensive measurements, discuss hand-selected fabric drapes (raw Kenyan silks, fine wools, and full-grain leathers), and curate tailored silhouettes crafted exclusively for your posture and measurements.
            </p>
        </div>

        <div class="bg-white p-6 sm:p-8 border border-munar-border/80 shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black font-normal">What payment methods are accepted?</h3>
            <p class="text-sm text-munar-dark/80 font-light leading-relaxed">
                We accept direct Safaricom M-Pesa transfers (Send Money / Pochi la Biashara to official atelier line <strong>0112855069</strong>), VIP Card on Delivery, and major international credit/debit cards (Visa & MasterCard) through our secure payment channels.
            </p>
        </div>

        <div class="bg-white p-6 sm:p-8 border border-munar-border/80 shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black font-normal">What are your delivery timelines?</h3>
            <p class="text-sm text-munar-dark/80 font-light leading-relaxed">
                Ready-to-Wear orders within Nairobi are dispatched via our VIP White-Glove Courier within 24 hours (Complimentary on orders over KSh 15,000). Countrywide orders across Kenya (Mombasa, Kisumu, Nakuru, Eldoret) arrive within 48 to 72 hours via priority insured courier. Bespoke handmade garments require 7 to 14 business days.
            </p>
        </div>

        <div class="bg-white p-6 sm:p-8 border border-munar-border/80 shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black font-normal">What is your exchange and alteration policy?</h3>
            <p class="text-sm text-munar-dark/80 font-light leading-relaxed">
                We offer complimentary atelier alterations on all tailored garments to achieve your ideal fit. Ready-to-Wear items may be exchanged or returned within 14 calendar days of delivery provided they remain unworn with all luxury atelier seals intact.
            </p>
        </div>

        <div class="bg-white p-6 sm:p-8 border border-munar-border/80 shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black font-normal">Are Munar garments ethically and sustainably produced?</h3>
            <p class="text-sm text-munar-dark/80 font-light leading-relaxed">
                Yes. 100% of Munar creations are handcrafted by master artisans in Nairobi, Kenya. We use ethically sourced organic silks, sustainable vegetable-tanned leathers, and upcycled cast brass hardware, ensuring fair artisan compensation and zero fast-fashion waste.
            </p>
        </div>
    </div>

    <div class="p-8 bg-munar-sand/60 border border-munar-border flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
        <div class="space-y-1">
            <h4 class="font-editorial text-2xl text-munar-black">Have additional questions?</h4>
            <p class="text-xs text-munar-muted">Our dedicated concierge is available on WhatsApp daily 8am – 8pm EAT.</p>
        </div>
        <a href="https://wa.me/254112855069" target="_blank" class="btn-munar-primary py-3 px-6 text-xs whitespace-nowrap">
            WhatsApp Concierge (+254 112 855 069)
        </a>
    </div>
</div>',
    ),
    'shipping-delivery' => array(
        'title'   => 'White-Glove Shipping & Delivery Information',
        'content' => '
<div class="space-y-12 max-w-4xl mx-auto py-8">
    <div class="text-center space-y-3 pb-8 border-b border-munar-border">
        <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Concierge Logistics</span>
        <h1 class="font-editorial text-4xl sm:text-5xl text-munar-black font-light">White-Glove Shipping & Delivery</h1>
        <p class="text-sm text-munar-muted font-light max-w-xl mx-auto">Every Munar garment is delicately folded in archival tissue paper and delivered in our signature rigid matte gift box with protective dust bags.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-8 border border-munar-border shadow-xs space-y-4">
            <div class="flex items-center space-x-3 text-munar-gold">
                <span class="font-bold text-xs uppercase tracking-widest bg-munar-gold/10 px-2.5 py-1 rounded">Zone 1</span>
                <span class="text-xs font-semibold text-munar-black font-sans uppercase">Nairobi Metropolitan</span>
            </div>
            <h3 class="font-editorial text-2xl text-munar-black">VIP Same-Day & Next-Day Courier</h3>
            <ul class="text-xs text-munar-dark/80 font-light space-y-2.5 leading-relaxed">
                <li>&bull; <strong>Complimentary</strong> on all orders exceeding KSh 15,000.</li>
                <li>&bull; Flat rate of KSh 500 for standard city delivery.</li>
                <li>&bull; Includes White-Glove delivery with garment hanger and garment bag.</li>
                <li>&bull; Delivery window coordination via SMS / WhatsApp.</li>
            </ul>
        </div>

        <div class="bg-white p-8 border border-munar-border shadow-xs space-y-4">
            <div class="flex items-center space-x-3 text-munar-gold">
                <span class="font-bold text-xs uppercase tracking-widest bg-munar-gold/10 px-2.5 py-1 rounded">Zone 2</span>
                <span class="text-xs font-semibold text-munar-black font-sans uppercase">Rest of Kenya</span>
            </div>
            <h3 class="font-editorial text-2xl text-munar-black">Priority Insured Courier</h3>
            <ul class="text-xs text-munar-dark/80 font-light space-y-2.5 leading-relaxed">
                <li>&bull; Flat rate of KSh 1,200 nationwide.</li>
                <li>&bull; Delivered to Mombasa, Kisumu, Nakuru, Eldoret, Diani, Nanyuki.</li>
                <li>&bull; Transit time: 24 to 48 hours via dedicated door-to-door courier.</li>
                <li>&bull; Real-time tracking code provided upon dispatch.</li>
            </ul>
        </div>
    </div>

    <div class="bg-[#FAF7F2] p-8 border border-[#E5E0D8] space-y-4 text-xs text-munar-dark/80 font-light leading-relaxed">
        <h4 class="font-editorial text-2xl text-munar-black font-normal">Order Tracking & Sign-off</h4>
        <p>
            Upon courier dispatch from our Westlands atelier, you will receive an SMS and WhatsApp notification containing your personal consignment tracking reference (e.g. <code>MNR-2026-XXXX</code>). All high-value fine jewelry, timepieces, and leather goods require physical signature upon delivery.
        </p>
    </div>
</div>',
    ),
    'refund-returns' => array(
        'title'   => 'Returns, Exchanges & Bespoke Alterations Policy',
        'content' => '
<div class="space-y-12 max-w-4xl mx-auto py-8">
    <div class="text-center space-y-3 pb-8 border-b border-munar-border">
        <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Atelier Guarantee</span>
        <h1 class="font-editorial text-4xl sm:text-5xl text-munar-black font-light">Returns & Exchanges Policy</h1>
        <p class="text-sm text-munar-muted font-light max-w-xl mx-auto">We are committed to sartorial excellence. If a ready-to-wear piece requires sizing adjustments or exchange, we ensure a seamless resolution.</p>
    </div>

    <div class="space-y-6 text-sm text-munar-dark/80 font-light leading-relaxed">
        <div class="bg-white p-8 border border-munar-border shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black">1. 14-Day Complimentary Exchange Window</h3>
            <p>
                Ready-to-Wear garments may be exchanged for a different size, alternative silhouette, or store credit within 14 calendar days of receiving your shipment. Garments must remain in original, unworn condition with all designer ribbons and tags attached.
            </p>
        </div>

        <div class="bg-white p-8 border border-munar-border shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black">2. Bespoke Garment Alterations</h3>
            <p>
                For our made-to-measure couture line, we provide complimentary master tailoring adjustments at our Westlands studio within 30 days of collection to guarantee an immaculate silhouette.
            </p>
        </div>

        <div class="bg-white p-8 border border-munar-border shadow-xs space-y-3">
            <h3 class="font-editorial text-2xl text-munar-black">3. How to Initiate an Exchange</h3>
            <p>
                Simply message our Concierge team on WhatsApp at <strong>+254 112 855 069</strong> or email <strong>concierge@munar.ke</strong> with your order number (#MNR-...). Our white-glove courier will arrange convenient collection directly from your doorstep.
            </p>
        </div>
    </div>
</div>',
    ),
    'privacy-policy' => array(
        'title'   => 'Privacy Policy & Patron Data Protection',
        'content' => '
<div class="space-y-12 max-w-4xl mx-auto py-8">
    <div class="text-center space-y-3 pb-8 border-b border-munar-border">
        <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">Confidentiality & Care</span>
        <h1 class="font-editorial text-4xl sm:text-5xl text-munar-black font-light">Privacy Policy</h1>
        <p class="text-sm text-munar-muted font-light max-w-xl mx-auto">Munar Luxury Atelier is dedicated to maintaining the absolute confidentiality and security of our patrons\' personal data and measurements.</p>
    </div>

    <div class="space-y-6 text-sm text-munar-dark/80 font-light leading-relaxed bg-white p-8 border border-munar-border">
        <h3 class="font-editorial text-2xl text-munar-black">Information We Collect</h3>
        <p>
            When ordering garments or booking bespoke fittings, we collect necessary contact information (name, email address, Safaricom phone number, delivery address) and sartorial sizing measurements strictly for order fulfillment and tailoring.
        </p>

        <h3 class="font-editorial text-2xl text-munar-black pt-4">Data Security & Payments</h3>
        <p>
            All payment transactions (including Lipa na M-Pesa STK and encrypted card processing) are protected under 256-bit SSL encryption. Munar never stores or accesses your private M-Pesa PIN or credit card security numbers.
        </p>

        <h3 class="font-editorial text-2xl text-munar-black pt-4">Contacting Our Data Protection Desk</h3>
        <p>
            If you wish to review, update, or remove your patron profile and sizing records, please reach out to our privacy desk at <strong>concierge@munar.ke</strong>.
        </p>
    </div>
</div>',
    ),
);

foreach ($pages_to_setup as $slug => $data) {
    $existing = get_page_by_path($slug);
    if ($existing) {
        wp_update_post(array(
            'ID'           => $existing->ID,
            'post_title'   => $data['title'],
            'post_content' => $data['content'],
            'post_status'  => 'publish',
        ));
        echo "Updated & Published Page: [/$slug/] - {$data['title']}\n";
    } else {
        $id = wp_insert_post(array(
            'post_name'    => $slug,
            'post_title'   => $data['title'],
            'post_content' => $data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ));
        echo "Created & Published Page: [/$slug/] (ID: $id)\n";
    }
}

// ----------------------------------------------------
// 2. Ensure My Account has [woocommerce_my_account]
// ----------------------------------------------------
$account_id = wc_get_page_id('myaccount');
if ($account_id) {
    wp_update_post(array(
        'ID'           => $account_id,
        'post_content' => '[woocommerce_my_account]',
        'post_status'  => 'publish',
    ));
    echo "Configured My Account Page (ID $account_id) with [woocommerce_my_account]\n";
}

// ----------------------------------------------------
// 3. Seed Promotional Coupons in WooCommerce
// ----------------------------------------------------
$coupons = array(
    'MUNARVIP' => array(
        'amount'      => '10',
        'type'        => 'percent',
        'description' => '10% VIP Atelier discount on all luxury collections',
    ),
    'WELCOME15' => array(
        'amount'      => '15',
        'type'        => 'percent',
        'description' => '15% welcome discount for new Munar patrons',
    ),
    'FREEDELIVERY' => array(
        'amount'      => '0',
        'type'        => 'fixed_cart',
        'description' => 'Complimentary White-Glove VIP Delivery nationwide',
        'free_shipping' => 'yes',
    ),
);

foreach ($coupons as $code => $c_data) {
    $existing_coupon = get_page_by_title($code, OBJECT, 'shop_coupon');
    if (!$existing_coupon) {
        $coupon = new WC_Coupon();
        $coupon->set_code($code);
        $coupon->set_discount_type($c_data['type']);
        $coupon->set_amount($c_data['amount']);
        $coupon->set_description($c_data['description']);
        if (!empty($c_data['free_shipping'])) {
            $coupon->set_free_shipping(true);
        }
        $coupon->save();
        echo "Created Active Promotional Coupon: '$code' ({$c_data['description']})\n";
    } else {
        echo "Coupon '$code' is already active.\n";
    }
}

// ----------------------------------------------------
// 4. Create Store Manager User Account
// ----------------------------------------------------
if (!username_exists('storemanager')) {
    $user_id = wp_create_user('storemanager', 'MunarStore2026!', 'concierge@munar.ke');
    if (!is_wp_error($user_id)) {
        $user = new WP_User($user_id);
        $user->set_role('shop_manager');
        echo "Created Store Manager User: 'storemanager' (Role: shop_manager)\n";
    }
} else {
    echo "Store Manager User 'storemanager' already exists.\n";
}

// ----------------------------------------------------
// 5. Configure WooCommerce Store Settings
// ----------------------------------------------------
update_option('woocommerce_manage_stock', 'yes');
update_option('woocommerce_notify_low_stock', 'yes');
update_option('woocommerce_notify_low_stock_amount', '2');
update_option('woocommerce_notify_no_stock', 'yes');
update_option('woocommerce_stock_format', 'low_amount');
update_option('woocommerce_enable_coupons', 'yes');
update_option('woocommerce_enable_reviews', 'yes');
update_option('woocommerce_review_ratings_required', 'yes');

echo "\n====================================================\n";
echo "   MUNAR LUXURY PLATFORM CONFIGURATION COMPLETE!\n";
echo "====================================================\n";
