<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * services/leak-detection-repair/index.php — Leak Detection & Repair (Phase 4, premium editorial service page, minimal-tech).
 *
 * Section script: interior type hero + form → meter leak test (signature, numbered card rail) → hidden-leak signs
 * (asymmetric bento) → freeze band (stats) → where leaks hide (table) → find-and-fix timeline → why Ledco
 * → reviews (feed-gated) → FAQ → other services → CTA.
 *
 * Local sources:
 *   Feb 2021 freeze — Oklahoma Mesonet / Oklahoma Climatological Survey: on Feb 16, 2021 all 120 Mesonet stations
 *   fell below zero for the first time in the network's history; Oklahoma Dept. of Emergency Management reported
 *   more than 120 public water systems damaged. https://www.mesonet.org/news (article "Historically frigid February
 *   punctuates winter"); https://climate.ok.gov/index.php/climate/weather_timeline/2020_2029
 *   Soil — USDA NRCS Official Series Description "SEMINOLE": clayey, slow permeability, central Oklahoma.
 *   https://soilseries.sc.egov.usda.gov/OSD_Docs/S/SEMINOLE.html
 * Water expands about 9% on freezing (physical fact). Leak-detection equipment, response times and prices are NOT
 * in intake — left out and listed in /content-confirmations.json.
 */
$svcSlug = 'leak-detection-repair';
$svc = null;
foreach ($services as $svcItem) { if ($svcItem['slug'] === $svcSlug) { $svc = $svcItem; break; } }

$pageTitle       = 'Leak Detection & Repair Seminole OK | Ledco Plumbing LLC';
$pageDescription = 'Leak detection and repair in Seminole, OK. Ledco Plumbing LLC traces high water bills and hidden leaks in walls, slabs and yard lines. Call (405) 257-3096.';
$canonicalUrl    = $siteUrl . '/services/leak-detection-repair/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'services/leak-detection-repair';
$pageType        = 'service';
$serviceSlug     = $svcSlug;

$ldPhone     = formatPhone($phone);
$ldPhoneHref = phoneHref($phone);

// FAQ — research_brief question (emergency service: burst pipes), answered from intake only
$faqs = [
    [
        'q' => 'Do you offer emergency plumbing service in Seminole?',
        'a' => 'Ledco Plumbing LLC takes calls seven days a week from 7 AM to 5 PM. For a burst pipe, close the main shutoff valve first, usually where the water line enters the house or inside the meter box near the street, then call (405) 257-3096 rather than sending the form so the office hears about it right away.',
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
   services/leak-detection-repair — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.ld-page h1, .ld-page h2, .ld-page h3, .ld-table tbody th { text-wrap: balance; }
.ld-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, concentric "ripple" rings off the right edge (C1 layered) ---- */
.ld-hero { background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-primary-deep) 100%); }
.ld-hero::before {
  content: "";
  position: absolute;
  right: -12%;
  top: 50%;
  width: min(60vw, 52rem);
  aspect-ratio: 1;
  transform: translateY(-50%);
  z-index: -1;
  pointer-events: none;
  background: repeating-radial-gradient(circle, transparent 0 var(--space-10), color-mix(in srgb, var(--color-white) 7%, transparent) var(--space-10) calc(var(--space-10) + 1px));
  -webkit-mask-image: radial-gradient(closest-side, var(--color-black) 30%, transparent);
  mask-image: radial-gradient(closest-side, var(--color-black) 30%, transparent);
}
.ld-hero::after {
  content: "";
  position: absolute;
  inset: -20% auto auto -10%;
  width: 50%;
  height: 90%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%);
}
.ld-hero .grain { opacity: .3; }
.ld-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.ld-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.ld-hero .breadcrumb a:hover, .ld-hero .breadcrumb [aria-current] { color: var(--color-white); }
.ld-hero .hero-title { max-width: 22ch; }
.ld-hero .hero-answer { max-width: 36rem; }
.ld-hero .hero-form-card { border-top: 3px solid var(--color-accent); }
.ld-hero .hero-form .consent a { color: var(--color-primary); }
.ld-hero .link-call { color: var(--color-white); }
@media (max-width: 560px) { .ld-hero .hero-answer { font-size: var(--fs-body); } }

