<?php
/**
 * Update About, Contact, and Lookbook pages for Munar Luxury Atelier
 */
define('WP_USE_THEMES', false);
require_once('/opt/lampp/htdocs/wordpress/wp-load.php');

echo "🎨 Updating Pages with Munar Luxury Editorial Content...\n";

// 1. About Page (ID 17)
$about_content = '
<div class="space-y-16">
  <!-- Hero Intro -->
  <div class="text-center max-w-3xl mx-auto space-y-4">
    <span class="text-xs uppercase tracking-[0.35em] text-munar-gold font-semibold">Atelier Heritage &bull; Nairobi</span>
    <h1 class="font-editorial text-4xl sm:text-6xl font-light text-munar-black leading-tight">The Art of Modern African Haute Couture</h1>
    <div class="w-16 h-0.5 bg-munar-gold mx-auto"></div>
    <p class="text-base sm:text-lg text-munar-muted font-light leading-relaxed pt-2">
      Founded in Nairobi, Munar Atelier merges architectural silhouette construction with indigenous East African textiles, heavyweight mulberry silks, and ethical artisan metalsmithing.
    </p>
  </div>

  <!-- Editorial Dual Visual Narrative -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
    <div class="aspect-[4/5] bg-munar-sand overflow-hidden rounded-sm shadow-xl">
      <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1200&q=85" alt="Munar Master Tailor Atelier" class="w-full h-full object-cover" />
    </div>
    <div class="space-y-6">
      <span class="text-xs uppercase tracking-[0.3em] text-munar-gold font-semibold">The Philosophy</span>
      <h2 class="font-editorial text-3xl sm:text-4xl text-munar-black font-light leading-snug">Sculptural Form Meets Equatorial Ease</h2>
      <p class="text-sm text-munar-muted font-light leading-relaxed">
        Every garment begins in our Westlands studio as an intensive exploration of proportion, drape, and movement. We reject fleeting trend cycles in favor of permanent distinction.
      </p>
      <div class="grid grid-cols-2 gap-6 pt-4 border-t border-munar-border">
        <div class="space-y-1">
          <p class="font-editorial text-2xl text-munar-gold font-light">100%</p>
          <p class="text-[10px] uppercase tracking-widest text-munar-muted font-medium">Kenyan Artisan Craft</p>
        </div>
        <div class="space-y-1">
          <p class="font-editorial text-2xl text-munar-gold font-light">22 Momme</p>
          <p class="text-[10px] uppercase tracking-widest text-munar-muted font-medium">Pure Mulberry Silk</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Three Pillars of Craft -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-8">
    <div class="bg-white p-8 border border-munar-border/80 space-y-3">
      <span class="font-editorial text-2xl text-munar-gold">01</span>
      <h3 class="font-editorial text-xl font-normal text-munar-black">Ethical Provenance</h3>
      <p class="text-xs text-munar-muted font-light leading-relaxed">Our raw silks, organic linens, and vegetable-tanned leathers are sustainably sourced with total supply chain transparency.</p>
    </div>
    <div class="bg-white p-8 border border-munar-border/80 space-y-3">
      <span class="font-editorial text-2xl text-munar-gold">02</span>
      <h3 class="font-editorial text-xl font-normal text-munar-black">Bespoke Precision</h3>
      <p class="text-xs text-munar-muted font-light leading-relaxed">Each piece is individually drafted, cut, and tailored with hand-finished French seams for lifetime structural longevity.</p>
    </div>
    <div class="bg-white p-8 border border-munar-border/80 space-y-3">
      <span class="font-editorial text-2xl text-munar-gold">03</span>
      <h3 class="font-editorial text-xl font-normal text-munar-black">Private Studio Fitting</h3>
      <p class="text-xs text-munar-muted font-light leading-relaxed">Complimentary bespoke measurement adjustments and private fitting viewings at our flagship atelier in Westlands.</p>
    </div>
  </div>

  <!-- Studio Booking Banner -->
  <div class="bg-munar-black text-white p-10 md:p-12 text-center rounded-sm space-y-6">
    <h3 class="font-editorial text-3xl sm:text-4xl font-light text-munar-sand">Experience the Atelier in Person</h3>
    <p class="text-xs sm:text-sm text-munar-sand/70 max-w-xl mx-auto font-light leading-relaxed">
      Reserve a private viewing suite with our senior stylists to explore fabric swatches, sample runway editions, and receive custom bespoke measurements.
    </p>
    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
      <a href="/wordpress/contact/" class="btn-munar-gold">Reserve Private Fitting</a>
      <a href="/wordpress/shop/" class="btn-munar-outline border-white text-white hover:bg-white hover:text-munar-black">Explore Catalog</a>
    </div>
  </div>
