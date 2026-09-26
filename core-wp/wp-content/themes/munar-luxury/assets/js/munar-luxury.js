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
        const lower = query.toLowerCase();

        // 1. Out-of-Domain Guardrail (Food/Dinner, Weather, Tech, Politics, etc.)
        if (/\b(dinner|lunch|breakfast|food|eat|restaurant|cook|recipe|weather|rain|code|python|football)\b/i.test(lower)) {
            return "While I would love to assist, as the Munar Atelier Concierge my expertise is exclusively dedicated to luxury fashion, bespoke tailoring, and our curated collections. May I guide you through our latest runway evening gowns, leather goods, or private fittings in Nairobi?";
        }

        // 2. Greetings
        if (/^(hi|hello|hey|greetings|good\s*(morning|afternoon|evening)|habari|jambo)[\s!.]*$/i.test(lower)) {
            return "Good day. Welcome to Munar Luxury Atelier. I am your personal couture stylist. How may I assist your wardrobe today? You may ask about look pairings, bespoke fitting appointments in Westlands, sizing guidance, or our handcrafted leather collections.";
        }

        // 3. Sizing & Fitting
        if (/\b(size|sizing|fit|fitting|measure|tailor|bespoke|appointment)\b/i.test(lower)) {
            return "Our garments follow tailored UK/EU sizing. For bespoke atelier measurements, we offer complimentary tailored adjustments and private fittings at our Westlands studio in Nairobi.";
        }

        // 4. Payment / M-Pesa
        if (/\b(mpesa|m-pesa|payment|pay|checkout|daraja|stk)\b/i.test(lower)) {
            return "We accept instant Safaricom Lipa na M-Pesa STK Push payments at checkout. Once you enter your phone number, a secure PIN prompt will automatically appear on your phone.";
        }

        // 5. Order Tracking
        if (/\b(track|order|delivery|courier|dispatch|mnr-)\b/i.test(lower)) {
            return "Munar orders within Nairobi enjoy complimentary same-day or next-day White-Glove courier delivery (free above KSh 15,000). Please share your Order Reference or reach our concierge directly on WhatsApp for real-time dispatch status.";
        }

        // 6. Leather Bags
        if (/\b(bag|bags|tote|leather|calfskin|duffle)\b/i.test(lower)) {
            return "Our leather collection is handcrafted by master artisans from full-grain Tuscan calfskin with brushed gold hardware. Explore the <b>L'Atelier Calfskin Monogram Tote</b> and <b>Vanguard Leather Travel Duffle</b> in our shop.";
        }

        // 7. Styling Advice
        if (/\b(style|styling|pair|pairing|wear|gala|evening|wedding|suit|blazer|gown)\b/i.test(lower)) {
            return "For gala and evening occasions, our stylists recommend pairing <b>The Sovereign Silk Evening Gown</b> with our <b>Aura 18K Brushed Gold Cuff</b>. For gentlemen, the <b>Milano Double-Breasted Wool Blazer</b> delivers an impeccable sartorial silhouette.";
        }

        // Default Elegant Prompt
        return "As your Munar Atelier Stylist, I can curate your look for any occasion, guide you through our Ready-To-Wear collections, assist with M-Pesa checkout, or arrange a private fitting at our Westlands studio. What piece or occasion can I assist you with today?";
    }

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