/* ---- Meter test (signature): card rail with large step numerals ---- */
.ld-meter { background: var(--color-paper); }
.ld-meter__head { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 4vw, var(--space-3xl)); align-items: end; margin-bottom: var(--space-xl); }
.ld-meter__head .section-title { margin-bottom: 0; }
.ld-meter__note { display: flex; gap: var(--space-sm); padding: var(--space-md) var(--space-lg); border-radius: var(--radius-lg); background: var(--color-dark); color: color-mix(in srgb, var(--color-white) 84%, transparent); font-size: var(--fs-small); }
.ld-meter__note svg { flex: 0 0 auto; color: var(--color-accent-bright); margin-top: var(--space-1); }
.ld-steps { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; counter-reset: ldstep; }
.ld-steps li { counter-increment: ldstep; position: relative; display: grid; gap: var(--space-2); align-content: start; padding: var(--space-3xl) var(--space-lg) var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); overflow: hidden; transition: transform var(--transition), box-shadow var(--transition); }
.ld-steps li:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow); }
.ld-steps li::before { content: counter(ldstep); position: absolute; top: var(--space-sm); right: var(--space-md); font-family: var(--font-accent); font-size: clamp(3rem, 2rem + 2vw, 4.25rem); line-height: 1; color: color-mix(in srgb, var(--color-accent) 22%, transparent); }
.ld-steps li::after { content: ""; position: absolute; left: var(--space-lg); top: var(--space-lg); width: var(--space-8); height: 3px; background: var(--color-accent); border-radius: var(--radius-full); }
.ld-steps b { font-family: var(--font-heading); color: var(--color-ink); }
.ld-steps span { font-size: var(--fs-small); color: var(--color-ink-2); }
.ld-steps li:nth-child(4) { background: var(--color-card-tint-3); }
@media (max-width: 1100px) { .ld-steps { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
@media (max-width: 900px) { .ld-meter__head { grid-template-columns: 1fr; } }
@media (max-width: 700px) { .ld-steps { grid-template-columns: 1fr; } }

/* ---- Signs: asymmetric bento (one large tile) ---- */
.ld-signs { background: var(--color-surface); }
.ld-signs .bento-grid { grid-auto-rows: minmax(var(--space-4xl), auto); }
.ld-signs .bento-item { display: grid; gap: var(--space-2); align-content: end; padding: var(--space-lg); transition: border-color var(--transition); }
.ld-signs .bento-item:hover { border-color: var(--color-accent); }
.ld-signs .bento-large { grid-column: span 6; grid-row: span 2; background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-primary-deep) 140%); color: var(--color-white); border-color: transparent; align-content: space-between; }
.ld-signs .bento-large h3 { color: var(--color-white); font-size: var(--fs-h2); }
.ld-signs .bento-large p { color: color-mix(in srgb, var(--color-white) 84%, transparent); font-size: var(--fs-body); }
.ld-signs .bento-large .pull-quote { color: var(--color-white); font-size: clamp(1.2rem, 1rem + .9vw, 1.6rem); font-style: italic; max-width: 28ch; margin: 0; }
.ld-signs .bento-large .pull-quote::before { color: var(--color-accent-bright); }
.ld-signs .bento-small { grid-column: span 3; }
.ld-signs .bento-small:nth-of-type(2) { background: var(--color-card-tint-1); }
.ld-signs .bento-small:nth-of-type(3) { background: var(--color-card-tint-2); }
.ld-signs .bento-small:nth-of-type(4) { background: var(--color-card-tint-3); }
.ld-signs .bento-small:nth-of-type(5) { background: var(--color-paper); }
.ld-signs .bento-small svg { color: var(--color-accent-dark); }
.ld-signs .bento-small h3 { margin: 0; font-size: var(--fs-h3); }
.ld-signs .bento-small p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) { .ld-signs .bento-large { grid-column: span 12; } .ld-signs .bento-small { grid-column: span 6; } }
@media (max-width: 600px) { .ld-signs .bento-small { grid-column: span 12; } }