</div>';

wp_update_post(array(
    'ID'           => 17,
    'post_content' => $about_content,
));
echo "✅ About page updated with Munar Atelier story!\n";

// 2. Contact Page (ID 7)
$contact_content = '
<div class="space-y-16">
  <!-- Header -->
  <div class="text-center max-w-2xl mx-auto space-y-3">
    <span class="text-xs uppercase tracking-[0.35em] text-munar-gold font-semibold">Private Appointments &bull; Client Care</span>
    <h1 class="font-editorial text-4xl sm:text-5xl font-light text-munar-black">Flagship Atelier &amp; Concierge</h1>
    <div class="w-12 h-0.5 bg-munar-gold mx-auto"></div>
    <p class="text-sm text-munar-muted font-light leading-relaxed pt-2">
      Whether arranging a private studio viewing in Westlands or inquiring about a bespoke couture commission, our concierge team is at your disposal.
    </p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
    <!-- Contact Info Column (5 cols) -->
    <div class="lg:col-span-5 space-y-8 bg-white p-8 border border-munar-border/80">
      <div class="space-y-2">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold font-semibold">Flagship Atelier</span>
        <h3 class="font-editorial text-2xl text-munar-black font-light">Westlands Nairobi</h3>
        <p class="text-xs text-munar-muted leading-relaxed font-light">
          Westlands Commercial Precinct<br>
          Nairobi, Kenya<br>
          <span class="text-munar-gold font-medium mt-1 inline-block">Viewing Suites Open Mon–Sat: 9:00 AM – 7:00 PM</span>
        </p>
      </div>

      <div class="pt-6 border-t border-munar-border space-y-4">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold font-semibold">Direct Concierge Channels</span>
        <div class="space-y-3 text-xs">
          <div class="flex items-center space-x-3">
            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-[11px]">WA</span>
            <div>
              <p class="text-[10px] text-munar-muted uppercase tracking-wider">Direct WhatsApp Stylist</p>
              <a href="https://wa.me/254700000000" target="_blank" class="font-medium text-munar-black hover:text-emerald-700 transition-colors">+254 (0) 700 000 000</a>
            </div>
          </div>
          <div class="flex items-center space-x-3">
            <span class="w-7 h-7 rounded-full bg-munar-sand text-munar-black flex items-center justify-center font-bold text-[11px]">@</span>
            <div>
              <p class="text-[10px] text-munar-muted uppercase tracking-wider">Concierge Desk</p>
              <a href="mailto:concierge@munar.ke" class="font-medium text-munar-black hover:text-munar-gold transition-colors">concierge@munar.ke</a>
            </div>
          </div>
        </div>
      </div>

      <div class="pt-6 border-t border-munar-border space-y-2 text-xs text-munar-muted font-light">
        <p class="font-medium text-munar-black uppercase tracking-wider text-[11px]">White-Glove VIP Courier</p>
        <p>Complimentary same-day express delivery within Nairobi on orders over KSh 15,000.</p>
      </div>
    </div>

    <!-- Fitting Booking Form Column (7 cols) -->
    <div class="lg:col-span-7 bg-white p-8 md:p-10 border border-munar-border/80 space-y-6">
      <div class="space-y-1">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold font-semibold">Online Reservation</span>
        <h3 class="font-editorial text-2xl text-munar-black font-light">Reserve a Private Fitting Session</h3>
      </div>

      <form class="space-y-4 text-xs" onsubmit="event.preventDefault(); alert(\'Thank you. Your private atelier fitting request has been received. Our concierge will contact you via WhatsApp/Phone within 2 hours to confirm your suite appointment.\');">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="uppercase tracking-wider text-[10px] text-munar-muted font-medium">Patron Name *</label>
            <input type="text" required placeholder="Lady / Lord / Full Name" class="w-full bg-munar-sand/30 border border-munar-border px-3.5 py-3 text-munar-black focus:outline-none focus:border-munar-gold" />
          </div>
          <div class="space-y-1.5">
            <label class="uppercase tracking-wider text-[10px] text-munar-muted font-medium">Mobile Phone (M-Pesa / WhatsApp) *</label>
            <input type="tel" required placeholder="+254 700 000 000" class="w-full bg-munar-sand/30 border border-munar-border px-3.5 py-3 text-munar-black focus:outline-none focus:border-munar-gold" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="uppercase tracking-wider text-[10px] text-munar-muted font-medium">Email Address</label>
            <input type="email" placeholder="patron@example.com" class="w-full bg-munar-sand/30 border border-munar-border px-3.5 py-3 text-munar-black focus:outline-none focus:border-munar-gold" />
          </div>
          <div class="space-y-1.5">
            <label class="uppercase tracking-wider text-[10px] text-munar-muted font-medium">Department of Interest</label>
            <select class="w-full bg-munar-sand/30 border border-munar-border px-3.5 py-3 text-munar-black focus:outline-none focus:border-munar-gold">
              <option>Women\'s Haute Atelier Gowns</option>
              <option>Men\'s Sartorial Wool Tailoring</option>
              <option>Haute Leather Goods &amp; Duffles</option>
              <option>Fine Jewelry &amp; Timepieces</option>
              <option>Full Wardrobe Styling Consultation</option>
            </select>
          </div>
        </div>

        <div class="space-y-1.5">
          <label class="uppercase tracking-wider text-[10px] text-munar-muted font-medium">Special Fitting Notes or Preferred Date</label>
          <textarea rows="4" placeholder="Tell us about the occasion (e.g. Black-tie Gala, Wedding, Business Presentation) or preferred appointment timing..." class="w-full bg-munar-sand/30 border border-munar-border px-3.5 py-3 text-munar-black focus:outline-none focus:border-munar-gold"></textarea>
        </div>

        <button type="submit" class="w-full btn-munar-primary text-xs py-3.5">
          Submit Private Fitting Request
        </button>
      </form>
    </div>
  </div>
