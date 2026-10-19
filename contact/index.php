<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * contact/index.php — Contact (Phase 5). The full form lives here (hero forms are for home / service / city pages).
 *
 * Form contract (contact-form-standard.md + legal-compliance.md): posts to $formAction; fields name / phone / email /
 * service / message; _honey honeypot, _next, attribution fields, consent_version/consent_page and the spam shield come
 * from p1_lead_hidden_fields(); the underscore-prefixed _consent_version/_consent_page are added as extras; THREE
 * separate, unchecked consent boxes (email opt-in, SMS opt-in, required terms). Form id on this page: 'contact'.
 * Map: the real GBP embed from build-plan integrations.gbp_map_embed (config $gbp['embed_src']).
 * No response-time promise is printed — intake does not supply one (see /content-confirmations.json).
 */
$pageTitle       = 'Contact Ledco Plumbing LLC | Plumber in Seminole, OK';
$pageDescription = 'Call (405) 257-3096 or send a request online to Ledco Plumbing LLC at 316 E Oak Ave, Seminole, OK. Open 7 days, 7 AM to 5 PM, serving Seminole and Wewoka.';
$canonicalUrl    = $siteUrl . '/contact/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'contact';
$pageType        = 'contact';

$ctPhone     = formatPhone($phone);
$ctPhoneHref = phoneHref($phone);
$ctBase      = rtrim($siteUrl, '/');
$ctCity      = $address['city'];
$ctHours     = groupedHours((array) $hours);
$ctService   = isset($_GET['service']) ? (string) $_GET['service'] : '';

$pageSchema = [
    [
        '@type'       => 'ContactPage',
        '@id'         => $ctBase . '/contact/#webpage',
        'url'         => $ctBase . '/contact/',
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'isPartOf'    => ['@id' => schemaId('website')],
        'about'       => ['@id' => schemaId('organization')],
        'mainEntity'  => ['@id' => schemaId('organization')],
        'breadcrumb'  => ['@id' => $ctBase . '/contact/#breadcrumb'],
    ],
    ['@id' => $ctBase . '/contact/#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['Contact', '/contact/']]),
];
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   contact/ — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.ct-page h1, .ct-page h2, .ct-page h3 { text-wrap: balance; }
.ct-page p { text-wrap: pretty; }

/* ---- Hero ---- */
.ct-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 100%); }
.ct-hero::before {
  content: "";
  position: absolute;
  inset: 0 0 0 55%;
  z-index: -1;
  pointer-events: none;
  background:
    linear-gradient(90deg, transparent calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% + 1px), transparent calc(50% + 1px)),
    radial-gradient(closest-side at 70% 50%, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 75%);
}
.ct-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background-image: repeating-linear-gradient(0deg, color-mix(in srgb, var(--color-white) 4%, transparent) 0 1px, transparent 1px var(--space-2xl));
  -webkit-mask-image: linear-gradient(100deg, transparent 45%, var(--color-black) 95%);
  mask-image: linear-gradient(100deg, transparent 45%, var(--color-black) 95%);
}
.ct-hero .grain { opacity: .3; }
.ct-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.ct-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.ct-hero .breadcrumb a:hover, .ct-hero .breadcrumb [aria-current] { color: var(--color-white); }
.ct-hero .hero-title { max-width: 22ch; margin-top: var(--space-2); }
.ct-hero .hero-answer { max-width: 40rem; margin-top: var(--space-sm); }
.ct-hero .hero-actions { margin-top: var(--space-md); }
.ct-hero .link-call { color: var(--color-white); }
@media (max-width: 900px) { .ct-hero::before { inset: 0 0 0 60%; } }
@media (max-width: 560px) { .ct-hero .hero-answer { font-size: var(--fs-body); } .ct-hero .hero-chips li { font-size: var(--font-size-xs); } }

