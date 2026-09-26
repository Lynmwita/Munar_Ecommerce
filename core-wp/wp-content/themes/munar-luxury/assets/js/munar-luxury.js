/**
 * Munar Luxury Atelier Interactive Script
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // 2. Initialize Hero Swiper Slider
    if (typeof Swiper !== 'undefined') {
        new Swiper('.munar-hero-swiper', {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Lookbook Carousel
        new Swiper('.munar-lookbook-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            speed: 800,
            navigation: {
                nextEl: '.lookbook-next',
                prevEl: '.lookbook-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 }
            }
        });
    }

    // 3. Slide-over Mini Cart Drawer Elements & Events
    const cartTrigger = document.getElementById('cart-drawer-trigger');
    const cartDrawer = document.getElementById('munar-cart-drawer');
    const cartContent = document.getElementById('munar-cart-content');
    const cartClose = document.getElementById('cart-drawer-close');

    function openCartDrawer() {
        if (cartDrawer && cartContent) {
            cartDrawer.classList.remove('opacity-0', 'pointer-events-none');
            cartContent.classList.remove('translate-x-full');
            document.body.classList.add('overflow-hidden');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    }

    function closeCartDrawer() {
        if (cartDrawer && cartContent) {
            cartDrawer.classList.add('opacity-0', 'pointer-events-none');
            cartContent.classList.add('translate-x-full');
            document.body.classList.remove('overflow-hidden');
        }
    }

    if (cartTrigger) cartTrigger.addEventListener('click', openCartDrawer);
    if (cartClose) cartClose.addEventListener('click', closeCartDrawer);
    if (cartDrawer) {
        cartDrawer.addEventListener('click', function (e) {
            if (e.target === cartDrawer) closeCartDrawer();
        });
    }

    // Auto-open drawer when an item is added to cart in WooCommerce
    if (typeof jQuery !== 'undefined') {
        jQuery(document.body).on('added_to_cart', function () {
            openCartDrawer();
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    }

    // 4. Mobile Menu Navigation
    const mobileTrigger = document.getElementById('mobile-menu-trigger');
    const mobileDrawer = document.getElementById('mobile-nav-drawer');
    const mobileContent = document.getElementById('mobile-nav-content');
    const mobileClose = document.getElementById('mobile-nav-close');

    function openMobileMenu() {
        if (mobileDrawer && mobileContent) {
            mobileDrawer.classList.remove('opacity-0', 'pointer-events-none');
            mobileContent.classList.remove('-translate-x-full');
            document.body.classList.add('overflow-hidden');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    }

    function closeMobileMenu() {
        if (mobileDrawer && mobileContent) {
            mobileDrawer.classList.add('opacity-0', 'pointer-events-none');
            mobileContent.classList.add('-translate-x-full');
            document.body.classList.remove('overflow-hidden');
        }
    }

    if (mobileTrigger) mobileTrigger.addEventListener('click', openMobileMenu);
    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
    if (mobileDrawer) {
        mobileDrawer.addEventListener('click', function (e) {
            if (e.target === mobileDrawer) closeMobileMenu();
        });
    }

    // 5. AI Concierge Interactive Chat
    const aiTrigger = document.getElementById('ai-concierge-trigger');
    const aiModal = document.getElementById('ai-concierge-modal');
    const aiClose = document.getElementById('ai-concierge-close');
    const aiInput = document.getElementById('ai-chat-input');
    const aiSend = document.getElementById('ai-chat-send');
    const aiMessages = document.getElementById('ai-chat-messages');

    function openAiModal() {
        if (aiModal) {
            aiModal.classList.remove('opacity-0', 'pointer-events-none');
            if (aiInput) aiInput.focus();
        }
    }

    function closeAiModal() {
        if (aiModal) {
            aiModal.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    if (aiTrigger) aiTrigger.addEventListener('click', openAiModal);
    if (aiClose) aiClose.addEventListener('click', closeAiModal);
    if (aiModal) {
        aiModal.addEventListener('click', function (e) {
            if (e.target === aiModal) closeAiModal();
        });
    }

    function sendAiQuery() {
        if (!aiInput || !aiMessages) return;
        const query = aiInput.value.trim();
        if (!query) return;

        // Append User Message
        const userMsg = document.createElement('div');
        userMsg.className = 'bg-munar-black text-white p-3 rounded-sm max-w-[85%] ml-auto text-xs';
        userMsg.innerHTML = `<p class="font-medium text-munar-gold text-[10px] mb-0.5">You</p><p>${escapeHtml(query)}</p>`;
        aiMessages.appendChild(userMsg);
        aiInput.value = '';
        aiMessages.scrollTop = aiMessages.scrollHeight;

        // Show typing indicator
        const typingMsg = document.createElement('div');
        typingMsg.id = 'ai-typing';
        typingMsg.className = 'bg-white p-3 rounded-sm border border-munar-border/60 max-w-[85%] text-munar-muted text-xs italic flex items-center space-x-2';
        typingMsg.innerHTML = '<span class="inline-block w-2 h-2 rounded-full bg-munar-gold animate-ping"></span><span>Munar Concierge is curating your recommendation...</span>';
        aiMessages.appendChild(typingMsg);
        aiMessages.scrollTop = aiMessages.scrollHeight;

        // Make AJAX call to backend
        const ajaxUrl = (typeof munar_ajax !== 'undefined' && munar_ajax.ajax_url) ? munar_ajax.ajax_url : '/wp-admin/admin-ajax.php';
        const nonce = (typeof munar_ajax !== 'undefined' && munar_ajax.nonce) ? munar_ajax.nonce : '';

        const formData = new FormData();
        formData.append('action', 'munar_ai_concierge');
        formData.append('nonce', nonce);
        formData.append('query', query);

        fetch(ajaxUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            const typing = document.getElementById('ai-typing');
            if (typing) typing.remove();

            let reply = '';
            if (data.success && data.data && data.data.reply) {
                reply = data.data.reply;
            } else {
                reply = getClientGuardrailFallback(query);
            }

            renderAiReply(reply);
        })
        .catch(err => {
            console.warn('Concierge AJAX failed, using guardrailed fallback:', err);
            const typing = document.getElementById('ai-typing');
            if (typing) typing.remove();
            renderAiReply(getClientGuardrailFallback(query));
        });
    }

    function renderAiReply(replyHtml) {
        const aiReply = document.createElement('div');
        aiReply.className = 'bg-white p-3.5 rounded-sm border border-munar-border/60 max-w-[85%] text-munar-dark text-xs leading-relaxed';
        aiReply.innerHTML = `<p class="font-medium text-munar-gold mb-1 text-[11px] uppercase tracking-wider">Munar Concierge</p><div>${replyHtml}</div>`;
        aiMessages.appendChild(aiReply);
        aiMessages.scrollTop = aiMessages.scrollHeight;
    }

    function getClientGuardrailFallback(query) {
        let text = query.toLowerCase().trim();
        text = text.replace(/\b(finf|fnd)\b/g, 'find');
        text = text.replace(/\b(thabk|thx|thanx|tnx)\b/g, 'thank');

        // 1. Gratitude, Thanks & Polite Sign-offs
        if (/\b(thank|thanks|appreciate|grateful|asante|merci)\b/i.test(text) ||
            /^(no\s*thank|no\s*thanks|good\s*thank|all\s*good|that\s*is\s*all|bye|goodbye)[\s!.]*$/i.test(text)) {
            return "You are most welcome! It is our absolute pleasure at Munar Atelier. If you need any further styling advice or wish to schedule a private fitting in Westlands, we are always at your service.";
        }

        // 2. Affirmations & Acknowledgments
        if (/^(ok|okay|alright|sure|sounds\s*good|cool|perfect|noted|understood|sawa)[\s!.]*$/i.test(text)) {
            return "Splendid! Let me know if you would like to explore our Women's Atelier, Men's Sartorial pieces, Haute Leather Goods, or book a private fitting.";
        }

        // 3. True Out-of-Domain Guardrails (Does NOT block dinner, evening, gala, party)
        if (/\b(how\s*to\s*cook|recipe|bake\s*cake|pizza|burger|fast\s*food|weather\s*forecast|rain\s*today|python|javascript|php\s*code|software\s*bug|football\s*score|premier\s*league|election|parliament|president|calculate|solve\s*equation)\b/i.test(text)) {
            return "While I would love to chat about that, as your Munar Atelier Stylist my focus is strictly dedicated to luxury fashion, bespoke tailoring, and our curated Nairobi collections. May I guide you through our runway evening gowns, sartorial blazers, or handcrafted leather goods?";
        }

        // 4. Greetings
        if (/^(hi|hello|hey|greetings|good\s*(morning|afternoon|evening)|salut|habari|jambo|sup)[\s!.]*$/i.test(text)) {
            return "Good day. Welcome to Munar Luxury Atelier Nairobi. I am your personal couture stylist. How may I elevate your wardrobe today? You can ask me to view Men's or Women's collections, request dinner & gala outfit pairings, inquire about leather bags, or book a bespoke fitting.";
        }

        // 5. Picture / Photo / Visual Showcase Requests
        if (/\b(picture|pictures|photo|photos|image|images|show\s*me|see|look\s*like|send\s*me)\b/i.test(text) && !/\b(track|order|delivery)\b/i.test(text)) {
            return "Here is a curated glimpse of our signature runway pieces currently available in the atelier:<br>" +
                `<div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">The Sovereign Silk Evening Gown</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 42,500</p>
                        <a href="/wordpress/product/sovereign-silk-evening-gown/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">Milano Double-Breasted Wool Blazer</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 38,500</p>
                        <a href="/wordpress/product/milano-double-breasted-wool-blazer/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <p class='mt-2 text-xs'>You can click any piece to view full sizing details, or explore our <a href='/wordpress/shop/' class='text-munar-gold underline font-medium'>Full Collections Catalog</a>.</p>`;
        }

        // 6. Men's Wear & Sartorial
        if (/\b(men|mens|men\'s|gentleman|gentlemen|sartorial|blazer|turtleneck|suit|suits|trousers)\b/i.test(text)) {
            return "Here are our signature Men's Sartorial pieces tailored for modern distinction:<br>" +
                `<div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">Milano Double-Breasted Wool Blazer</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 38,500</p>
                        <a href="/wordpress/product/milano-double-breasted-wool-blazer/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">Grand Sartorial Cashmere Turtleneck</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 22,500</p>
                        <a href="/wordpress/product/grand-sartorial-cashmere-turtleneck/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <p class='mt-2 text-xs'>Explore the full <a href='/wordpress/product-category/mens-sartorial/' class='text-munar-gold underline font-medium'>Men's Sartorial Collection</a> or book a private fitting in Westlands.</p>`;
        }

        // 7. Women's Wear & Haute Couture
        if (/\b(women|womens|women\'s|lady|ladies|gown|gowns|dress|dresses|skirt|couture|trench)\b/i.test(text)) {
            return "Here are our highlighted Women's Atelier runway creations:<br>" +
                `<div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">The Sovereign Silk Evening Gown</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 42,500</p>
                        <a href="/wordpress/product/sovereign-silk-evening-gown/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">Cashmere Belted Trench Coat</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 54,000</p>
                        <a href="/wordpress/product/cashmere-belted-trench-coat/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <p class='mt-2 text-xs'>Explore the full <a href='/wordpress/product-category/womens-atelier/' class='text-munar-gold underline font-medium'>Women's Atelier Collection</a>.</p>`;
        }

        // 8. Occasions: Dinner, Gala, Evening, Wedding, Cocktail
        if (/\b(dinner|gala|evening|wedding|cocktail|date\s*night|party|event|black\s*tie|soiree|reception)\b/i.test(text)) {
            return "For an exquisite dinner or evening affair, our stylists recommend these standout ensembles:<br>" +
                `<div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">The Sovereign Silk Evening Gown</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 42,500</p>
                        <a href="/wordpress/product/sovereign-silk-evening-gown/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <div class="my-2 p-2 bg-white/90 rounded border border-munar-border/80 flex items-center space-x-3 shadow-xs">
                    <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=300&q=80" class="w-12 h-14 object-cover rounded-sm flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold text-munar-black truncate">Milano Double-Breasted Wool Blazer</p>
                        <p class="text-[10px] text-munar-gold font-bold mt-0.5">KSh 38,500</p>
                        <a href="/wordpress/product/milano-double-breasted-wool-blazer/" class="text-[10px] text-munar-dark font-medium underline hover:text-munar-gold transition-colors inline-block mt-0.5">View Piece &rarr;</a>
                    </div>
                </div>
                <p class='mt-2 text-xs'>Pair with the <a href='/wordpress/product/aura-18k-brushed-gold-cuff/' class='text-munar-gold underline font-medium'>Aura 18K Gold Cuff</a> for effortless evening distinction.</p>`;
        }

        // 9. Sizing & Fitting
        if (/\b(size|sizing|fit|fitting|measure|tailor|bespoke|appointment|westlands|visit)\b/i.test(text)) {
            return "Our garments follow precision UK/EU sizing (XS to XL, and 38R–44R for sartorial tailoring). We offer complimentary private fitting sessions and bespoke adjustments at our Westlands Atelier. You can <a href='/wordpress/contact/' class='text-munar-gold underline font-medium'>Book an Atelier Appointment</a> or message us on WhatsApp.";
        }

        // 10. Payment / M-Pesa
        if (/\b(mpesa|m-pesa|payment|pay|checkout|daraja|stk|card|visa|mastercard)\b/i.test(text)) {
            return "We provide seamless, VIP-encrypted checkout via <b>Safaricom Lipa na M-Pesa STK Push</b>. Once you enter your phone number, a secure PIN prompt will automatically appear on your mobile device.";
        }

        // 11. Order Tracking & Delivery
        if (/\b(track|order|delivery|courier|dispatch|mnr-)\b/i.test(text)) {
            return "We offer complimentary <b>White-Glove VIP Courier delivery</b> across Kenya on orders over KSh 15,000 (same-day in Nairobi). Please share your 6-digit Order Reference (e.g. <b>#MNR-1042</b>) or reach our concierge directly on WhatsApp.";
        }

        // 12. Default Guidance
        return "As your Munar Atelier Stylist, I am here to assist your wardrobe. Would you like me to show you:<br><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Show me mens wear'>Men's Sartorial Tailoring</a><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Show me womens wear'>Women's Haute Couture Gowns</a><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Show me leather bags'>Handcrafted Leather Bags</a><br>• <a href='#' class='text-munar-gold underline font-medium concierge-quick-link' data-prompt='Book private fitting'>Bespoke Fitting in Westlands</a>";
    }

    // Handle Quick Links click inside chat
    document.addEventListener('click', function (e) {
        const quickLink = e.target.closest('.concierge-quick-link');
        if (quickLink) {
            e.preventDefault();
            const prompt = quickLink.getAttribute('data-prompt');
            if (prompt && aiInput) {
                aiInput.value = prompt;
                sendAiQuery();
            }
        }
    });

    if (aiSend) aiSend.addEventListener('click', sendAiQuery);
    if (aiInput) {
        aiInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendAiQuery();
        });
    }

    // 6. Luxury Search Modal Handlers
    const searchTrigger = document.getElementById('search-modal-trigger');
    const searchModal = document.getElementById('munar-search-modal');
    const searchContent = document.getElementById('munar-search-content');
    const searchClose = document.getElementById('search-modal-close');
    const searchInput = document.getElementById('munar-search-input');

    function openSearchModal() {
        if (searchModal && searchContent) {
            searchModal.classList.remove('opacity-0', 'pointer-events-none');
            searchContent.classList.remove('-translate-y-4');
            document.body.classList.add('overflow-hidden');
            if (searchInput) setTimeout(() => searchInput.focus(), 150);
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    }

    function closeSearchModal() {
        if (searchModal && searchContent) {
            searchModal.classList.add('opacity-0', 'pointer-events-none');
            searchContent.classList.add('-translate-y-4');
            document.body.classList.remove('overflow-hidden');
        }
    }

    if (searchTrigger) searchTrigger.addEventListener('click', openSearchModal);
    if (searchClose) searchClose.addEventListener('click', closeSearchModal);
    if (searchModal) {
        searchModal.addEventListener('click', function (e) {
            if (e.target === searchModal) closeSearchModal();
        });
    }

    // 7. Track Order Footer Button Trigger
    const trackOrderBtn = document.getElementById('track-order-footer-btn');
    if (trackOrderBtn) {
        trackOrderBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openAiModal();
            if (aiInput) {
                aiInput.value = 'Track Order #MNR-';
                aiInput.focus();
            }
        });
    }

    // 8. Wishlist Button Toast Notification
    document.addEventListener('click', function (e) {
        const wishlistBtn = e.target.closest('.wishlist-btn') || e.target.closest('button[aria-label="Add to Wishlist"]');
        if (wishlistBtn) {
            e.preventDefault();
            const icon = wishlistBtn.querySelector('i');
            if (icon) {
                wishlistBtn.classList.toggle('text-red-600');
            }
            showMunarToast('Piece saved to your Munar Atelier Wishlist');
        }
    });

    function showMunarToast(msg) {
        let toast = document.getElementById('munar-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'munar-toast';
            toast.className = 'fixed top-24 right-6 z-50 bg-munar-black text-white text-xs px-4 py-3 border border-munar-gold shadow-2xl rounded-sm flex items-center space-x-2 transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-none';
            document.body.appendChild(toast);
        }
        toast.innerHTML = `<span class="w-2 h-2 rounded-full bg-munar-gold"></span><span>${escapeHtml(msg)}</span>`;
        toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-2');
        setTimeout(() => {
            toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-2');
        }, 3000);
    }

    // Escape key closes modals
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeCartDrawer();
            closeMobileMenu();
            closeAiModal();
            closeSearchModal();
        }
    });

    function escapeHtml(text) {
        return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }
});

