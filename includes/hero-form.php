<?php
/**
 * includes/hero-form.php — the hero lead-form card for service-area pages (same markup as the service-page hero card).
 * Set before including: $heroFormTitle, $heroFormTagline (optional), $heroFormService (optional preselected service).
 * Form id is 'hero' (unique per page: hero | cta-band | dialog | contact). Hidden to the dialog below 900px by framework.css.
 */
$heroFormTitle   = $heroFormTitle ?? 'Get a free estimate';
$heroFormTagline = $heroFormTagline ?? 'Tell us what is going on and ' . $brandName . ' will call you back.';
$heroFormService = $heroFormService ?? '';
?>
      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title"><?php echo esc($heroFormTitle); ?></h2>
        <p class="hero-form-tagline"><?php echo esc($heroFormTagline); ?></p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form" id="hero-form">
          <input type="hidden" name="_next" value="<?php echo esc(rtrim($siteUrl, '/')); ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($heroFormService); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Request my estimate</button>
        </form>
      </aside>
