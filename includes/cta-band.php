<?php
/**
 * includes/cta-band.php — the ONE mid-page estimate band for About and FAQ (never a hero form there).
 * CLAUDE.md "Lead Form Placement": <section class="cta-band" id="estimate">, copy ≈1/3, form card ≈2/3 with the
 * fields three-up (name | phone | email / service | button / consent | footnote), ≈300px tall on desktop.
 *
 *   echo p1_cta_band_form(['eyebrow' => '...', 'heading' => '...', 'copy' => '...', 'service' => '']);
 *
 * Form id is 'cta-band' (unique per page: hero | cta-band | dialog | contact). Honeypot, _next, attribution,
 * consent_version/consent_page and the spam shield all come from p1_lead_hidden_fields().
 */
if (!function_exists('p1_cta_band_form')) {
    function p1_cta_band_form(array $o = []): string {
        global $formAction, $phone, $brandName;
        $eyebrow = $o['eyebrow'] ?? 'Free estimate';
        $heading = $o['heading'] ?? 'Want a plumber to look at it?';
        $copy    = $o['copy'] ?? ('Tell ' . $brandName . ' what is going on and the office will call you back.');
        $selected = $o['service'] ?? '';
        $ph = formatPhone($phone);
        ob_start();
        ?>
<section class="cta-band" id="estimate" aria-labelledby="cta-band-title">
  <style>
  .cta-band { background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 140%); color: var(--color-white); padding-block: clamp(2rem, 4vw, 3rem); isolation: isolate; }
  .cta-band__inner { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 2fr); gap: clamp(1.25rem, 3vw, 2.5rem); align-items: center; }
  .cta-band__copy { display: grid; gap: var(--space-2); }
  .cta-band__copy h2 { color: var(--color-white); font-size: var(--fs-h3); line-height: 1.2; }
  .cta-band__copy p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 82%, transparent); }
  .cta-band__copy .eyebrow-label { color: var(--color-accent-bright); }
  .cta-band__copy a { color: var(--color-accent-bright); font-weight: 600; }
  .cta-band__card { background: var(--color-surface); color: var(--color-ink); border-radius: var(--radius-lg); padding: var(--space-lg); box-shadow: var(--shadow-lg); border-top: 3px solid var(--color-accent); }
  .cta-band__form { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm) var(--space-md); align-items: end; }
  .cta-band__form .field { gap: var(--space-1); }
  .cta-band__form .field input, .cta-band__form .field select { min-height: 44px; padding: var(--space-2) var(--space-sm); }
  .cta-band__form .field--wide, .cta-band__form .consent { grid-column: span 2; }
  .cta-band__form .consent { margin: 0; align-self: center; }
  .cta-band__form .btn { width: 100%; }
  .cta-band__form .form-footnote { margin: 0; align-self: center; }
  @media (max-width: 900px) { .cta-band__inner { grid-template-columns: 1fr; } .cta-band__form { grid-template-columns: repeat(2, minmax(0, 1fr)); } .cta-band__form .field--wide, .cta-band__form .consent { grid-column: span 1; } }
  @media (max-width: 560px) { .cta-band__form { grid-template-columns: 1fr; } .cta-band__form .field--wide, .cta-band__form .consent { grid-column: auto; } }
  </style>
  <div class="container">
    <div class="cta-band__inner">
      <div class="cta-band__copy">
        <span class="eyebrow-label"><?php echo esc($eyebrow); ?></span>
        <h2 id="cta-band-title"><?php echo esc($heading); ?></h2>
        <p><?php echo esc($copy); ?> Or call <a href="<?php echo esc(phoneHref($phone)); ?>"><?php echo esc($ph); ?></a>.</p>
      </div>
      <div class="cta-band__card">
        <form class="cta-band__form" action="<?php echo esc($formAction); ?>" method="POST" id="cta-band-form">
          <?php echo p1_lead_hidden_fields('cta-band'); ?>
          <div class="field"><label for="cta-band-name">Your name *</label><input id="cta-band-name" type="text" name="name" required autocomplete="name"></div>
          <div class="field"><label for="cta-band-phone">Phone *</label><input id="cta-band-phone" type="tel" name="phone" required autocomplete="tel" inputmode="tel"></div>
          <div class="field"><label for="cta-band-email">Email *</label><input id="cta-band-email" type="email" name="email" required autocomplete="email"></div>
          <div class="field field--wide"><label for="cta-band-service">Service needed</label><select id="cta-band-service" name="service"><?php echo p1_service_options($selected); ?></select></div>
          <button type="submit" class="btn btn-primary">Request my estimate</button>
          <?php echo p1_consent_row('cta-band'), "\n"; ?>
          <p class="form-footnote">For a leak or backup happening now, call instead of sending the form.</p>
        </form>
      </div>
    </div>
  </div>
</section>
<?php
        return (string) ob_get_clean();
    }
}