/* ---- Form + details: asymmetric ---- */
.ct-main { background: var(--color-paper); }
.ct-main__grid { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 4vw, var(--space-3xl)); align-items: start; }
.ct-form-card { padding: clamp(var(--space-lg), 3vw, var(--space-2xl)); background: var(--color-surface); border: 1px solid var(--color-line); border-top: 3px solid var(--color-accent); border-radius: var(--radius-lg); box-shadow: var(--shadow); }
.ct-form-card > p { margin: var(--space-2) 0 var(--space-lg); color: var(--color-ink-2); }
.ct-form { display: grid; gap: var(--space-md); }
.ct-form__row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); }
.ct-form textarea { min-height: calc(var(--space-16) * 2); resize: vertical; }
.ct-form .form-consent-fieldset { display: grid; gap: var(--space-1); padding: var(--space-md); background: var(--color-card-tint-neutral); border-radius: var(--radius); }
.ct-form .form-consent-item { margin: 0; padding: var(--space-2) 0; }
.ct-form .form-consent-item + .form-consent-item { border-top: 1px solid var(--color-line); }
.ct-form .form-consent-item strong { color: var(--color-ink); }
.ct-form .required-star { color: var(--color-danger); }
.ct-form .btn { justify-self: start; }
.ct-form .form-disclaimer { margin: 0; }
@media (max-width: 560px) { .ct-form__row { grid-template-columns: 1fr; } .ct-form .btn { justify-self: stretch; } }

.ct-details { display: grid; gap: var(--space-md); }
.ct-urgent { display: grid; gap: var(--space-2); padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-dark); color: var(--color-white); }
.ct-urgent h2 { color: var(--color-white); font-size: var(--fs-h3); }
.ct-urgent p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.ct-urgent .btn { justify-self: start; margin-top: var(--space-2); }
.ct-info { display: grid; gap: var(--space-md); padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-card-tint-1); border: 1px solid var(--color-line); }
.ct-info h2 { font-size: var(--fs-h3); }
.ct-info dl { display: grid; gap: var(--space-md); margin: 0; }
.ct-info dt { display: flex; align-items: center; gap: var(--space-2); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.ct-info dd { margin: var(--space-1) 0 0; font-family: var(--font-heading); font-weight: 700; line-height: 1.35; color: var(--color-ink); overflow-wrap: anywhere; }
.ct-info dd a { color: var(--color-primary); }
.ct-info dd small { display: block; font-family: var(--font-body); font-weight: 400; font-size: var(--fs-small); color: var(--color-muted); }
@media (max-width: 900px) { .ct-main__grid { grid-template-columns: 1fr; } }

/* ---- Map ---- */
.ct-map { background: var(--color-surface); }
.ct-map__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.6fr); gap: clamp(var(--space-xl), 4vw, var(--space-3xl)); align-items: center; }
.ct-map__copy { display: grid; gap: var(--space-md); }
.ct-map__copy .btn { justify-self: start; }
.ct-map .map-embed { box-shadow: var(--shadow-lg); border: 1px solid var(--color-line); }
@media (max-width: 900px) { .ct-map__grid { grid-template-columns: 1fr; } .ct-map__copy .btn { justify-self: stretch; } }

