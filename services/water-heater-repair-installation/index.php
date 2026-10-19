<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * services/water-heater-repair-installation/index.php — Water Heater Repair & Installation
 * (Phase 4, premium editorial service page, minimal-tech).
 *
 * Section script: interior type hero + form → failing-heater signs (centered pull-quote + 4-up strip)
 * → repair-or-replace table (signature) → what's covered + hard-water card (reverse asymmetric)
 * → installation steps (2-col numbered) → why Ledco → reviews (feed-gated) → FAQ → other services → CTA.
 *
 * Claims: business facts trace to build-plan.json / config.php only. Which heater types/brands Ledco works on
 * (gas, electric, tankless), haul-away of the old tank, permits, prices and warranty terms are NOT in intake —
 * left out and listed in /content-confirmations.json. Part names, failure causes and the repair/replace logic
 * are general water heater knowledge. Hard water: research_brief ("Many Oklahoma homes have hard water...").
 */
$svcSlug = 'water-heater-repair-installation';
$svc = null;
foreach ($services as $svcItem) { if ($svcItem['slug'] === $svcSlug) { $svc = $svcItem; break; } }

$pageTitle       = 'Water Heater Repair & Installation Seminole OK | Ledco Plumbing LLC';
$pageDescription = 'Water heater repair and installation in Seminole, OK. Ledco Plumbing LLC finds why your heater runs cold or leaks, then repairs it or installs a new one.';
$canonicalUrl    = $siteUrl . '/services/water-heater-repair-installation/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'services/water-heater-repair-installation';
$pageType        = 'service';
$serviceSlug     = $svcSlug;

$whPhone     = formatPhone($phone);
$whPhoneHref = phoneHref($phone);

// FAQ — research_brief questions (water heater cost; hard water), answered from intake only
$faqs = [
    [
        'q' => 'How much does a water heater replacement cost?',
        'a' => 'A water heater replacement costs more or less depending on the tank size, whether the heater runs on gas or electricity, and what has to change to connect the new one, such as the vent or the shutoff valve. Ledco Plumbing gives you the price before any work begins, so you can weigh it against repairing the heater you have.',
    ],
    [
        'q' => 'Why does my water heater wear out faster in Oklahoma?',
        'a' => 'Hard water is common in Oklahoma, and heating it drops calcium and magnesium out as scale that settles on the bottom of the tank. On a gas heater that layer sits between the flame and the water, so the burner runs longer and the tank floor runs hotter. Draining a few gallons from the drain valve once a year carries some of it out.',
    ],
];

$pageSchema   = generateServicePageSchema($svc, $pageTitle, $pageDescription);
if ($faqs) $pageSchema[] = generateFAQSchema($faqs);   // FAQPage mirrors the visible FAQ exactly
$schemaMarkup = $pageSchema;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-cards.php';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   services/water-heater-repair-installation — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.wh-page h1, .wh-page h2, .wh-page h3, .wh-table tbody th { text-wrap: balance; }
.wh-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, warm heat glow rising from the bottom edge (C1 layered) ---- */
.wh-hero { background: linear-gradient(180deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 100%); }
.wh-hero::before {
  content: "";
  position: absolute;
  inset: auto -10% -45% 30%;
  height: 120%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 34%, transparent), transparent 70%);
}
.wh-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background-image: radial-gradient(color-mix(in srgb, var(--color-white) 10%, transparent) 1px, transparent 1.5px);
  background-size: var(--space-6) var(--space-6);
  -webkit-mask-image: linear-gradient(80deg, transparent 45%, var(--color-black) 95%);
  mask-image: linear-gradient(80deg, transparent 45%, var(--color-black) 95%);
}
.wh-hero .grain { opacity: .3; }
.wh-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.wh-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.wh-hero .breadcrumb a:hover, .wh-hero .breadcrumb [aria-current] { color: var(--color-white); }
.wh-hero .hero-title { max-width: 20ch; }
.wh-hero .hero-answer { max-width: 36rem; }
.wh-hero .hero-form-card { border-top: 3px solid var(--color-accent); }
.wh-hero .hero-form .consent a { color: var(--color-primary); }
.wh-hero .link-call { color: var(--color-white); }
@media (max-width: 560px) { .wh-hero .hero-answer { font-size: var(--fs-body); } }