/* ---- Freeze band: dark, stats + explainer ---- */
.ld-freeze .container { display: grid; gap: var(--space-xl); }
.ld-freeze .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); max-width: 70ch; }
.ld-freeze__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)) minmax(0, 1.4fr); gap: var(--space-md); align-items: stretch; }
.ld-freeze__stat { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); background: color-mix(in srgb, var(--color-white) 4%, transparent); }
.ld-freeze__stat b { font-family: var(--font-accent); font-size: clamp(2.4rem, 1.8rem + 2vw, 3.4rem); line-height: 1; color: var(--color-accent-bright); }
.ld-freeze__stat span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.ld-freeze__risk { padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-ink); display: grid; gap: var(--space-2); align-content: start; }
.ld-freeze__risk h3 { margin: 0; color: var(--color-ink); font-size: var(--fs-h3); }
.ld-freeze__risk ul { margin: 0; padding-left: var(--space-lg); display: grid; gap: var(--space-1); font-size: var(--fs-small); color: var(--color-ink-2); }
.ld-freeze__risk li::marker { color: var(--color-accent-dark); }
.ld-freeze .ld-freeze__source { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 64%, transparent); }
.ld-freeze .ld-freeze__source a { color: inherit; text-underline-offset: .2em; }
@media (max-width: 1000px) { .ld-freeze__grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } .ld-freeze__risk { grid-column: 1 / -1; } }
@media (max-width: 640px) { .ld-freeze__grid { grid-template-columns: 1fr; } }

/* ---- Where leaks hide (table) + clay note ---- */
.ld-where { background: var(--color-paper-2); }
.ld-where__grid { display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, .9fr); gap: clamp(var(--space-xl), 4vw, var(--space-3xl)); align-items: start; }
.ld-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); background: var(--color-surface); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow); }
.ld-table caption { text-align: left; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); padding-bottom: var(--space-sm); }
.ld-table thead th { text-align: left; padding: var(--space-md); background: var(--color-dark); color: var(--color-white); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; }
.ld-table tbody th, .ld-table tbody td { padding: var(--space-md); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.ld-table tbody tr:nth-child(even) { background: var(--color-paper); }
.ld-table tbody th { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); width: 22%; }
.ld-table td { color: var(--color-ink-2); }
.ld-table a { color: var(--color-primary); font-weight: 600; }
.ld-clay { display: grid; gap: var(--space-sm); padding: var(--space-lg); border-radius: var(--radius-lg); border-left: 4px solid var(--color-accent); background: var(--color-surface); box-shadow: var(--shadow-sm); }
.ld-clay svg { color: var(--color-accent-dark); }
.ld-clay b { font-family: var(--font-heading); }
.ld-clay p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) { .ld-where__grid { grid-template-columns: 1fr; } }
@media (max-width: 700px) {
  .ld-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .ld-table, .ld-table tbody, .ld-table tr, .ld-table th, .ld-table td { display: block; width: 100%; }
  .ld-table tbody tr { padding: var(--space-sm) 0; border-bottom: 1px solid var(--color-line); }
  .ld-table tbody th, .ld-table tbody td { border: 0; padding: var(--space-1) var(--space-md); width: 100%; }
  .ld-table td[data-label]::before { content: attr(data-label) ": "; font-weight: 700; color: var(--color-ink); }
}