/* ---- What happens next ---- */
.ct-next { background: var(--color-paper-2); }
.ct-next__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.ct-next .next-steps li { padding-left: var(--space-8); }
@media (max-width: 900px) { .ct-next__grid { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.ct-cta .container { align-items: center; }
</style>

<div class="ct-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type ct-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Contact</span></li>
      </ol>
    </nav>
    <span class="eyebrow">Contact &middot; <?php echo esc($ctCity . ', ' . $address['state']); ?></span>
    <h1 class="hero-title" id="hero-title">Contact <span class="text-accent">Ledco Plumbing</span> in <?php echo esc($ctCity); ?>, OK</h1>
    <p class="hero-answer">The fastest way to reach <?php echo esc($siteName); ?> is to call <?php echo esc($ctPhone); ?>, any day from 7 AM to 5 PM. For a non-urgent job, send the form below with the problem and your phone number, and the office will call you back.</p>
    <div class="hero-actions">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($ctPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($ctPhone); ?></a>
      <a class="link-call" href="#contact-form"><?php icon('mail', 18); ?> or send a request</a>
    </div>
    <ul class="hero-chips">
      <li><?php icon('calendar', 16); ?> Open 7 days, 7 AM&ndash;5 PM</li>
      <li><?php icon('map-pin', 16); ?> <?php echo esc($address['street']); ?></li>
      <li><?php icon('house', 16); ?> <?php echo esc($ctCity); ?> &amp; Wewoka</li>
    </ul>
  </div>
</section>

<!-- ============================================================ FORM + DETAILS -->
<section class="section ct-main" id="contact-form" aria-labelledby="form-title">
  <div class="container-wide">
    <div class="ct-main__grid">
      <div class="ct-form-card reveal-left">
        <span class="eyebrow-label">Free estimate</span>
        <h2 id="form-title">How do I ask <span class="text-accent">Ledco Plumbing</span> for an estimate?</h2>
        <p class="answer-block">Fill in your name, phone number and email, pick the service, and describe the problem. <?php echo esc($siteName); ?> reads every request and calls you back to set up a visit. If water is leaking or sewage is backing up right now, call <?php echo esc($ctPhone); ?> instead.</p>

        <form class="ct-form" action="<?php echo esc($formAction); ?>" method="POST" id="contact-form-el">
          <?php echo p1_lead_hidden_fields('contact', [
              '_consent_version' => 'v2.1',
              '_consent_page'    => $_SERVER['REQUEST_URI'] ?? '',
          ]); ?>

          <div class="ct-form__row">
            <div class="field"><label for="contact-name">Your name *</label><input id="contact-name" type="text" name="name" required autocomplete="name"></div>
            <div class="field"><label for="contact-phone">Phone *</label><input id="contact-phone" type="tel" name="phone" required autocomplete="tel" inputmode="tel"></div>
          </div>
          <div class="ct-form__row">
            <div class="field"><label for="contact-email">Email *</label><input id="contact-email" type="email" name="email" required autocomplete="email"></div>
            <div class="field"><label for="contact-service">Service needed</label><select id="contact-service" name="service"><?php echo p1_service_options($ctService); ?></select></div>
          </div>
          <div class="field"><label for="contact-message">Tell us about the problem</label><textarea id="contact-message" name="message" rows="4" placeholder="Which drain or fixture, what it is doing, and where in the house or building."></textarea></div>

          <fieldset class="form-consent-fieldset">
            <legend class="form-consent-legend">Communication Consent</legend>

            <label class="form-consent-item" for="contact-email-optin">
              <input id="contact-email-optin" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry and services. I can unsubscribe at any time using the link in any email or by emailing <?php echo esc($contactEmail); ?>. Message frequency varies.</span>
            </label>

            <label class="form-consent-item" for="contact-sms-optin">
              <input id="contact-sms-optin" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the phone number I provided, such as appointment reminders and service updates. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
            </label>

            <label class="form-consent-item form-consent-required" for="contact-terms">
              <input id="contact-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
              <span class="consent-label">I have read and agree to the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and <a href="/terms/" target="_blank" rel="noopener">Terms of Service</a>. <span class="required-star">*</span></span>
            </label>
          </fieldset>

          <button type="submit" class="btn btn-primary btn-lg">Send my request</button>
          <p class="form-disclaimer">Your details go to the <?php echo esc($brandName); ?> office and are handled under our <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a>.</p>
        </form>
      </div>

      <div class="ct-details reveal-right">
        <aside class="ct-urgent" aria-labelledby="urgent-title">
          <h2 id="urgent-title">Water coming in right now?</h2>
          <p>Close the main shutoff valve, usually where the water line enters the house or inside the meter box near the street, then call. A phone call reaches the office faster than a form.</p>
          <a class="btn btn-accent" href="<?php echo esc($ctPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($ctPhone); ?></a>
        </aside>

        <section class="ct-info" aria-labelledby="info-title">
          <h2 id="info-title">Ledco Plumbing contact details</h2>
          <dl>
            <div><dt><?php icon('phone', 16); ?> Phone</dt><dd><a href="<?php echo esc($ctPhoneHref); ?>"><?php echo esc($ctPhone); ?></a></dd></div>
            <div><dt><?php icon('mail', 16); ?> Email</dt><dd><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></dd></div>
            <div><dt><?php icon('map-pin', 16); ?> Office</dt><dd><?php echo esc($address['street']); ?><small><?php echo esc($ctCity . ', ' . $address['state'] . ' ' . $address['zip']); ?></small></dd></div>
            <div><dt><?php icon('clock', 16); ?> Hours</dt><dd>
<?php foreach ($ctHours as $ctHourRow): ?>
              <?php echo esc($ctHourRow['days']); ?><small><?php echo esc($ctHourRow['label']); ?></small>
<?php endforeach; ?>
            </dd></div>
          </dl>
        </section>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ MAP -->
<section class="section edge-curve-top ct-map" id="visit" aria-labelledby="map-title">
  <div class="container">
    <div class="ct-map__grid">
      <div class="ct-map__copy reveal-up">
        <span class="eyebrow-label">Visit the office</span>
        <h2 id="map-title">Where is the <span class="text-accent">Ledco Plumbing</span> office in <?php echo esc($ctCity); ?>?</h2>
        <p class="answer-block"><?php echo esc($siteName); ?> is at <?php echo esc($address['street'] . ', ' . $ctCity . ', ' . $address['state'] . ' ' . $address['zip']); ?>. The office is open Monday through Sunday, 7 AM to 5 PM, and serves <?php echo esc($ctCity); ?> and Wewoka.</p>
        <a class="btn btn-primary" href="<?php echo esc($gbp['directions']); ?>" target="_blank" rel="noopener"><?php icon('map-pin', 18); ?> Get directions</a>
      </div>
      <div class="map-embed reveal-scale">
        <iframe src="<?php echo esc($gbp['embed_src']); ?>" title="Map of Ledco Plumbing LLC at <?php echo esc($address['street'] . ', ' . $ctCity . ', ' . $address['state']); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ WHAT HAPPENS NEXT -->
<section class="section ct-next" id="next" aria-labelledby="next-title">
  <div class="container">
    <div class="ct-next__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">After you send it</span>
        <h2 id="next-title">What happens after I send the <span class="text-accent">form</span>?</h2>
        <p class="answer-block">After you send the form, the <?php echo esc($brandName); ?> office reads your request and calls the number you gave. You then agree on a time for a plumber to look at the problem, and you see the price before any work starts.</p>
      </div>
      <ol class="next-steps reveal-right">
        <li><strong>The office reads your request</strong>The problem you described, the service you picked and your phone number reach the office together.</li>
        <li><strong>You get a call</strong>The office phones you to ask anything it needs and to set up a visit, so keep your phone nearby.</li>
        <li><strong>A plumber looks at it</strong>The drain, line, leak or water heater is checked at your home or business.</li>
        <li><strong>You approve the price</strong>The estimate comes before the work, and going ahead is your decision.</li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top ct-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Rather talk it through?</span>
      <h2 id="cta-title">Call the office, any day from 7 AM to 5 PM</h2>
      <p><?php echo esc($siteName); ?> answers at <?php echo esc($ctPhone); ?>. Tell the office which drain, line or heater is giving you trouble and it will tell you what happens next.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($ctPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($ctPhone); ?></a>
      <a class="btn btn-outline-white btn-lg" href="/services/">See our services</a>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