/* ---- Signs: centered pull-quote over a 4-up numbered strip ---- */
.wh-signs { background: var(--color-paper); }
.wh-signs .section-title { margin-inline: auto; text-align: center; justify-items: center; }
.wh-signs .answer-block { text-align: left; }
.wh-signs .pull-quote { max-width: 30ch; margin: var(--space-lg) auto var(--space-2xl); text-align: center; font-style: italic; font-size: clamp(1.3rem, 1rem + 1.3vw, 1.9rem); }
.wh-strip { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; margin: 0; padding: 0; list-style: none; border-top: 2px solid var(--color-ink); counter-reset: whsign; }
.wh-strip li { counter-increment: whsign; display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg) var(--space-lg) var(--space-lg) 0; }
.wh-strip li + li { padding-left: var(--space-lg); border-left: 1px solid var(--color-line); }
.wh-strip li::before { content: counter(whsign, decimal-leading-zero); font-family: var(--font-accent); font-size: var(--fs-h2); line-height: 1; color: var(--color-accent-dark); }
.wh-strip h3 { margin: 0; font-size: var(--fs-h3); }
.wh-strip p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.wh-strip li:last-child { background: var(--color-card-tint-3); padding-right: var(--space-lg); border-radius: 0 0 var(--radius-lg) var(--radius-lg); }
@media (max-width: 1000px) {
  .wh-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .wh-strip li:nth-child(3) { padding-left: 0; border-left: 0; }
  .wh-strip li:nth-child(n+3) { border-top: 1px solid var(--color-line); }
}
@media (max-width: 600px) {
  .wh-strip { grid-template-columns: 1fr; }
  .wh-strip li, .wh-strip li + li { padding-left: 0; border-left: 0; }
  .wh-strip li + li { border-top: 1px solid var(--color-line); }
  .wh-strip li:last-child { padding-left: var(--space-lg); }
}

/* ---- Repair or replace table (signature): verdict pills ---- */
.wh-decide { background: var(--color-surface); }
.wh-decide__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 2fr); gap: clamp(var(--space-xl), 4vw, var(--space-3xl)); align-items: start; }
.wh-decide .section-title { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.wh-decide__tip { display: flex; gap: var(--space-sm); padding: var(--space-md); border-radius: var(--radius); background: var(--color-paper-2); font-size: var(--fs-small); color: var(--color-ink-2); }
.wh-decide__tip svg { flex: 0 0 auto; color: var(--color-accent-dark); margin-top: var(--space-1); }
.wh-table { width: 100%; border-collapse: separate; border-spacing: 0 var(--space-2); font-size: var(--fs-small); }
.wh-table caption { text-align: left; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); padding-bottom: var(--space-2); }
.wh-table thead th { text-align: left; padding: 0 var(--space-md) var(--space-2); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.wh-table tbody th, .wh-table tbody td { padding: var(--space-md); background: var(--color-paper); vertical-align: top; text-align: left; }
.wh-table tbody th { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); border-radius: var(--radius) 0 0 var(--radius); width: 30%; }
.wh-table tbody td:last-child { border-radius: 0 var(--radius) var(--radius) 0; width: 22%; }
.wh-table td { color: var(--color-ink-2); }
.wh-pill { display: inline-flex; align-items: center; gap: var(--space-1); padding: var(--space-1) var(--space-sm); border-radius: var(--radius-full); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .1em; text-transform: uppercase; white-space: nowrap; }
.wh-pill--repair { background: var(--color-card-tint-1); color: var(--color-primary); border: 1px solid var(--color-line); }
.wh-pill--replace { background: var(--color-accent-dark); color: var(--color-white); }
.wh-pill--check { background: var(--color-card-tint-3); color: var(--color-accent-dark); }
@media (max-width: 1000px) {
  .wh-decide__grid { grid-template-columns: 1fr; }
  .wh-decide .section-title { position: static; }
}
@media (max-width: 700px) {
  .wh-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .wh-table, .wh-table tbody, .wh-table tr, .wh-table th, .wh-table td { display: block; width: 100%; }
  .wh-table tbody tr { margin-bottom: var(--space-sm); border-radius: var(--radius); overflow: hidden; }
  .wh-table tbody th, .wh-table tbody td, .wh-table tbody td:last-child { width: 100%; border-radius: 0; padding: var(--space-sm) var(--space-md); }
}

