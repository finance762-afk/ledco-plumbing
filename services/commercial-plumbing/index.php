<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * services/commercial-plumbing/index.php — Commercial Plumbing (Phase 4, premium editorial service page, minimal-tech).
 *
 * Section script: interior type hero + form → costly failures (pull-quote rail + editorial list) → service-by-service
 * table for businesses (signature) → weekend-hours band → what to have ready (checklist) → commercial call timeline
 * → why Ledco → reviews (feed-gated) → FAQ → other services → CTA.
 *
 * Claims: business facts trace to build-plan.json / config.php (five services, hours Mon–Sun 7–5, office, owner,
 * service areas, "price before work"). Which kinds of businesses Ledco serves (restaurants, rentals, churches,
 * schools, oilfield), after-hours work, grease-trap service, backflow testing, maintenance contracts and prices
 * are NOT in intake — left out and listed in /content-confirmations.json.
 */
$svcSlug = 'commercial-plumbing';
$svc = null;
foreach ($services as $svcItem) { if ($svcItem['slug'] === $svcSlug) { $svc = $svcItem; break; } }

$pageTitle       = 'Commercial Plumbing Seminole OK | Ledco Plumbing LLC';
$pageDescription = 'Commercial plumbing in Seminole, OK. Ledco Plumbing LLC repairs restrooms, drains, water heaters, leaks and sewer lines for businesses. Call (405) 257-3096.';
$canonicalUrl    = $siteUrl . '/services/commercial-plumbing/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'services/commercial-plumbing';
$pageType        = 'service';
$serviceSlug     = $svcSlug;

$cpPhone     = formatPhone($phone);
$cpPhoneHref = phoneHref($phone);

// FAQ — research_brief question (service area), answered for business owners from intake only
$faqs = [
    [
        'q' => 'Which areas around Seminole do you serve?',
        'a' => 'Ledco Plumbing LLC serves businesses in Seminole and Wewoka from its office at 316 E Oak Ave in Seminole. If your building is elsewhere in Seminole County, call (405) 257-3096 or send the form with the address, and the office will confirm whether a plumber can reach you.',
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
   services/commercial-plumbing — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.cp-page h1, .cp-page h2, .cp-page h3, .cp-table tbody th { text-wrap: balance; }
.cp-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, storefront-grid blueprint lines (C1 layered) ---- */
.cp-hero { background: linear-gradient(140deg, var(--color-dark) 0%, var(--color-dark-alt) 50%, var(--color-primary-deep) 100%); }
.cp-hero::before {
  content: "";
  position: absolute;
  inset: 0 0 0 45%;
  z-index: -1;
  pointer-events: none;
  background-image:
    linear-gradient(color-mix(in srgb, var(--color-white) 6%, transparent) 1px, transparent 1px),
    linear-gradient(90deg, color-mix(in srgb, var(--color-white) 6%, transparent) 1px, transparent 1px),
    linear-gradient(color-mix(in srgb, var(--color-white) 3%, transparent) 1px, transparent 1px),
    linear-gradient(90deg, color-mix(in srgb, var(--color-white) 3%, transparent) 1px, transparent 1px);
  background-size: var(--space-4xl) var(--space-4xl), var(--space-4xl) var(--space-4xl), var(--space-6) var(--space-6), var(--space-6) var(--space-6);
  -webkit-mask-image: linear-gradient(90deg, transparent, var(--color-black) 60%);
  mask-image: linear-gradient(90deg, transparent, var(--color-black) 60%);
}
.cp-hero::after {
  content: "";
  position: absolute;
  inset: auto 5% -60% auto;
  width: 55%;
  height: 120%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 72%);
}
.cp-hero .grain { opacity: .3; }
.cp-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.cp-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.cp-hero .breadcrumb a:hover, .cp-hero .breadcrumb [aria-current] { color: var(--color-white); }
.cp-hero .hero-title { max-width: 22ch; }
.cp-hero .hero-answer { max-width: 36rem; }
.cp-hero .hero-form-card { border-top: 3px solid var(--color-accent); }
.cp-hero .hero-form .consent a { color: var(--color-primary); }
.cp-hero .link-call { color: var(--color-white); }
@media (max-width: 560px) { .cp-hero .hero-answer { font-size: var(--fs-body); } }

/* ---- Costly failures: sticky pull-quote rail + editorial numbered list ---- */
.cp-cost { background: var(--color-paper); }
.cp-cost__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.35fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.cp-cost__rail { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.cp-cost .pull-quote { margin: var(--space-md) 0 0; padding-left: var(--space-lg); border-left: 3px solid var(--color-accent); font-style: italic; font-size: clamp(1.25rem, 1rem + 1vw, 1.75rem); }
.cp-list { margin: 0; padding: 0; list-style: none; display: grid; counter-reset: cpitem; }
.cp-list li { counter-increment: cpitem; display: grid; grid-template-columns: var(--space-16) 1fr; gap: var(--space-1) var(--space-md); padding: var(--space-lg) 0; border-bottom: 1px solid var(--color-line); }
.cp-list li:first-child { border-top: 2px solid var(--color-ink); }
.cp-list li::before { content: counter(cpitem, decimal-leading-zero); grid-row: span 2; font-family: var(--font-accent); font-size: var(--fs-h2); line-height: 1; color: var(--color-accent-dark); }
.cp-list h3 { margin: 0; font-size: var(--fs-h3); }
.cp-list p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); max-width: 58ch; }
.cp-list a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 900px) { .cp-cost__grid { grid-template-columns: 1fr; } .cp-cost__rail { position: static; } }

