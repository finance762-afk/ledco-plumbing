<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * services/drain-cleaning/index.php — Drain Cleaning (Phase 4, premium editorial service page, minimal-tech).
 *
 * Section script: interior type hero + form → warning signs (pull-quote + bento) → what's included
 * (asymmetric, hours stat) → drain-by-drain table (signature) → 4-step visit timeline → why Ledco
 * → reviews (feed-gated) → FAQ → other services → closing CTA.
 *
 * Claims: every business fact traces to build-plan.json / config.php (owner, office, hours, service list,
 * "price before work starts" as stated on the homepage). Prices, equipment (camera / jetter), response
 * times and job photos are NOT in intake: left out and listed in /content-confirmations.json.
 * Drain causes and prevention habits in the table are general plumbing knowledge, not business claims.
 */
$svcSlug = 'drain-cleaning';
$svc = null;
foreach ($services as $svcItem) { if ($svcItem['slug'] === $svcSlug) { $svc = $svcItem; break; } }

$pageTitle       = 'Drain Cleaning in Seminole, OK | Ledco Plumbing LLC';
$pageDescription = 'Drain cleaning in Seminole, OK from Ledco Plumbing LLC: kitchen, bath, laundry and main line clogs cleared for homes and businesses. Call (405) 257-3096.';
$canonicalUrl    = $siteUrl . '/services/drain-cleaning/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'services/drain-cleaning';
$pageType        = 'service';
$serviceSlug     = $svcSlug;

$dcPhone     = formatPhone($phone);
$dcPhoneHref = phoneHref($phone);

// FAQ — research_brief questions only (emergency + cost), answered without unconfirmed claims
$faqs = [
    [
        'q' => 'Do you offer emergency plumbing service in Seminole?',
        'a' => 'Ledco Plumbing LLC takes calls seven days a week from 7 AM to 5 PM, including drains backing up into the house. When sewage or dirty water is coming up, stop using water anywhere in the house and call (405) 257-3096 rather than sending the form, so the office hears about it right away.',
    ],
    [
        'q' => 'How much does drain cleaning cost?',
        'a' => 'The cost of clearing a drain depends on which drain is blocked, how far down the line the clog sits and how easy the access point is to reach. A kitchen sink trap is a different job from a main line. Ledco Plumbing gives you the price before any work starts.',
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
   services/drain-cleaning — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.dc-page h1, .dc-page h2, .dc-page h3, .dc-table tbody th { text-wrap: balance; }
.dc-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, pipe-run line motif on the right (C1 layered) ---- */
.dc-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 100%); }
.dc-hero::before {
  content: "";
  position: absolute;
  inset: 0 0 0 52%;
  z-index: -1;
  pointer-events: none;
  background:
    linear-gradient(90deg, transparent calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% + 1px), transparent calc(50% + 1px)),
    radial-gradient(closest-side at 70% 40%, color-mix(in srgb, var(--color-accent) 28%, transparent), transparent 75%);
}
.dc-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background-image: repeating-linear-gradient(0deg, color-mix(in srgb, var(--color-white) 4%, transparent) 0 1px, transparent 1px var(--space-2xl));
  -webkit-mask-image: linear-gradient(100deg, transparent 40%, var(--color-black) 90%);
  mask-image: linear-gradient(100deg, transparent 40%, var(--color-black) 90%);
}
.dc-hero .grain { opacity: .3; }
.dc-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.dc-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.dc-hero .breadcrumb a:hover { color: var(--color-white); }
.dc-hero .breadcrumb [aria-current] { color: var(--color-white); }
.dc-hero .hero-title { max-width: 22ch; }
.dc-hero .hero-answer { max-width: 36rem; }
.dc-hero .hero-form-card { border-top: 3px solid var(--color-accent); }
.dc-hero .hero-form .consent a { color: var(--color-primary); }
.dc-hero .link-call { color: var(--color-white); }
@media (max-width: 900px) {
  .dc-hero::before { inset: 0 0 0 60%; background: radial-gradient(closest-side at 70% 40%, color-mix(in srgb, var(--color-accent) 28%, transparent), transparent 75%); }
}
@media (max-width: 560px) {
  .dc-hero .hero-answer { font-size: var(--fs-body); }
  .dc-hero .hero-chips li { font-size: var(--font-size-xs); }
}