</div>';

wp_update_post(array(
    'ID'           => 7,
    'post_content' => $contact_content,
));
echo "✅ Contact page updated with Munar Atelier fitting booking form!\n";

// 3. Lookbook Page (ID 212)
$lookbook_content = '
<div class="space-y-16">
  <!-- Lookbook Hero -->
  <div class="text-center max-w-3xl mx-auto space-y-4">
    <span class="text-xs uppercase tracking-[0.35em] text-munar-gold font-semibold">Runway Edition &bull; Drop IV</span>
    <h1 class="font-editorial text-4xl sm:text-6xl font-light text-munar-black leading-tight">Runway Lookbook &bull; 2026/2027</h1>
    <div class="w-16 h-0.5 bg-munar-gold mx-auto"></div>
    <p class="text-base text-munar-muted font-light leading-relaxed pt-2">
      An architectural study in movement, heavyweight natural silks, and midnight virgin wool silhouettes handcrafted in Nairobi.
    </p>
  </div>

  <!-- Lookbook Gallery Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <div class="group relative aspect-[3/4] bg-munar-sand overflow-hidden">
      <img src="https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=900&q=80" alt="Look 01: The Sovereign Silk Evening Gown" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 01</span>
        <h3 class="font-editorial text-2xl font-light">The Sovereign Silk Gown</h3>
        <p class="text-xs text-munar-sand/80 font-light mt-1">Mulberry Silk 22 Momme &bull; KSh 42,500</p>
        <a href="/wordpress/product/sovereign-silk-evening-gown/" class="text-xs font-semibold text-munar-gold mt-2 hover:underline">View Garment &rarr;</a>
      </div>
    </div>

    <div class="group relative aspect-[3/4] bg-munar-sand overflow-hidden">
      <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=900&q=80" alt="Look 02: Milano Double-Breasted Wool Blazer" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 02</span>
        <h3 class="font-editorial text-2xl font-light">Milano Sartorial Blazer</h3>
        <p class="text-xs text-munar-sand/80 font-light mt-1">Italian Virgin Wool &bull; KSh 38,500</p>
        <a href="/wordpress/product/milano-double-breasted-wool-blazer/" class="text-xs font-semibold text-munar-gold mt-2 hover:underline">View Garment &rarr;</a>
      </div>
    </div>

    <div class="group relative aspect-[3/4] bg-munar-sand overflow-hidden">
      <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=900&q=80" alt="Look 03: L\'Atelier Calfskin Monogram Tote" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 03</span>
        <h3 class="font-editorial text-2xl font-light">L\'Atelier Calfskin Tote</h3>
        <p class="text-xs text-munar-sand/80 font-light mt-1">Full-grain Tuscan Leather &bull; KSh 65,000</p>
        <a href="/wordpress/product/latelier-calfskin-monogram-tote/" class="text-xs font-semibold text-munar-gold mt-2 hover:underline">View Garment &rarr;</a>
      </div>
    </div>

    <div class="group relative aspect-[3/4] bg-munar-sand overflow-hidden">
      <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=900&q=80" alt="Look 04: Cashmere Belted Trench Coat" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 04</span>
        <h3 class="font-editorial text-2xl font-light">Cashmere Belted Trench</h3>
        <p class="text-xs text-munar-sand/80 font-light mt-1">Double-Faced Cashmere &bull; KSh 54,000</p>
        <a href="/wordpress/product/cashmere-belted-trench-coat/" class="text-xs font-semibold text-munar-gold mt-2 hover:underline">View Garment &rarr;</a>
      </div>
    </div>

    <div class="group relative aspect-[3/4] bg-munar-sand overflow-hidden">
      <img src="https://images.unsplash.com/photo-1611591475155-42e523299711?auto=format&fit=crop&w=900&q=80" alt="Look 05: Aura 18K Brushed Gold Cuff" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 05</span>
        <h3 class="font-editorial text-2xl font-light">Aura 18K Gold Cuff</h3>
        <p class="text-xs text-munar-sand/80 font-light mt-1">Solid Recycled Gold &bull; KSh 29,000</p>
        <a href="/wordpress/product/aura-18k-brushed-gold-cuff/" class="text-xs font-semibold text-munar-gold mt-2 hover:underline">View Garment &rarr;</a>
      </div>
    </div>

    <div class="group relative aspect-[3/4] bg-munar-sand overflow-hidden">
      <img src="https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=900&q=80" alt="Look 06: Equatorial Chronometer Timepiece" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
        <span class="text-[10px] uppercase tracking-widest text-munar-gold">Look 06</span>
        <h3 class="font-editorial text-2xl font-light">Equatorial Chronometer</h3>
        <p class="text-xs text-munar-sand/80 font-light mt-1">Precision Horology &bull; KSh 88,000</p>
        <a href="/wordpress/product/equatorial-chronometer-timepiece/" class="text-xs font-semibold text-munar-gold mt-2 hover:underline">View Garment &rarr;</a>
      </div>
    </div>
  </div>
</div>';

wp_update_post(array(
    'ID'           => 212,
    'post_content' => $lookbook_content,
));
echo "✅ Lookbook page updated with 2026 runway gallery!\n";