/* ---- Service-by-service table (signature) ---- */
.cp-map { background: var(--color-surface); }
.cp-table-wrap { border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-line); box-shadow: var(--shadow-lg); }
.cp-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); background: var(--color-surface); }
.cp-table caption { caption-side: bottom; text-align: left; padding: var(--space-sm) var(--space-lg) var(--space-md); font-size: var(--fs-small); color: var(--color-muted); background: var(--color-paper); }
.cp-table thead th { text-align: left; padding: var(--space-md) var(--space-lg); background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-primary-deep) 140%); color: var(--color-white); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; }
.cp-table tbody th, .cp-table tbody td { padding: var(--space-md) var(--space-lg); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.cp-table tbody th { width: 24%; }
.cp-table tbody th a { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); text-decoration-color: var(--color-accent); text-underline-offset: .25em; display: inline-flex; align-items: center; gap: var(--space-2); }
.cp-table tbody th a:hover { color: var(--color-accent-dark); }
.cp-table tbody th svg { color: var(--color-accent-dark); flex: 0 0 auto; }
.cp-table tbody th span { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); }
.cp-table td { color: var(--color-ink-2); }
.cp-table tbody tr:nth-child(odd) td { background: color-mix(in srgb, var(--color-paper) 55%, transparent); }
@media (max-width: 760px) {
  .cp-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .cp-table, .cp-table tbody, .cp-table tr, .cp-table th, .cp-table td { display: block; width: 100%; }
  .cp-table tbody tr { padding: var(--space-sm) 0; border-bottom: 1px solid var(--color-line); }
  .cp-table tbody th, .cp-table tbody td { border: 0; padding: var(--space-1) var(--space-lg); width: 100%; }
  .cp-table td[data-label]::before { content: attr(data-label) ": "; font-weight: 700; color: var(--color-ink); }
}

/* ---- Weekend band: dark, big day stamp ---- */
.cp-week .container { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: center; }
.cp-week .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.cp-days { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: var(--space-1); margin: 0; padding: 0; list-style: none; }
.cp-days li { display: grid; gap: var(--space-1); justify-items: center; padding: var(--space-md) 0; border-radius: var(--radius); background: color-mix(in srgb, var(--color-white) 6%, transparent); font-family: var(--font-accent); letter-spacing: .1em; text-transform: uppercase; color: var(--color-white); font-size: var(--fs-small); }
.cp-days li small { font-size: var(--fs-eyebrow); color: color-mix(in srgb, var(--color-white) 64%, transparent); letter-spacing: .04em; }
.cp-days li.is-weekend { background: var(--color-accent-dark); }
.cp-days li.is-weekend small { color: color-mix(in srgb, var(--color-white) 86%, transparent); }
.cp-week__note { margin: var(--space-sm) 0 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 72%, transparent); }
@media (max-width: 900px) { .cp-week .container { grid-template-columns: 1fr; } }
@media (max-width: 480px) { .cp-days li { padding: var(--space-sm) 0; font-size: var(--fs-eyebrow); } }