/* ---- Warning signs: pull-quote column + 2x2 bento ---- */
.dc-signs { background: var(--color-paper); }
.dc-signs__layout { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.6fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.dc-signs__intro { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.dc-signs .pull-quote { font-style: italic; font-size: clamp(1.35rem, 1rem + 1.4vw, 2rem); margin: var(--space-sm) 0 0; }
.dc-bento { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); }
.dc-bento .bento-item { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); transition: transform var(--transition), box-shadow var(--transition); }
.dc-bento .bento-item:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow); }
.dc-bento .bento-item:nth-child(1) { background: var(--color-card-tint-1); }
.dc-bento .bento-item:nth-child(2) { background: var(--color-card-tint-2); }
.dc-bento .bento-item:nth-child(3) { background: var(--color-card-tint-3); }
.dc-bento .bento-item:nth-child(4) { background: var(--color-dark); color: var(--color-white); border-color: transparent; }
.dc-bento .bento-item:nth-child(4) h3 { color: var(--color-white); }
.dc-bento .bento-item:nth-child(4) p { color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.dc-bento .bento-item:nth-child(4) a { color: var(--color-accent-bright); }
.dc-bento .bento-item:nth-child(4) .dc-bento__num { color: var(--color-accent-bright); }
.dc-bento h3 { margin: 0; font-size: var(--fs-h3); }
.dc-bento p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.dc-bento__num { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
@media (max-width: 1000px) {
  .dc-signs__layout { grid-template-columns: 1fr; }
  .dc-signs__intro { position: static; }
}
@media (max-width: 600px) { .dc-bento { grid-template-columns: 1fr; } }

/* ---- What's included: asymmetric article + hours stat card ---- */
.dc-scope { background: var(--color-surface); }
.dc-scope__grid { display: grid; grid-template-columns: minmax(0, 1.55fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.dc-scope__body { display: grid; gap: var(--space-md); }
.dc-scope__body > p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.dc-scope__body a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.dc-stat {
  position: relative;
  margin-top: var(--space-3xl);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-primary-deep) 130%);
  color: var(--color-white);
  box-shadow: var(--shadow-lg);
  overflow: hidden;
  isolation: isolate;
}
.dc-stat::after {
  content: "";
  position: absolute;
  inset: auto calc(-1 * var(--space-2xl)) calc(-1 * var(--space-2xl)) auto;
  width: 70%;
  aspect-ratio: 1;
  border-radius: var(--radius-full);
  border: var(--space-2) solid color-mix(in srgb, var(--color-accent) 30%, transparent);
  z-index: -1;
}
.dc-stat .big-number { color: var(--color-accent-bright); font-size: clamp(3.5rem, 2.5rem + 3vw, 5.5rem); }
.dc-stat .big-number small { font-size: .35em; letter-spacing: .14em; text-transform: uppercase; margin-left: var(--space-2); color: var(--color-white); }
.dc-stat p { margin: var(--space-sm) 0 0; color: color-mix(in srgb, var(--color-white) 84%, transparent); font-size: var(--fs-small); }
@media (max-width: 900px) {
  .dc-scope__grid { grid-template-columns: 1fr; }
  .dc-stat { margin-top: 0; }
}

/* ---- Drain-by-drain table (signature) ---- */
.dc-drains { background: var(--color-paper-2); }
.dc-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); box-shadow: var(--shadow); }
.dc-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); min-width: 0; }
.dc-table caption { text-align: left; padding: var(--space-md) var(--space-lg) 0; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.dc-table thead th { text-align: left; padding: var(--space-md) var(--space-lg); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); border-bottom: 2px solid var(--color-ink); }
.dc-table tbody th, .dc-table tbody td { padding: var(--space-md) var(--space-lg); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.dc-table tbody tr:last-child th, .dc-table tbody tr:last-child td { border-bottom: 0; }
.dc-table tbody th { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); white-space: nowrap; }
.dc-table tbody th svg { color: var(--color-accent-dark); vertical-align: -.15em; margin-right: var(--space-2); }
.dc-table td { color: var(--color-ink-2); }
.dc-table tbody tr { transition: background-color var(--transition); }
.dc-table tbody tr:hover { background: var(--color-paper); }
.dc-table tr.dc-table__main { background: var(--color-card-tint-3); }
.dc-table a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 760px) {
  .dc-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .dc-table, .dc-table tbody, .dc-table tr, .dc-table th, .dc-table td { display: block; width: 100%; }
  .dc-table tbody tr { padding: var(--space-md) var(--space-lg); border-bottom: 1px solid var(--color-line); }
  .dc-table tbody th, .dc-table tbody td { padding: var(--space-1) 0; border: 0; white-space: normal; }
  .dc-table td[data-label]::before { content: attr(data-label) ": "; font-weight: 700; color: var(--color-ink); }
}

