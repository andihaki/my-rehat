<?php
/* Template Name: Trails Test Page */
get_header();
?>

<header class="site-header-trails">
  <div class="trails-contact" aria-label="Chat with us">
    <a class="trails-contact-btn trails-contact-whatsapp"
      href="https://wa.me/60195870527"
      target="_blank" rel="noopener noreferrer"
      aria-label="Chat with us on WhatsApp">
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38c1.45.79 3.08 1.21 4.79 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.8-.78.97-.14.16-.29.19-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.86.85-.86 2.06s.88 2.39 1 2.56c.12.17 1.73 2.65 4.2 3.71.59.25 1.04.4 1.4.52.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.23-.17-.48-.29z"/>
      </svg>
      <span>WhatsApp</span>
    </a>
    <a class="trails-contact-btn trails-contact-line"
      href="https://line.me/ti/p/Q9YDqqNMmV"
      target="_blank" rel="noopener noreferrer"
      aria-label="Chat with us on LINE">
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
        <path d="M12 2.75C6.6 2.75 2.25 6.4 2.25 10.9c0 2.45 1.36 4.68 3.6 6.2v3.1c0 .46.5.75.9.51l3.1-1.86c.7.14 1.42.21 2.15.21 5.4 0 9.75-3.65 9.75-8.16S17.4 2.75 12 2.75z"/>
        <text x="12" y="13.2" text-anchor="middle" font-size="6.4" font-weight="700" font-family="Arial, Helvetica, sans-serif" style="fill:#06c755">LINE</text>
      </svg>
      <span>LINE</span>
    </a>
  </div>
  <h1>Hiking Advantures</h1>
  <p>Find your next trail with MyRehat</p>
  <input id="main-search" type="text" placeholder="Search homepage...">
</header>

<div class="trails-promo">
  <strong>Limited offer:</strong> 20% off all guided hikes this month.
</div>

<main class="trails-main">
  <div class="trails-search-row">
    <input id="search-box" type="text" placeholder="Search trails...">
    <select id="category">
      <option value="all">All categories</option>
      <option value="mountain">Mountain</option>
      <option value="beach">Beach</option>
      <option value="forest">Forest</option>
    </select>
  </div>
  <p id="trails-no-results" hidden>No trails found.</p>

  <div class="trails-cards">
    <article class="trail-card" data-category="mountain">
      <h3>Mount Rinjani Sunrise</h3>
      <p>2-day guided summit trek, Lombok.</p>
      <span class="price">RM 350 / pax</span>
    </article>
    <article class="trail-card" data-category="beach">
      <h3>Pulau Perhentian Coastal Walk</h3>
      <p>Easy coastal trail, Terengganu.</p>
      <span class="price">RM 120 / pax</span>
    </article>
    <article class="trail-card" data-category="forest">
      <h3>Taman Negara Canopy Trail</h3>
      <p>Rainforest walk, Pahang.</p>
      <span class="price">RM 180 / pax</span>
    </article>
    <article class="trail-card" data-category="mountain">
      <h3>Mount Kinabalu Base Trek</h3>
      <p>Highland trek, Sabah.</p>
      <span class="price">RM 420 / pax</span>
    </article>
    <article class="trail-card" data-category="beach">
      <h3>Langkawi Sunset Ridge</h3>
      <p>Evening ridge walk, Kedah.</p>
      <span class="price">RM 95 / pax</span>
    </article>
    <article class="trail-card" data-category="forest">
      <h3>Belum Mossy Forest</h3>
      <p>Misty forest trail, Perak.</p>
      <span class="price">RM 150 / pax</span>
    </article>
  </div>

  <section class="trails-booking">
    <h2><?php echo esc_html( myrehat_test_booking_title() ); ?></h2>
    <?php
    // Shows the result of a no-JavaScript submit after the PRG redirect.
    $booking_status = isset( $_GET['booking'] ) ? sanitize_key( wp_unslash( $_GET['booking'] ) ) : '';
    ?>
    <form id="booking-form" method="post">
      <?php wp_nonce_field( 'myrehat_booking', 'myrehat_booking_nonce' ); ?>
      <input type="hidden" name="trails_booking" value="1">
      <label>Name <input type="text" name="name" required></label>
      <label>Date <input type="date" name="date" required></label>
      <fieldset class="trails-field-group">
        <legend>Digital Nomad (required)</legend>
        <label><input type="radio" name="digital_nomad" value="yes" required> Yes</label>
        <label><input type="radio" name="digital_nomad" value="no" required> No</label>
      </fieldset>
      <fieldset class="trails-field-group">
        <legend>Duration (required)</legend>
        <label><input type="radio" name="duration" value="daily" required> Daily</label>
        <label><input type="radio" name="duration" value="montly" required> Montly</label>
      </fieldset>
      <p id="trails-total">Total: -</p>
      <button type="submit">Request booking</button>
    </form>
    <div id="trails-confirmation" aria-live="polite"<?php echo in_array( $booking_status, array( 'ok', 'invalid' ), true ) ? '' : ' hidden'; ?>>
      <?php if ( 'ok' === $booking_status ) : ?>
        <p><?php esc_html_e( 'Booking request received. We will be in touch shortly.', 'myrehat-test' ); ?></p>
      <?php elseif ( 'invalid' === $booking_status ) : ?>
        <p><?php esc_html_e( 'Something was wrong with your details. Please check them and try again.', 'myrehat-test' ); ?></p>
      <?php endif; ?>
    </div>
  </section>
</main>

<footer class="trails-footer">
  <nav>
    <a href="https://myrehat.com/faq/">FAQ</a>
    <a href="https://myrehat.com/contact-us/">Contact Us</a>
    <a href="https://myrehat.com/pdpa/">PDPA</a>
    <a href="https://myrehat.com/privacy-policy-2/">Privacy Policy Statement</a>
  </nav>
  <div>
    <p>&copy; 2026 MyRehat</p>
    <div class="socials">
      <a href="https://www.facebook.com/myrehatdotcom/" target="_blank" rel="noopener noreferrer" aria-label="MyRehat on Facebook">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
      </a>
      <a href="https://my.linkedin.com/company/myrehat" target="_blank" rel="noopener noreferrer" aria-label="MyRehat on LinkedIn">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
        </svg>
      </a>
      <a href="https://www.instagram.com/myrehat/?hl=en" target="_blank" rel="noopener noreferrer" aria-label="MyRehat on Instagram">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <rect x="2.75" y="2.75" width="18.5" height="18.5" rx="5.25" fill="none" stroke="currentColor" stroke-width="2"/>
          <circle cx="12" cy="12" r="4.25" fill="none" stroke="currentColor" stroke-width="2"/>
          <circle cx="17.3" cy="6.7" r="1.3"/>
        </svg>
      </a>
      <a href="https://www.tiktok.com/@myrehat" target="_blank" rel="noopener noreferrer" aria-label="MyRehat on TikTok">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
        </svg>
      </a>
      <a href="https://www.youtube.com/channel/UCwOaBGsBdOnDyZPidRTm83w" target="_blank" rel="noopener noreferrer" aria-label="MyRehat on YouTube">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
      </a>
    </div>
  </div>
</footer>
<?php get_footer(); ?>