/* ---- What to have ready: checklist cards ---- */
.cp-ready { background: var(--color-paper-2); }
.cp-ready__list { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.cp-ready__list li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-1) var(--space-sm); align-items: start; padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); transition: transform var(--transition), box-shadow var(--transition); }
.cp-ready__list li:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow); }
.cp-ready__list li:nth-child(3n+1) { background: var(--color-card-tint-1); }
.cp-ready__list li:nth-child(3n+2) { background: var(--color-card-tint-2); }
.cp-ready__list li:nth-child(3n) { background: var(--color-card-tint-3); }
.cp-ready__list svg { grid-row: span 2; color: var(--color-accent-dark); margin-top: var(--space-1); }
.cp-ready__list b { font-family: var(--font-heading); color: var(--color-ink); }
.cp-ready__list span { font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) { .cp-ready__list { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 600px) { .cp-ready__list { grid-template-columns: 1fr; } }

/* ---- Commercial call timeline ---- */
.cp-process { background: var(--color-surface); }
.cp-process__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.3fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.cp-process .timeline { margin: 0; gap: var(--space-lg); }
.cp-process .timeline > li { display: grid; gap: var(--space-1); padding: var(--space-md) var(--space-lg); border-radius: var(--radius); background: var(--color-paper); margin-left: var(--space-sm); }
.cp-process .timeline > li::before { left: calc(-1.5rem - 7px - var(--space-sm)); top: var(--space-lg); }
.cp-process .timeline b { font-family: var(--font-heading); color: var(--color-ink); }
.cp-process .timeline span { color: var(--color-ink-2); font-size: var(--fs-small); }
@media (max-width: 900px) { .cp-process__grid { grid-template-columns: 1fr; } }

/* ---- Why Ledco ---- */
.cp-why { background: var(--color-paper); }
.cp-why__list { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; margin: var(--space-lg) 0 0; padding: 0; list-style: none; border: 1px solid var(--color-line); border-radius: var(--radius-lg); overflow: hidden; background: var(--color-surface); }
.cp-why__list li { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); }
.cp-why__list li + li { border-left: 1px solid var(--color-line); }
.cp-why__list svg { color: var(--color-accent-dark); }
.cp-why__list b { font-family: var(--font-heading); color: var(--color-ink); }
.cp-why__list span { font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) {
  .cp-why__list { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .cp-why__list li:nth-child(3) { border-left: 0; }
  .cp-why__list li:nth-child(n+3) { border-top: 1px solid var(--color-line); }
}
@media (max-width: 560px) {
  .cp-why__list { grid-template-columns: 1fr; }
  .cp-why__list li + li { border-left: 0; border-top: 1px solid var(--color-line); }
}

/* ---- FAQ ---- */
.cp-faq { background: var(--color-surface); }
.cp-faq .faq-grid { grid-template-columns: 1fr; max-width: var(--measure); }
.cp-faq .faq[open] { border-top-color: var(--color-accent); }

/* ---- Other services ---- */
.cp-more { background: var(--color-paper-2); }
.cp-more .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.cp-more .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.cp-more .service-card__icon { margin-top: 0; width: var(--space-12); height: var(--space-12); color: var(--color-accent-dark); border: 1px solid var(--color-line); }
.cp-more .services-foot { margin-top: var(--space-xl); }
.cp-more .services-foot a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 900px) { .cp-more .services-grid { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.cp-cta .cp-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.cp-cta .cp-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="cp-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type cp-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/services/">Services</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Commercial Plumbing</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Seminole, OK &middot; Commercial</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Commercial plumbing</span> in Seminole, OK</h1>
        <p class="hero-answer">Ledco Plumbing LLC handles plumbing repair for Seminole and Wewoka businesses: restrooms, kitchen and floor drains, water heaters, hidden leaks and sewer lines. The office takes calls seven days a week from 7 AM to 5 PM, so a weekend problem can be reported the day it happens.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($cpPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($cpPhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('building-2', 16); ?> Restrooms &amp; fixtures</li>
          <li><?php icon('wrench', 16); ?> Drains, heaters, sewer</li>
          <li><?php icon('calendar', 16); ?> Saturdays &amp; Sundays too</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a commercial plumbing estimate?</h2>
        <p class="hero-form-tagline">Tell us the business, the address and the problem. Ledco Plumbing will call you back.</p>
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

<article class="cp-article">
<!-- ============================================================ COSTLY FAILURES -->
<section class="section cp-cost" id="costly-failures" aria-labelledby="cost-title">
  <div class="container">
    <div class="cp-cost__grid">
      <div class="cp-cost__rail reveal-left">
        <span class="eyebrow-label">What it costs you</span>
        <h2 id="cost-title">Which plumbing problems cost a <span class="text-accent">business</span> the most?</h2>
        <p class="answer-block">The plumbing failures that cost a business most are the ones that close something. A restroom out of order, a kitchen drain backing up during service, no hot water at the handwashing sink, or a leak that reaches stock or ceiling tiles all stop work, and most of them give warning signs first.</p>
        <p class="pull-quote">A running toilet at home is an annoyance. In a business, it is a closed restroom and a sign on the door.</p>
      </div>
      <ol class="cp-list reveal-right">
        <li>
          <h3>A restroom out of order</h3>
          <p>A toilet that will not stop running, a clogged urinal or a leaking supply line can take a public restroom out of service. Running fixtures also add up fast on the water bill when they serve a whole day of customers.</p>
        </li>
        <li>
          <h3>A kitchen or floor drain backing up</h3>
          <p>Commercial kitchens send far more grease down their drains than a home does, and floor drains catch everything mopped toward them. A slow kitchen drain on Monday is a backup on Friday. See <a href="/services/drain-cleaning/">drain cleaning</a>.</p>
        </li>
        <li>
          <h3>No hot water at the sinks</h3>
          <p>Health inspectors check for hot water at handwashing sinks in any business that handles food, and staff and customers notice it everywhere else. A heater that runs out mid-shift is often sized too small or full of sediment.</p>
        </li>
        <li>
          <h3>A leak above the ceiling or under the floor</h3>
          <p>Water from a hidden line can soak stock, stain ceiling tiles and buckle flooring before anyone sees it. A water bill that jumps between months is often the first clue; see <a href="/services/leak-detection-repair/">leak detection and repair</a>.</p>
        </li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ SERVICE MAP (signature) -->
<section class="section edge-curve-top cp-map" id="services-for-business" aria-labelledby="map-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Service by service</span>
      <h2 id="map-title">How does each Ledco Plumbing service apply to a <span class="text-accent">commercial</span> building?</h2>
      <p class="answer-block">Commercial plumbing from Ledco Plumbing LLC covers restroom fixtures plus the business side of its four other services in Seminole and Wewoka. The table shows what each one handles in a commercial building, from a single faucet to the sewer line that serves the whole property, so you can tell the office what kind of call it is.</p>
    </div>
    <div class="cp-table-wrap reveal-up">
      <table class="cp-table">
        <caption>Ledco Plumbing services and the commercial problems each one covers. Every service links to its own page.</caption>
        <thead>
          <tr>
            <th scope="col">Service</th>
            <th scope="col">Commercial problems it covers</th>
            <th scope="col">Warning sign to report</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><span>Fixture repair</span></th>
            <td data-label="Covers">Toilets, urinals, faucets, supply lines and shutoff valves in public and staff restrooms</td>
            <td data-label="Warning sign">A fixture that runs, drips or will not flush fully</td>
          </tr>
          <tr>
            <th scope="row"><a href="/services/drain-cleaning/"><?php icon('droplets', 16); ?>Drain cleaning</a></th>
            <td data-label="Covers">Kitchen sinks, mop sinks, floor drains and restroom drains</td>
            <td data-label="Warning sign">Standing water in a floor drain or a sink that drains in minutes, not seconds</td>
          </tr>
          <tr>
            <th scope="row"><a href="/services/water-heater-repair-installation/"><?php icon('flame', 16); ?>Water heaters</a></th>
            <td data-label="Covers">Repair of heaters that run out or run cold, and replacement when a tank fails</td>
            <td data-label="Warning sign">Hot water running out before the end of the day</td>
          </tr>
          <tr>
            <th scope="row"><a href="/services/leak-detection-repair/"><?php icon('search', 16); ?>Leak detection</a></th>
            <td data-label="Covers">Hidden leaks in walls, ceilings, slabs and the service line from the meter</td>
            <td data-label="Warning sign">A higher water bill, stained ceiling tiles, a wet spot that keeps coming back</td>
          </tr>
          <tr>
            <th scope="row"><a href="/services/sewer-line-repair/"><?php icon('waves', 16); ?>Sewer line repair</a></th>
            <td data-label="Covers">The building's main sewer line: backups, roots, cracked or sagging pipe</td>
            <td data-label="Warning sign">Several drains slow at once, or sewage smell outside the building</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ============================================================ WEEKEND BAND -->
<section class="section on-dark texture-grain slant-top cp-week" id="hours" aria-labelledby="week-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-title reveal-left">
      <span class="eyebrow-label">Hours</span>
      <h2 id="week-title">Can a business reach Ledco Plumbing on a <span class="text-accent">weekend</span>?</h2>
      <p class="answer-block">Ledco Plumbing LLC takes calls from businesses on Saturdays and Sundays, 7 AM to 5 PM, the same hours as weekdays. For shops and offices that are busiest on weekends, or closed then and easier to work in, a problem can be called in the day it happens instead of waiting for Monday.</p>
    </div>
    <div class="reveal-right">
      <ul class="cp-days" aria-label="Ledco Plumbing office hours by day">
<?php foreach ($hours as $cpDay): ?>
        <li<?php echo in_array($cpDay['short'], ['Sat', 'Sun'], true) ? ' class="is-weekend"' : ''; ?>><?php echo esc($cpDay['short']); ?><small>7&ndash;5</small></li>
<?php endforeach; ?>
      </ul>
      <p class="cp-week__note">Office hours. For work outside them, ask when you call.</p>
    </div>
  </div>
</section>

<!-- ============================================================ WHAT TO HAVE READY -->
<section class="section cp-ready" id="before-you-call" aria-labelledby="ready-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Before you call</span>
      <h2 id="ready-title">What should a business have ready when it calls a plumber?</h2>
      <p class="answer-block">A business call goes fastest when you can give the address, who can let the plumber in, who approves the price, and exactly which fixtures are affected. Knowing where the main water shutoff and the water heater are saves time on site, especially in a building you lease.</p>
    </div>
    <ul class="cp-ready__list reveal-up">
      <li><?php icon('map-pin', 22); ?><b>Address and entrance</b><span>Which door to use, and whether the work is in a back room, kitchen or upstairs.</span></li>
      <li><?php icon('users', 22); ?><b>A contact on site</b><span>Someone with keys who can show the plumber the problem.</span></li>
      <li><?php icon('clipboard-list', 22); ?><b>Who approves the price</b><span>Owner, manager or landlord. Leased buildings often split plumbing between tenant and owner.</span></li>
      <li><?php icon('building-2', 22); ?><b>What is affected</b><span>One restroom or all of them; one sink or every drain on the floor.</span></li>
      <li><?php icon('wrench', 22); ?><b>The main shutoff</b><span>Where the building's water can be turned off, if you know.</span></li>
      <li><?php icon('clock', 22); ?><b>Your busy hours</b><span>When the work would disrupt customers least, within office hours.</span></li>
    </ul>
  </div>
</section>

<!-- ============================================================ PROCESS -->
<section class="section cp-process" id="process" aria-labelledby="process-title">
  <div class="container">
    <div class="cp-process__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">The call</span>
        <h2 id="process-title">How does a commercial plumbing call with Ledco Plumbing work?</h2>
        <p class="answer-block">A commercial call with Ledco Plumbing LLC follows the same order as a home job, with the business details added. You report the problem, a plumber checks it on site, the person who approves spending sees the estimate, and the repair is made and tested before the plumber leaves.</p>
        <p>The full list of Ledco services is on the <a href="/services/">Seminole plumbing services page</a>.</p>
      </div>
      <ol class="timeline reveal-right">
        <li><b>Report the problem</b><span>Call <?php echo esc($cpPhone); ?> or send the form with the business name, address and which fixtures are affected.</span></li>
        <li><b>On-site check</b><span>The plumber looks at the fixture, drain, heater or line with your contact on site.</span></li>
        <li><b>Estimate to the decision-maker</b><span>The price goes to whoever approves the work before any repair starts.</span></li>
        <li><b>Repair and test</b><span>The repair is made and the fixtures are run so you can reopen with confidence.</span></li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ WHY LEDCO -->
<section class="section edge-torn-top cp-why" id="why" aria-labelledby="why-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Why Ledco Plumbing</span>
      <h2 id="why-title">Why do <span class="text-accent">Seminole</span> businesses call Ledco Plumbing?</h2>
      <p class="answer-block">Seminole businesses call Ledco Plumbing LLC because one company covers drains, water heaters, leaks and the sewer line. The office is local on E Oak Ave, the phones are answered on weekends, and whoever approves the spending sees the price before the work begins.</p>
    </div>
    <ul class="cp-why__list reveal-up">
      <li><?php icon('layers', 22); ?><b>One plumber, five services</b><span>No separate calls for the drain, the heater and the sewer.</span></li>
      <li><?php icon('calendar', 22); ?><b>Weekend hours</b><span>Saturday and Sunday, the same as weekdays.</span></li>
      <li><?php icon('clipboard-list', 22); ?><b>Approved before work</b><span>The estimate goes to the person who signs off.</span></li>
      <li><?php icon('map-pin', 22); ?><b>Local office</b><span>Owned by Mickey Ledbetter and based in Seminole.</span></li>
    </ul>
  </div>
</section>

<!-- ============================================================ REVIEWS (Page One feed; renders only when real reviews exist) -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$cpReviews = p1_google_reviews($slug, ['heading' => 'What do Seminole customers say about Ledco Plumbing on Google?', 'limit' => 6]);
if ($cpReviews !== ''): ?>
<section class="section cp-reviews" aria-label="Google reviews"><div class="container"><?php echo $cpReviews; ?></div></section>
<?php endif; ?>

<!-- ============================================================ FAQ -->
<section class="section cp-faq" id="faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">Does Ledco Plumbing serve businesses outside <span class="text-accent">Seminole</span>?</h2>
      <p class="answer-block">Ledco Plumbing LLC serves businesses in Seminole and Wewoka. For a building elsewhere in Seminole County, the office will tell you over the phone whether a plumber can reach it. The answer below gives the details and the number to call, so you know before you send a request.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($faqs as $cpFaq): ?>
      <details class="faq" open>
        <summary><?php echo esc($cpFaq['q']); ?></summary>
        <p><?php echo esc($cpFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
</article>

<!-- ============================================================ OTHER SERVICES -->
<section class="section cp-more" aria-label="Other plumbing services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which <span class="text-accent">Ledco Plumbing</span> services do commercial buildings use most?</h2>
      <p class="answer-block">Commercial buildings in Seminole and Wewoka most often call Ledco Plumbing LLC for drain cleaning, water heater repair and installation, and leak detection and repair. Each one has its own page with the signs to watch for and how the work is done.</p>
    </div>
    <div class="services-grid">
<?php foreach (p1_other_services($svcSlug) as $cpIdx => $cpOther) p1_render_service_card($cpOther, $cpIdx + 1, 'reveal-up'); ?>
    </div>
    <p class="services-foot reveal-up"><a href="/services/">See all five Ledco Plumbing services &rarr;</a></p>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top cp-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Need a plumber for your business?</h2>
      <p>Call Ledco Plumbing at <?php echo esc($cpPhone); ?> or request an estimate online, seven days a week.</p>
      <p class="cp-cta__links"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">See Ledco Plumbing on Google Maps</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($cpPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