/* ---- Visit timeline ---- */
.dc-process { background: var(--color-surface); }
.dc-process__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.3fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.dc-process .timeline { margin: 0; gap: var(--space-xl); }
.dc-process .timeline > li { display: grid; gap: var(--space-1); padding-left: var(--space-sm); }
.dc-process .timeline > li::before { box-shadow: 0 0 0 var(--space-1) var(--color-card-tint-3); }
.dc-process .timeline b { font-family: var(--font-heading); font-size: var(--fs-h3); color: var(--color-ink); }
.dc-process .timeline span { color: var(--color-ink-2); font-size: var(--fs-small); max-width: 52ch; }
@media (max-width: 900px) { .dc-process__grid { grid-template-columns: 1fr; } }

/* ---- Why Ledco: dark band, slanted top, 4-up reasons ---- */
.dc-why .container { display: grid; gap: var(--space-xl); }
.dc-why .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.dc-why__list { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.dc-why__list li { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); background: color-mix(in srgb, var(--color-white) 4%, transparent); }
.dc-why__list svg { color: var(--color-accent-bright); }
.dc-why__list b { font-family: var(--font-heading); color: var(--color-white); }
.dc-why__list span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
@media (max-width: 1000px) { .dc-why__list { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .dc-why__list { grid-template-columns: 1fr; } }

/* ---- FAQ ---- */
.dc-faq { background: var(--color-paper); }
.dc-faq .faq[open] { border-top-color: var(--color-accent); }
.dc-faq .faq summary:hover { color: var(--color-accent-dark); }

/* ---- Other services ---- */
.dc-more { background: var(--color-surface); }
.dc-more .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.dc-more .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.dc-more .service-card__icon { margin-top: 0; width: var(--space-12); height: var(--space-12); color: var(--color-accent-dark); border: 1px solid var(--color-line); }
.dc-more .services-foot { margin-top: var(--space-xl); }
.dc-more .services-foot a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 900px) { .dc-more .services-grid { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.dc-cta .container { align-items: center; }
.dc-cta .dc-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.dc-cta .dc-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="dc-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type dc-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/services/">Services</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Drain Cleaning</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Seminole, OK &middot; Drain cleaning</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Drain cleaning</span> in Seminole, OK</h1>
        <p class="hero-answer">Ledco Plumbing LLC clears clogged and slow drains in Seminole and Wewoka homes and businesses, from a single bathroom sink to a main line that pushes water back up into the tub. Call <?php echo esc($dcPhone); ?> any day of the week, or send the form for an estimate.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($dcPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($dcPhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('droplets', 16); ?> Sinks, tubs, toilets &amp; floor drains</li>
          <li><?php icon('waves', 16); ?> Main line backups</li>
          <li><?php icon('map-pin', 16); ?> Seminole &amp; Wewoka</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a drain cleaning estimate?</h2>
        <p class="hero-form-tagline">Tell us which drains are slow and Ledco Plumbing will call you back.</p>
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

<article class="dc-article">
<!-- ============================================================ WARNING SIGNS -->
<section class="section dc-signs" id="signs" aria-labelledby="signs-title">
  <div class="container-wide">
    <div class="dc-signs__layout">
      <div class="dc-signs__intro reveal-left">
        <span class="eyebrow-label">Warning signs</span>
        <h2 id="signs-title">How do you know a drain needs more than a <span class="text-accent">plunger</span>?</h2>
        <p class="answer-block">A drain needs professional cleaning when it clogs again within days of plunging, when water rises in a second fixture, or when the toilet gurgles after another drain runs. Those signs mean the blockage sits deeper in the pipe than a plunger or a bottle of gel can reach.</p>
        <p class="pull-quote">One slow drain is a fixture problem. Two slow drains at once is a line problem.</p>
      </div>
      <div class="dc-bento reveal-right">
        <div class="bento-item">
          <span class="dc-bento__num">Sign 01</span>
          <h3>It comes back in a week</h3>
          <p>Plunging punches a hole through the clog but leaves the grease and hair stuck to the pipe wall, so the opening narrows again with every use.</p>
        </div>
        <div class="bento-item">
          <span class="dc-bento__num">Sign 02</span>
          <h3>Water shows up in another fixture</h3>
          <p>The tub bubbles while the washing machine drains, or the shower pan fills when the toilet flushes. Those fixtures share a branch line, and that line is blocked.</p>
        </div>
        <div class="bento-item">
          <span class="dc-bento__num">Sign 03</span>
          <h3>Gurgling and a sewer smell</h3>
          <p>A partial clog pulls air through the water seal in the trap. That is the gurgle you hear, and the same gap lets sewer gas into the room.</p>
        </div>
        <div class="bento-item">
          <span class="dc-bento__num">Sign 04</span>
          <h3>The lowest drain backs up first</h3>
          <p>Dirty water rising in a floor drain or downstairs shower points past the house to the main line. Stop running water and read about <a href="/services/sewer-line-repair/">sewer line repair in Seminole</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ WHAT'S INCLUDED -->
<section class="section edge-curve-top dc-scope" id="included" aria-labelledby="included-title">
  <div class="container">
    <div class="dc-scope__grid">
      <div class="dc-scope__body reveal-up">
        <span class="eyebrow-label">What's included</span>
        <h2 id="included-title">What does drain cleaning from <span class="text-accent">Ledco Plumbing</span> cover?</h2>
        <p class="answer-block">Drain cleaning from Ledco Plumbing LLC covers every drain in the building, plus the main line they all empty into. That means kitchen and bathroom sinks, tubs, showers, toilets, laundry standpipes and floor drains. The plumber finds which drain or line is blocked, clears it, then runs water to show it flows.</p>
        <p>Kitchen sinks in Seminole homes clog for one main reason: cooking grease. It goes down warm and liquid, cools a few feet into the pipe and hardens on the wall, and coffee grounds, rice and food scraps stick to it. Bathroom drains collect hair bound together with soap. Each of those builds slowly, which is why a drain that has been "a little slow" for months finally stops on a busy morning.</p>
        <p>In older Seminole houses, the drain pipe under the floor is often cast iron. As it ages its inside wall turns rough with rust and scale, and that rough surface catches grease and hair far faster than smooth plastic pipe does. Homes like that tend to see the same kitchen line clog again and again until the buildup along the whole run is cleared, not just the plug at the trap.</p>
        <p>Sometimes clearing a drain turns up something bigger: tree roots, a cracked pipe, or a sewer line that has sagged and holds water. Ledco Plumbing also does <a href="/services/sewer-line-repair/">sewer line repair</a> and <a href="/services/leak-detection-repair/">leak detection and repair</a>, so the company that found the problem can price the fix. All five are listed on the <a href="/services/">Ledco Plumbing services page</a>.</p>
      </div>
      <aside class="dc-stat reveal-right" aria-label="Ledco Plumbing hours">
        <span class="big-number">7<small>days</small></span>
        <p>Ledco Plumbing takes drain calls Monday through Sunday, 7 AM to 5 PM, so a clog on a Saturday morning does not have to wait until Monday.</p>
      </aside>
    </div>
  </div>
</section>

<!-- ============================================================ DRAIN TABLE (signature) -->
<section class="section dc-drains" id="drains" aria-labelledby="drains-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Drain by drain</span>
      <h2 id="drains-title">What usually clogs each <span class="text-accent">drain</span> in a house?</h2>
      <p class="answer-block">The drain that clogs usually tells you what is inside it. Kitchen sinks fill with grease and food, bathroom drains with hair and soap, the washer standpipe with lint, and the main line with wipes or roots. The table matches each drain to its usual cause and one habit that keeps it running.</p>
    </div>
    <div class="dc-table-wrap reveal-up">
      <table class="dc-table">
        <caption>Common household drain clogs, their causes and how to prevent them</caption>
        <thead>
          <tr>
            <th scope="col">Drain</th>
            <th scope="col">Usual cause</th>
            <th scope="col">Habit that helps</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><?php icon('flame', 16); ?>Kitchen sink</th>
            <td data-label="Cause">Cooking grease that hardens in the pipe, plus coffee grounds, rice and food scraps</td>
            <td data-label="Habit">Wipe greasy pans into the trash before they go in the sink</td>
          </tr>
          <tr>
            <th scope="row"><?php icon('droplets', 16); ?>Bathroom sink</th>
            <td data-label="Cause">Hair, toothpaste and soap scum caught on the stopper</td>
            <td data-label="Habit">Pull and rinse the stopper every few weeks</td>
          </tr>
          <tr>
            <th scope="row"><?php icon('waves', 16); ?>Tub or shower</th>
            <td data-label="Cause">Hair matted together with soap</td>
            <td data-label="Habit">A hair catcher over the drain; skip chemical cleaners in standing water</td>
          </tr>
          <tr>
            <th scope="row"><?php icon('wrench', 16); ?>Toilet</th>
            <td data-label="Cause">Wipes (including "flushable" ones), paper towels, too much paper at once</td>
            <td data-label="Habit">Flush toilet paper only</td>
          </tr>
          <tr>
            <th scope="row"><?php icon('wind', 16); ?>Laundry standpipe</th>
            <td data-label="Cause">Lint and fabric fibers from the washer</td>
            <td data-label="Habit">A lint trap on the end of the washer drain hose</td>
          </tr>
          <tr class="dc-table__main">
            <th scope="row"><?php icon('house', 16); ?>Main line</th>
            <td data-label="Cause">Tree roots, wipes, grease from every drain, or a sagging section of pipe</td>
            <td data-label="Habit">Stop running water and call; see <a href="/services/sewer-line-repair/">sewer line repair</a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ============================================================ PROCESS -->
<section class="section dc-process" id="process" aria-labelledby="process-title">
  <div class="container">
    <div class="dc-process__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">The visit</span>
        <h2 id="process-title">How does a drain cleaning visit work, step by step?</h2>
        <p class="answer-block">A drain cleaning visit with Ledco Plumbing follows four steps, and no drain is opened before you agree to the price. You describe which drains are acting up, the plumber finds where the blockage is, you approve the estimate, and the line is cleared and tested with running water.</p>
      </div>
      <ol class="timeline reveal-right">
        <li><b>Tell us which drains are slow</b><span>Call <?php echo esc($dcPhone); ?> or use the form. Say which fixtures are affected and whether more than one backs up at the same time. That one detail tells the plumber whether to expect a branch clog or a main line problem.</span></li>
        <li><b>Find where the clog is</b><span>Water is run at different fixtures to see which ones share the blockage, then the plumber picks the closest way in: the fixture trap or a cleanout on the line.</span></li>
        <li><b>Approve the estimate</b><span>You get the price before any work starts, and you decide whether to go ahead.</span></li>
        <li><b>Clear it and run the water</b><span>Once the line is open, each affected fixture is run at full flow so you can watch it drain before the plumber leaves.</span></li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ WHY LEDCO -->
<section class="section on-dark texture-grain slant-top dc-why" id="why" aria-labelledby="why-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Why Ledco Plumbing</span>
      <h2 id="why-title">Why call Ledco Plumbing for a clogged drain in <span class="text-accent">Seminole</span>?</h2>
      <p class="answer-block">Ledco Plumbing LLC is a Seminole company owned by Mickey Ledbetter, with its office on E Oak Ave and drain calls taken seven days a week. You see the price before work begins, and if a clog turns out to be a broken sewer pipe, the same company repairs that too.</p>
    </div>
    <ul class="dc-why__list reveal-up">
      <li><?php icon('map-pin', 22); ?><b>Office in town</b><span>316 E Oak Ave, Seminole. Wewoka is a short drive east.</span></li>
      <li><?php icon('calendar', 22); ?><b>Weekend calls</b><span>Saturday and Sunday hours match the weekdays.</span></li>
      <li><?php icon('clipboard-list', 22); ?><b>Price first</b><span>You approve the estimate before a drain is opened.</span></li>
      <li><?php icon('wrench', 22); ?><b>Clog or broken pipe</b><span>Drains, sewer lines and leaks are all Ledco services.</span></li>
    </ul>
  </div>
</section>

<!-- ============================================================ REVIEWS (Page One feed; renders only when real reviews exist) -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$dcReviews = p1_google_reviews($slug, ['heading' => 'What do Seminole customers say about Ledco Plumbing on Google?', 'limit' => 6]);
if ($dcReviews !== ''): ?>
<section class="section dc-reviews" aria-label="Google reviews"><div class="container"><?php echo $dcReviews; ?></div></section>
<?php endif; ?>

<!-- ============================================================ FAQ -->
<section class="section dc-faq" id="faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">What do Seminole customers ask about <span class="text-accent">drain cleaning</span>?</h2>
      <p class="answer-block">Seminole customers usually ask two things about drain cleaning: whether a plumber will come when a drain backs up, and what clearing a clog costs. Ledco Plumbing LLC answers both below. For anything else, call the office at <?php echo esc($dcPhone); ?>.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($faqs as $dcFaqIdx => $dcFaq): ?>
      <details class="faq"<?php echo $dcFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($dcFaq['q']); ?></summary>
        <p><?php echo esc($dcFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
</article>

<!-- ============================================================ OTHER SERVICES -->
<section class="section dc-more" aria-label="Other plumbing services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which other <span class="text-accent">plumbing problems</span> can Ledco Plumbing fix?</h2>
      <p class="answer-block">Besides drain cleaning, Ledco Plumbing LLC repairs and installs water heaters, finds and fixes hidden leaks, repairs sewer lines and handles commercial plumbing in Seminole and Wewoka. These three are the services most often needed alongside a stubborn clog or a backup.</p>
    </div>
    <div class="services-grid">
<?php foreach (p1_other_services($svcSlug) as $dcIdx => $dcOther) p1_render_service_card($dcOther, $dcIdx + 1, 'reveal-up'); ?>
    </div>
    <p class="services-foot reveal-up"><a href="/services/">See all five Ledco Plumbing services &rarr;</a></p>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top dc-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Ready to get that drain running again?</h2>
      <p>Call Ledco Plumbing at <?php echo esc($dcPhone); ?> or request an estimate online. If water is backing up right now, call instead of using the form.</p>
      <p class="dc-cta__links"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">See Ledco Plumbing on Google Maps</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($dcPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