/* ---- Find-and-fix timeline ---- */
.ld-process { background: var(--color-surface); }
.ld-process__grid { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.ld-process .timeline { margin: 0; gap: var(--space-xl); order: -1; }
.ld-process .timeline > li { display: grid; gap: var(--space-1); padding-left: var(--space-sm); }
.ld-process .timeline > li::before { background: var(--color-dark); box-shadow: 0 0 0 var(--space-1) var(--color-accent); }
.ld-process .timeline b { font-family: var(--font-heading); font-size: var(--fs-h3); color: var(--color-ink); }
.ld-process .timeline span { color: var(--color-ink-2); font-size: var(--fs-small); max-width: 54ch; }
@media (max-width: 900px) { .ld-process__grid { grid-template-columns: 1fr; } .ld-process .timeline { order: 0; } }

/* ---- Why Ledco: light band, numbered columns ---- */
.ld-why { background: var(--color-paper); }
.ld-why__list { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-lg) 0 0; padding: 0; list-style: none; }
.ld-why__list li { display: grid; gap: var(--space-2); align-content: start; padding-top: var(--space-md); border-top: 3px solid var(--color-ink); }
.ld-why__list li:nth-child(2) { border-top-color: var(--color-accent); }
.ld-why__list svg { color: var(--color-accent-dark); }
.ld-why__list b { font-family: var(--font-heading); color: var(--color-ink); }
.ld-why__list span { font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) { .ld-why__list { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .ld-why__list { grid-template-columns: 1fr; } }

/* ---- FAQ (single question: one column) ---- */
.ld-faq { background: var(--color-surface); }
.ld-faq .faq-grid { grid-template-columns: 1fr; max-width: var(--measure); }
.ld-faq .faq[open] { border-top-color: var(--color-accent); }

/* ---- Other services ---- */
.ld-more { background: var(--color-paper-2); }
.ld-more .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.ld-more .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.ld-more .service-card__icon { margin-top: 0; width: var(--space-12); height: var(--space-12); color: var(--color-accent-dark); border: 1px solid var(--color-line); }
.ld-more .services-foot { margin-top: var(--space-xl); }
.ld-more .services-foot a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 900px) { .ld-more .services-grid { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.ld-cta .ld-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.ld-cta .ld-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="ld-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type ld-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/services/">Services</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Leak Detection &amp; Repair</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Seminole, OK &middot; Leak detection</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Leak detection</span> &amp; repair in Seminole, OK</h1>
        <p class="hero-answer">Ledco Plumbing LLC finds hidden water leaks in walls, floors, slabs and yard lines, then repairs the pipe, for homes and businesses in Seminole and Wewoka. If the water bill jumped or you can hear water running with everything off, call <?php echo esc($ldPhone); ?> or send the form.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($ldPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($ldPhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('search', 16); ?> Walls, slabs &amp; yard lines</li>
          <li><?php icon('droplets', 16); ?> High water bills traced</li>
          <li><?php icon('map-pin', 16); ?> Seminole &amp; Wewoka</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a leak repair estimate?</h2>
        <p class="hero-form-tagline">Tell us what you are seeing (or hearing) and Ledco Plumbing will call you back.</p>
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

<article class="ld-article">
<!-- ============================================================ METER TEST (signature) -->
<section class="section ld-meter" id="meter-test" aria-labelledby="meter-title">
  <div class="container-wide">
    <div class="ld-meter__head">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">Check it yourself</span>
        <h2 id="meter-title">How can you check for a hidden <span class="text-accent">leak</span> before you call?</h2>
        <p class="answer-block">Turn off every faucet and water-using appliance, then watch the water meter for 15 minutes. If the dial or the small leak indicator moves while nothing is running, water is escaping somewhere between the meter and your fixtures, and the steps below narrow down where.</p>
      </div>
      <p class="ld-meter__note reveal-right"><?php icon('info', 18); ?><span>The test takes about 20 minutes and no tools beyond a flashlight. Tell Ledco Plumbing what you found when you call: it tells the plumber whether to start inside the house or out in the yard.</span></p>
    </div>
    <ol class="ld-steps reveal-up">
      <li><b>Find the meter</b><span>It is usually in a ground-level box near the street. The lid lifts off with a screwdriver; watch for wasps and spiders.</span></li>
      <li><b>Stop all water use</b><span>Turn off faucets and make sure no toilet is refilling and the washer, dishwasher and ice maker are idle.</span></li>
      <li><b>Read the leak indicator</b><span>Most meters have a small triangle or star that spins with even a trickle. Note the reading, wait 15 minutes, read it again.</span></li>
      <li><b>Close the house valve</b><span>Shut the main valve where the line enters the house. If the meter still moves, the leak is in the yard line. If it stops, the leak is inside.</span></li>
      <li><b>Test the toilets</b><span>Put a few drops of food coloring in each tank. Color in the bowl within 15 minutes means the flapper leaks, a simple fix.</span></li>
    </ol>
  </div>
</section>

<!-- ============================================================ SIGNS -->
<section class="section edge-parallelogram-top ld-signs" id="signs" aria-labelledby="signs-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Warning signs</span>
      <h2 id="signs-title">What are the signs of a <span class="text-accent">hidden water leak</span>?</h2>
      <p class="answer-block">The clearest sign of a hidden water leak is a water bill that rises with no change in use. Others are the sound of running water when every tap is off, a warm spot on a slab floor, stains or bubbling paint, and a soggy patch of yard. Any one of them is worth a meter test.</p>
    </div>
    <div class="bento-grid reveal-up">
      <div class="bento-item bento-large">
        <p class="pull-quote">Water you pay for and never use is going somewhere: into a wall, under the slab or into the yard.</p>
        <div>
          <h3>The bill jumps</h3>
          <p>A leak runs day and night, so even a small one shows up on the next water bill. Compare it with the same month last year; if your habits have not changed and the number has, start with the meter test above.</p>
        </div>
      </div>
      <div class="bento-item bento-small"><?php icon('waves', 22); ?><h3>Running water, taps off</h3><p>A hiss or trickle in a wall or under the floor when nothing is in use.</p></div>
      <div class="bento-item bento-small"><?php icon('flame', 22); ?><h3>A warm spot on the floor</h3><p>On a slab house, a warm patch you can feel barefoot points to a leaking hot-water line underneath.</p></div>
      <div class="bento-item bento-small"><?php icon('paint-bucket', 22); ?><h3>Stains or bubbling paint</h3><p>Brown rings on a ceiling, paint that blisters, drywall that gives when pressed, a musty smell in one room.</p></div>
      <div class="bento-item bento-small"><?php icon('sprout', 22); ?><h3>A soggy patch of yard</h3><p>A strip that stays wet or grows greener than the rest, often between the meter and the house.</p></div>
    </div>
  </div>
</section>

<!-- ============================================================ FREEZE BAND -->
<section class="section on-dark texture-grain slant-top ld-freeze" id="freeze" aria-labelledby="freeze-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Oklahoma winters</span>
      <h2 id="freeze-title">Why do pipes leak after an <span class="text-accent">Oklahoma freeze</span>?</h2>
      <p class="answer-block">Pipes leak after an Oklahoma freeze because water expands by about 9 percent as it turns to ice, which splits the pipe holding it. The split stays plugged with ice until the thaw, so the leak often starts days after the cold snap, inside a wall or crawl space where nobody sees it.</p>
    </div>
    <div class="ld-freeze__grid reveal-up">
      <div class="ld-freeze__stat"><b>9%</b><span>How much water expands when it freezes, enough to split copper, galvanized steel and plastic pipe.</span></div>
      <div class="ld-freeze__stat"><b>120</b><span>Oklahoma Mesonet weather stations, every one of them, below zero on the morning of February 16, 2021, a first for the network.</span></div>
      <div class="ld-freeze__stat"><b>Feb 2021</b><span>The same storm left frozen and burst pipes in homes and businesses across the state, and damaged more than 120 public water systems.</span></div>
      <div class="ld-freeze__risk">
        <h3>Pipes that split first</h3>
        <ul>
          <li>Lines on outside walls, especially behind kitchen sinks</li>
          <li>Pipes in crawl spaces and unheated garages</li>
          <li>Outdoor hose bibs left with a hose attached</li>
          <li>Supply lines in attics</li>
        </ul>
      </div>
    </div>
    <p class="ld-freeze__source">Freeze figures: <a href="https://www.mesonet.org/news" target="_blank" rel="noopener">Oklahoma Mesonet</a> and the Oklahoma Climatological Survey.</p>
  </div>
</section>

<!-- ============================================================ WHERE LEAKS HIDE (table) -->
<section class="section ld-where" id="where" aria-labelledby="where-title">
  <div class="container-wide">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Where leaks hide</span>
      <h2 id="where-title">Where do hidden leaks happen, and how does each one show up?</h2>
      <p class="answer-block">Hidden leaks happen in five places: under a slab, inside a wall, in the yard service line, at a toilet or fixture, and at the water heater. Each one leaves a different clue, and each needs a different repair, which is why finding the exact spot comes before anything is opened up.</p>
    </div>
    <div class="ld-where__grid">
      <div class="reveal-left">
        <table class="ld-table">
          <caption>Hidden leak locations, their signs and what the repair involves</caption>
          <thead>
            <tr>
              <th scope="col">Where</th>
              <th scope="col">What you notice</th>
              <th scope="col">What the repair involves</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Under a slab</th>
              <td data-label="Signs">Warm spot on the floor, running-water sound, meter moving with the house valve open</td>
              <td data-label="Repair">Reaching the pipe through the floor at the leak, or rerouting the line through a wall or attic</td>
            </tr>
            <tr>
              <th scope="row">Inside a wall</th>
              <td data-label="Signs">Stain, bubbling paint, soft drywall, musty smell in one room</td>
              <td data-label="Repair">Opening the wall at the wet spot and replacing the damaged section of pipe</td>
            </tr>
            <tr>
              <th scope="row">Yard service line</th>
              <td data-label="Signs">Soggy or extra-green strip, meter still moving with the house valve closed, low pressure</td>
              <td data-label="Repair">Digging at the leak and repairing or replacing the line from the meter to the house</td>
            </tr>
            <tr>
              <th scope="row">Toilet or fixture</th>
              <td data-label="Signs">Toilet refills on its own, drip under a sink, food-coloring test fails</td>
              <td data-label="Repair">Replacing a flapper, fill valve, supply line or shutoff valve</td>
            </tr>
            <tr>
              <th scope="row">Water heater</th>
              <td data-label="Signs">Water on the floor around the tank</td>
              <td data-label="Repair">A valve or fitting repair, or a new tank; see <a href="/services/water-heater-repair-installation/">water heater repair and installation</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <aside class="ld-clay reveal-right" aria-label="Clay soil and yard leaks">
        <?php icon('layers', 24); ?>
        <b>Why yard leaks show up as puddles here</b>
        <p>Much of central Oklahoma sits on clay. The USDA's Seminole soil series, mapped in this part of the state, is clayey with slow permeability, so water from a broken yard line has nowhere to soak away.</p>
        <p>Instead it rises: a spongy patch, a puddle that never dries, or grass that stays green through August. Those are good clues to where the line has broken.</p>
      </aside>
    </div>
  </div>
</section>

<!-- ============================================================ PROCESS -->
<section class="section ld-process" id="process" aria-labelledby="process-title">
  <div class="container">
    <div class="ld-process__grid">
      <div class="section-title reveal-right">
        <span class="eyebrow-label">Find, then fix</span>
        <h2 id="process-title">How does Ledco Plumbing find and repair a leak?</h2>
        <p class="answer-block">Ledco Plumbing LLC finds a leak by working from the outside in, then opens only what is needed to reach the pipe. The plumber confirms the leak at the meter, narrows it to inside or outside the house, and pins down the spot. You approve the repair price before a wall is opened or the ground is dug.</p>
        <p>Not every leak is a pipe. When the trail ends at a toilet or the water heater, the fix is a part, not a hole in the wall. When it ends at a drain or the sewer, see <a href="/services/sewer-line-repair/">sewer line repair</a>. Everything else Ledco does is on the <a href="/services/">services page</a>.</p>
      </div>
      <ol class="timeline reveal-left">
        <li><b>Confirm it at the meter</b><span>The same test described above, done with the plumber on site, confirms water is being lost and roughly how fast.</span></li>
        <li><b>Inside or outside?</b><span>Closing the main valve at the house splits the system in two, so the search starts in the right half.</span></li>
        <li><b>Pin down the spot</b><span>The plumber narrows the leak to one run of pipe before anything is cut, so you are not left with a row of holes.</span></li>
        <li><b>Repair and re-test</b><span>Once you approve the price, the damaged pipe is repaired or replaced and the meter is read again to confirm it has stopped moving.</span></li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ WHY LEDCO -->
<section class="section edge-curve-top ld-why" id="why" aria-labelledby="why-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Why Ledco Plumbing</span>
      <h2 id="why-title">Why call Ledco Plumbing about a leak in <span class="text-accent">Seminole</span>?</h2>
      <p class="answer-block">Ledco Plumbing LLC handles leaks, water heaters, drains and sewer lines, so the search does not stop at the edge of one trade. The company is based at 316 E Oak Ave in Seminole, you see the repair price before anything is opened, and calls are taken every day of the week.</p>
    </div>
    <ul class="ld-why__list reveal-up">
      <li><?php icon('search', 22); ?><b>The whole trail</b><span>Supply lines, fixtures, the water heater and the sewer are all Ledco work.</span></li>
      <li><?php icon('clipboard-list', 22); ?><b>Price before opening</b><span>No wall is cut or yard dug until you approve the estimate.</span></li>
      <li><?php icon('calendar', 22); ?><b>Seven days a week</b><span>Found a wet ceiling on Sunday? Call that day.</span></li>
      <li><?php icon('users', 22); ?><b>Owner-run</b><span>Ledco Plumbing is owned by Mickey Ledbetter.</span></li>
    </ul>
  </div>
</section>

<!-- ============================================================ REVIEWS (Page One feed; renders only when real reviews exist) -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$ldReviews = p1_google_reviews($slug, ['heading' => 'What do Seminole customers say about Ledco Plumbing on Google?', 'limit' => 6]);
if ($ldReviews !== ''): ?>
<section class="section ld-reviews" aria-label="Google reviews"><div class="container"><?php echo $ldReviews; ?></div></section>
<?php endif; ?>

<!-- ============================================================ FAQ -->
<section class="section ld-faq" id="faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">What should you do if a pipe <span class="text-accent">bursts</span> in Seminole?</h2>
      <p class="answer-block">If a pipe bursts, close the main water shutoff valve first, then call Ledco Plumbing at <?php echo esc($ldPhone); ?>. The valve is usually where the water line enters the house or inside the meter box near the street. Closing it stops the flow while you wait; the question below covers when the office takes those calls.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($faqs as $ldFaq): ?>
      <details class="faq" open>
        <summary><?php echo esc($ldFaq['q']); ?></summary>
        <p><?php echo esc($ldFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
</article>

<!-- ============================================================ OTHER SERVICES -->
<section class="section ld-more" aria-label="Other plumbing services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What else can <span class="text-accent">Ledco Plumbing</span> fix while it is there?</h2>
      <p class="answer-block">Besides finding and repairing leaks, Ledco Plumbing LLC repairs sewer lines, handles commercial plumbing, clears drains and repairs or installs water heaters in Seminole and Wewoka. The three below each have their own page with the warning signs and how the work is done.</p>
    </div>
    <div class="services-grid">
<?php foreach (p1_other_services($svcSlug) as $ldIdx => $ldOther) p1_render_service_card($ldOther, $ldIdx + 1, 'reveal-up'); ?>
    </div>
    <p class="services-foot reveal-up"><a href="/services/">See all five Ledco Plumbing services &rarr;</a></p>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top ld-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Need that leak found and fixed?</h2>
      <p>Call Ledco Plumbing at <?php echo esc($ldPhone); ?> or request an estimate online. If water is spraying or pooling right now, close the main valve and call.</p>
      <p class="ld-cta__links"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">See Ledco Plumbing on Google Maps</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($ldPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