/* ---- What's covered: reverse asymmetric with hard-water card ---- */
.wh-scope { background: var(--color-paper-2); }
.wh-scope__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.6fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.wh-scope__body { display: grid; gap: var(--space-md); order: 2; }
.wh-scope__body > p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.wh-scope__body a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.wh-water { order: 1; position: relative; margin-top: var(--space-2xl); padding: var(--space-xl); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-lg); display: grid; gap: var(--space-sm); }
.wh-water::before { content: ""; position: absolute; inset: calc(-1 * var(--space-4)) calc(-1 * var(--space-4)) var(--space-4) var(--space-4); border: 2px solid var(--color-accent); border-radius: var(--radius-lg); opacity: .45; z-index: -1; }
.wh-water__icon { width: var(--space-12); height: var(--space-12); display: grid; place-items: center; border-radius: var(--radius-full); background: var(--color-card-tint-3); color: var(--color-accent-dark); }
.wh-water b { font-family: var(--font-heading); font-size: var(--fs-h3); color: var(--color-ink); }
.wh-water p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 900px) {
  .wh-scope__grid { grid-template-columns: 1fr; }
  .wh-scope__body { order: 1; }
  .wh-water { order: 2; margin: var(--space-md) var(--space-md) 0 0; }
}

/* ---- Installation steps: two-column numbered (framework .process-steps) ---- */
.wh-install { background: var(--color-surface); }
.wh-install .process-steps { margin-top: var(--space-xl); gap: var(--space-lg) var(--space-2xl); }
.wh-install .process-steps li { padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-paper); border: 1px solid var(--color-line); transition: border-color var(--transition); }
.wh-install .process-steps li:hover { border-color: var(--color-accent); }
.wh-install .process-steps li::before { background: var(--color-surface); }

/* ---- Why Ledco: split heading + 2x2 list on dark ---- */
.wh-why__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.25fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.wh-why .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.wh-why__list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-lg); margin: 0; padding: 0; list-style: none; }
.wh-why__list li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-1) var(--space-sm); align-items: start; padding-top: var(--space-md); border-top: 1px solid color-mix(in srgb, var(--color-white) 18%, transparent); }
.wh-why__list svg { grid-row: span 2; color: var(--color-accent-bright); margin-top: var(--space-1); }
.wh-why__list b { font-family: var(--font-heading); color: var(--color-white); }
.wh-why__list span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
@media (max-width: 900px) { .wh-why__grid { grid-template-columns: 1fr; } }
@media (max-width: 560px) { .wh-why__list { grid-template-columns: 1fr; } }

/* ---- FAQ ---- */
.wh-faq { background: var(--color-paper); }
.wh-faq .faq[open] { border-top-color: var(--color-accent); }
.wh-faq .faq summary:hover { color: var(--color-accent-dark); }

