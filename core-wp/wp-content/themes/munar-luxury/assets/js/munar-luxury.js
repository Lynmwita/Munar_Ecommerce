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
        typingMsg.className = 'bg-white p-3 rounded-sm border border-munar-border/60 max-w-[85%] text-munar-muted text-xs italic';
        typingMsg.innerText = 'Munar Concierge is curating your recommendation...';
        aiMessages.appendChild(typingMsg);
        aiMessages.scrollTop = aiMessages.scrollHeight;

        setTimeout(() => {
            const typing = document.getElementById('ai-typing');
            if (typing) typing.remove();

            let reply = "Our Nairobi atelier stylists recommend pairing our handcrafted structured jackets with the Safari Silk Trousers. Would you like to schedule an in-person fitting in Westlands?";
            const lower = query.toLowerCase();

            if (lower.includes('size') || lower.includes('fitting')) {
                reply = "Our garments follow tailored UK/EU sizing. For bespoke atelier measurements, we offer complimentary tailored adjustments at our Westlands studio.";
            } else if (lower.includes('mpesa') || lower.includes('payment') || lower.includes('pay')) {
                reply = "We accept instant Safaricom Lipa na M-Pesa STK Push payments at checkout. Once you enter your phone number, a PIN prompt will automatically appear on your phone.";
            } else if (lower.includes('mnr-') || lower.includes('track') || lower.includes('order')) {
                reply = "Your order status is currently: <b>Dispatched with VIP Courier (Nairobi Express Delivery)</b>. Rider contact is sent via SMS.";
            } else if (lower.includes('bag') || lower.includes('leather')) {
                reply = "Our leather bag collection is handcrafted using full-grain Kenyan leather with bespoke brass hardware. Explore the 'Haute Leather Bags' collection above!";
            }

            const aiReply = document.createElement('div');
            aiReply.className = 'bg-white p-3.5 rounded-sm border border-munar-border/60 max-w-[85%] text-munar-dark text-xs';
            aiReply.innerHTML = `<p class="font-medium text-munar-gold mb-1">Munar Concierge:</p><p>${reply}</p>`;
            aiMessages.appendChild(aiReply);
            aiMessages.scrollTop = aiMessages.scrollHeight;
        }, 800);
    }

    if (aiSend) aiSend.addEventListener('click', sendAiQuery);
    if (aiInput) {
        aiInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendAiQuery();
        });
    }

    function escapeHtml(text) {
        return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }
});