/* ---- Other services ---- */
.wh-more { background: var(--color-surface); }
.wh-more .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.wh-more .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.wh-more .service-card__icon { margin-top: 0; width: var(--space-12); height: var(--space-12); color: var(--color-accent-dark); border: 1px solid var(--color-line); }
.wh-more .services-foot { margin-top: var(--space-xl); }
.wh-more .services-foot a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 900px) { .wh-more .services-grid { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.wh-cta .wh-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.wh-cta .wh-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="wh-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type wh-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/services/">Services</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Water Heater Repair &amp; Installation</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Seminole, OK &middot; Water heaters</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Water heater</span> repair &amp; installation in Seminole, OK</h1>
        <p class="hero-answer">Ledco Plumbing LLC repairs water heaters that run cold, leak or rumble, and installs a new heater when the old tank is past saving, for homes and businesses in Seminole and Wewoka. Call <?php echo esc($whPhone); ?> seven days a week, or send the form and describe what your heater is doing.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($whPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($whPhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('wrench', 16); ?> Repair or replacement</li>
          <li><?php icon('building-2', 16); ?> Homes &amp; businesses</li>
          <li><?php icon('clock', 16); ?> Open Mon&ndash;Sun</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a water heater estimate?</h2>
        <p class="hero-form-tagline">Tell us what the heater is doing and Ledco Plumbing will call you back.</p>
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
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($svc['name']); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Request my estimate</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<article class="wh-article">
<!-- ============================================================ SIGNS -->
<section class="section wh-signs" id="signs" aria-labelledby="signs-title">
  <div class="container">
    <div class="section-title reveal-down">
      <span class="eyebrow-label">Warning signs</span>
      <h2 id="signs-title">What are the signs a <span class="text-accent">water heater</span> is failing?</h2>
      <p class="answer-block">A water heater is failing when hot water runs out sooner than it used to, comes out rusty, or the tank pops and rumbles while it heats. Water pooling around the base is the most serious sign, because a tank that has rusted through cannot be patched.</p>
    </div>
    <p class="pull-quote reveal-scale">A drip from a fitting is a repair. A drip from the tank itself is a replacement.</p>
    <ol class="wh-strip reveal-up">
      <li>
        <h3>Hot water runs out fast</h3>
        <p>Sediment is taking up room in the bottom of the tank, the lower element on an electric heater has failed, or the dip tube that carries cold water to the bottom has cracked.</p>
      </li>
      <li>
        <h3>Popping or rumbling</h3>
        <p>Water trapped under a layer of mineral scale boils in small pockets as the burner heats it. The noise is the scale, and it means the tank is working harder than it should.</p>
      </li>
      <li>
        <h3>Rusty or smelly hot water</h3>
        <p>Rust in the hot water only can mean the anode rod is used up and the steel tank has started to corrode. A rotten-egg smell often comes from the same rod reacting with the water.</p>
      </li>
      <li>
        <h3>Water around the base</h3>
        <p>Check the drain valve and the relief-valve pipe first. If the water is seeping from the tank itself, turn off the heater's cold-water supply and call.</p>
      </li>
    </ol>
  </div>
</section>

<!-- ============================================================ REPAIR OR REPLACE (signature) -->
<section class="section slant-top wh-decide" id="repair-or-replace" aria-labelledby="decide-title">
  <div class="container-wide">
    <div class="wh-decide__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">Repair or replace</span>
        <h2 id="decide-title">Should you repair or replace your water heater?</h2>
        <p class="answer-block">Repair a water heater when a replaceable part has failed and the tank is sound. Replace it when the tank leaks, is badly scaled, or the heater is old enough that the next failure is close behind. The table shows which way the common water heater problems usually go.</p>
        <p class="wh-decide__tip"><?php icon('info', 18); ?><span>The heater's age is on its label: most manufacturers code the build month and year into the serial number. Have a photo of the label ready when you call.</span></p>
      </div>
      <div class="reveal-right">
        <table class="wh-table">
          <caption>Common water heater problems and whether they usually mean repair or replacement</caption>
          <thead>
            <tr>
              <th scope="col">What you notice</th>
              <th scope="col">What it usually means</th>
              <th scope="col">Usual outcome</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">No hot water from a gas heater</th>
              <td>The burner is not lighting: a worn thermocouple or flame sensor, or a failed gas control valve</td>
              <td><span class="wh-pill wh-pill--repair">Repair</span></td>
            </tr>
            <tr>
              <th scope="row">No hot water from an electric heater</th>
              <td>A tripped high-limit switch, a burned-out element or a failed thermostat</td>
              <td><span class="wh-pill wh-pill--repair">Repair</span></td>
            </tr>
            <tr>
              <th scope="row">Hot water runs out quickly</th>
              <td>Sediment in the tank, a failed lower element or a broken dip tube</td>
              <td><span class="wh-pill wh-pill--repair">Repair or flush</span></td>
            </tr>
            <tr>
              <th scope="row">Water dripping from the relief-valve pipe</th>
              <td>The tank is running too hot or at too much pressure, or the relief valve itself is worn. That valve is a safety device</td>
              <td><span class="wh-pill wh-pill--check">Check soon</span></td>
            </tr>
            <tr>
              <th scope="row">Rusty hot water from an older tank</th>
              <td>The tank lining is corroding from the inside</td>
              <td><span class="wh-pill wh-pill--replace">Usually replace</span></td>
            </tr>
            <tr>
              <th scope="row">Leak from the tank body</th>
              <td>The steel tank has rusted through</td>
              <td><span class="wh-pill wh-pill--replace">Replace</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ WHAT'S COVERED -->
<section class="section wh-scope" id="included" aria-labelledby="included-title">
  <div class="container">
    <div class="wh-scope__grid">
      <div class="wh-scope__body reveal-right">
        <span class="eyebrow-label">What's covered</span>
        <h2 id="included-title">What does water heater service from <span class="text-accent">Ledco Plumbing</span> cover?</h2>
        <p class="answer-block">Ledco Plumbing LLC repairs water heaters that have stopped working properly and installs new ones when repair no longer makes sense. Every job starts by finding out why the heater failed, so a worn part is not mistaken for a dead tank and you are not sold a heater you did not need.</p>
        <p>Most "no hot water" calls come down to one part. Which part depends on the fuel: on a gas heater it is usually the thermocouple or flame sensor, the gas control valve or the burner; on an electric heater it is usually a heating element or the thermostat that controls it. Those are repairs, and the tank goes back to work.</p>
        <p>The tank is a different story. Once the steel has rusted through, water seeps from the seams or the bottom, and there is nothing left to fix. That is when Ledco Plumbing sizes and installs a replacement heater for your home or business in Seminole or Wewoka.</p>
        <p>Not every puddle near a water heater comes from the heater. A supply line, a nearby fixture or a pipe in the wall can leak onto the same floor, and that calls for <a href="/services/leak-detection-repair/">leak detection and repair</a> instead of a new tank. Ledco's other services are on the <a href="/services/">plumbing services page</a>.</p>
      </div>
      <aside class="wh-water reveal-left" aria-label="Hard water and water heaters">
        <span class="wh-water__icon"><?php icon('droplets', 24); ?></span>
        <b>Oklahoma hard water</b>
        <p>Many Oklahoma homes have hard water. Every time the tank heats, some of the calcium and magnesium drops out as scale and settles on the bottom. That layer is behind the popping noise, the shrinking hot-water supply and a lot of early tank failures.</p>
        <p>Flushing a few gallons out of the drain valve once a year slows the buildup. A water softener cuts it off at the source.</p>
      </aside>
    </div>
  </div>
</section>

<!-- ============================================================ INSTALLATION STEPS -->
<section class="section edge-curve-top wh-install" id="installation" aria-labelledby="install-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Installation</span>
      <h2 id="install-title">What happens when Ledco Plumbing installs a new water heater?</h2>
      <p class="answer-block">A water heater installation runs in four stages, and you approve the estimate before the old heater is disconnected. The stages are choosing a heater that fits your home, shutting off and draining the old one, setting and connecting the new heater, then filling it and checking every joint while it heats.</p>
    </div>
    <ol class="process-steps reveal-up">
      <li><b>Size the replacement</b><span>Household size, fuel type and the space the old tank fills decide which heater fits. A photo of the old heater's label tells the plumber most of that before the visit.</span></li>
      <li><b>Shut off and drain</b><span>The gas or power is turned off, the cold-water supply closed, and the old tank drained through its valve so it can be moved.</span></li>
      <li><b>Set and connect</b><span>The new heater goes in place and is connected to the water lines and its fuel supply, gas heaters to their vent as well, with a discharge pipe on the relief valve.</span></li>
      <li><b>Fill, then fire up</b><span>The tank is filled with water before the gas or power comes back on. An electric element switched on in an empty tank burns out in seconds. Every joint is then checked for leaks while the water heats.</span></li>
    </ol>
  </div>
</section>

<!-- ============================================================ WHY LEDCO -->
<section class="section on-dark texture-grain edge-torn-top wh-why" id="why" aria-labelledby="why-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="wh-why__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">Why Ledco Plumbing</span>
        <h2 id="why-title">Why choose Ledco Plumbing for a water heater in <span class="text-accent">Seminole</span>?</h2>
        <p class="answer-block">Ledco Plumbing LLC checks why a water heater failed before recommending a fix, gives you the price up front, and takes calls on Saturdays and Sundays too. The company is owned by Mickey Ledbetter and works from an office at 316 E Oak Ave in Seminole.</p>
      </div>
      <ul class="wh-why__list reveal-right">
        <li><?php icon('search', 22); ?><b>Cause before cure</b><span>The heater is checked to see whether a part or the tank has failed.</span></li>
        <li><?php icon('clipboard-list', 22); ?><b>Repair or replace, priced</b><span>You see the estimate before work starts.</span></li>
        <li><?php icon('calendar', 22); ?><b>Weekend calls</b><span>A heater that quits on Saturday can be reported on Saturday.</span></li>
        <li><?php icon('building-2', 22); ?><b>Homes and businesses</b><span>Residential tanks and heaters for Seminole-area businesses.</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- ============================================================ REVIEWS (Page One feed; renders only when real reviews exist) -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$whReviews = p1_google_reviews($slug, ['heading' => 'What do Seminole customers say about Ledco Plumbing on Google?', 'limit' => 6]);
if ($whReviews !== ''): ?>
<section class="section wh-reviews" aria-label="Google reviews"><div class="container"><?php echo $whReviews; ?></div></section>
<?php endif; ?>

<!-- ============================================================ FAQ -->
<section class="section wh-faq" id="faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">What do Seminole customers ask about <span class="text-accent">water heaters</span>?</h2>
      <p class="answer-block">The two water heater questions Seminole customers ask most are what a replacement costs and why heaters seem to wear out quickly in Oklahoma. Ledco Plumbing LLC answers both below. For anything about your own heater, call the office at <?php echo esc($whPhone); ?>.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($faqs as $whFaqIdx => $whFaq): ?>
      <details class="faq"<?php echo $whFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($whFaq['q']); ?></summary>
        <p><?php echo esc($whFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
</article>

<!-- ============================================================ OTHER SERVICES -->
<section class="section wh-more" aria-label="Other plumbing services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which other <span class="text-accent">plumbing services</span> does Ledco Plumbing offer?</h2>
      <p class="answer-block">Along with water heater repair and installation, Ledco Plumbing LLC finds hidden leaks, repairs sewer lines, clears drains and handles commercial plumbing across Seminole and Wewoka. The three below are the services Seminole customers most often need next to a water heater job.</p>
    </div>
    <div class="services-grid">
<?php foreach (p1_other_services($svcSlug) as $whIdx => $whOther) p1_render_service_card($whOther, $whIdx + 1, 'reveal-up'); ?>
    </div>
    <p class="services-foot reveal-up"><a href="/services/">See all five Ledco Plumbing services &rarr;</a></p>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top wh-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Ready for hot water again?</h2>
      <p>Call Ledco Plumbing at <?php echo esc($whPhone); ?> or request an estimate online. If the tank is leaking, close its cold-water valve first.</p>
      <p class="wh-cta__links"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">See Ledco Plumbing on Google Maps</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($whPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
