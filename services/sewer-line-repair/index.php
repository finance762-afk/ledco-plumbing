<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * services/sewer-line-repair/index.php — Sewer Line Repair (Phase 4, premium editorial service page, minimal-tech).
 *
 * Section script: interior type hero + form → clog vs sewer contrast (signature split) → backup first steps
 * (dark band) → why older lines fail (pipe-material table + roots/clay) → which repair (table) → repair timeline
 * → why Ledco → reviews (feed-gated) → FAQ → other services → CTA.
 *
 * Local source: Seminole's late-1920s oil boom (homepage sources: okhistory.org entries SE012, GR020).
 * Pipe-material eras and failure modes are general plumbing knowledge. Whether Ledco works on septic lines,
 * uses camera inspection or trenchless methods, prices and permits are NOT in intake — left out and listed in
 * /content-confirmations.json.
 */
$svcSlug = 'sewer-line-repair';
$svc = null;
foreach ($services as $svcItem) { if ($svcItem['slug'] === $svcSlug) { $svc = $svcItem; break; } }

$pageTitle       = 'Sewer Line Repair Seminole OK | Ledco Plumbing';
$pageDescription = 'Sewer line repair in Seminole, OK. Ledco Plumbing fixes backed-up, cracked and root-filled sewer lines in Seminole and Wewoka. Call (405) 257-3096.';
$canonicalUrl    = $siteUrl . '/services/sewer-line-repair/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'services/sewer-line-repair';
$pageType        = 'service';
$serviceSlug     = $svcSlug;

$slPhone     = formatPhone($phone);
$slPhoneHref = phoneHref($phone);

// FAQ — research_brief question (emergency service: sewer backups), answered from intake only
$faqs = [
    [
        'q' => 'What are your hours?',
        'a' => 'Ledco Plumbing is open 7 AM to 5 PM, 7 days a week, and a sewer backup should be a phone call, not a form. Call (405) 257-3096, tell the office which drains are backing up and where your sewer cleanout is if you know, and keep everyone in the house from running water until the line is open.',
    ],
];

$pageSchema   = generateServicePageSchema($svc, $pageTitle, $pageDescription);
$schemaMarkup = $pageSchema;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-cards.php';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   services/sewer-line-repair — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.sl-page h1, .sl-page h2, .sl-page h3, .sl-table tbody th { text-wrap: balance; }
.sl-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, sloped "grade line" stripes underneath (C1 layered) ---- */
.sl-hero { background: linear-gradient(170deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 100%); }
.sl-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background-image: repeating-linear-gradient(-8deg, transparent 0 var(--space-3xl), color-mix(in srgb, var(--color-white) 5%, transparent) var(--space-3xl) calc(var(--space-3xl) + 1px));
  -webkit-mask-image: linear-gradient(180deg, transparent 20%, var(--color-black) 100%);
  mask-image: linear-gradient(180deg, transparent 20%, var(--color-black) 100%);
}
.sl-hero::after {
  content: "";
  position: absolute;
  inset: 10% -15% auto 55%;
  height: 100%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 24%, transparent), transparent 72%);
}
.sl-hero .grain { opacity: .3; }
.sl-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.sl-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.sl-hero .breadcrumb a:hover, .sl-hero .breadcrumb [aria-current] { color: var(--color-white); }
.sl-hero .hero-title { max-width: 20ch; }
.sl-hero .hero-answer { max-width: 36rem; }
.sl-hero .hero-form-card { border-top: 3px solid var(--color-accent); }
.sl-hero .hero-form .consent a { color: var(--color-primary); }
.sl-hero .link-call { color: var(--color-white); }
@media (max-width: 560px) { .sl-hero .hero-answer { font-size: var(--fs-body); } }

/* ---- Clog vs sewer (signature): split contrast panels ---- */
.sl-vs { background: var(--color-paper); }
.sl-vs .section-title { max-width: 68ch; }
.sl-vs__grid { display: grid; grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr); gap: var(--space-lg); align-items: stretch; }
.sl-vs__panel { display: grid; gap: var(--space-sm); align-content: start; padding: var(--space-xl); border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); }
.sl-vs__panel--sewer { background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-primary-deep) 140%); color: var(--color-white); border-color: transparent; box-shadow: var(--shadow-lg); }
.sl-vs__panel h3 { margin: 0; font-size: var(--fs-h3); display: flex; align-items: center; gap: var(--space-sm); }
.sl-vs__panel--sewer h3 { color: var(--color-white); }
.sl-vs__panel h3 svg { color: var(--color-accent-dark); }
.sl-vs__panel--sewer h3 svg { color: var(--color-accent-bright); }
.sl-vs__panel ul { margin: 0; padding: 0; list-style: none; display: grid; gap: var(--space-2); font-size: var(--fs-small); }
.sl-vs__panel li { padding-left: var(--space-lg); position: relative; color: var(--color-ink-2); }
.sl-vs__panel--sewer li { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.sl-vs__panel li::before { content: ""; position: absolute; left: 0; top: .55em; width: var(--space-2); height: var(--space-2); border-radius: var(--radius-full); background: var(--color-accent); }
.sl-vs__panel p { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.sl-vs__panel--sewer p { color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.sl-vs__panel a { color: var(--color-primary); font-weight: 600; }
.sl-vs__or { align-self: center; display: grid; place-items: center; width: var(--space-12); height: var(--space-12); border-radius: var(--radius-full); background: var(--color-accent-dark); color: var(--color-white); font-family: var(--font-accent); letter-spacing: .1em; text-transform: uppercase; font-size: var(--fs-small); }
.sl-vs .pull-quote { margin: var(--space-2xl) auto 0; text-align: center; max-width: 34ch; font-style: italic; font-size: clamp(1.3rem, 1rem + 1.2vw, 1.85rem); }
@media (max-width: 900px) {
  .sl-vs__grid { grid-template-columns: 1fr; }
  .sl-vs__or { justify-self: center; }
}

/* ---- Backup first steps: dark band, horizontal numbered ---- */
.sl-backup .container { display: grid; gap: var(--space-xl); }
.sl-backup .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.sl-backup__steps { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; counter-reset: slstep; }
.sl-backup__steps li { counter-increment: slstep; display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-top: 2px solid var(--color-accent-bright); background: color-mix(in srgb, var(--color-white) 4%, transparent); border-radius: 0 0 var(--radius) var(--radius); }
.sl-backup__steps li::before { content: "Step " counter(slstep); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.sl-backup__steps b { font-family: var(--font-heading); color: var(--color-white); }
.sl-backup__steps span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
@media (max-width: 1000px) { .sl-backup__steps { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .sl-backup__steps { grid-template-columns: 1fr; } }

/* ---- Why older lines fail: article + pipe-material table ---- */
.sl-age { background: var(--color-surface); }
.sl-age__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.sl-age__body { display: grid; gap: var(--space-md); }
.sl-age__body > p { margin: 0; color: var(--color-ink-2); max-width: var(--measure); }
.sl-age__body a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.sl-age .big-number { display: block; font-size: clamp(3.5rem, 2.5rem + 3vw, 5rem); color: var(--color-accent-dark); }
.sl-age__stat { display: grid; gap: var(--space-1); padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-card-tint-3); }
.sl-age__stat p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.sl-pipes { width: 100%; border-collapse: collapse; font-size: var(--fs-small); }
.sl-pipes caption { text-align: left; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); padding-bottom: var(--space-sm); }
.sl-pipes thead th { text-align: left; padding: var(--space-sm) var(--space-md); border-bottom: 2px solid var(--color-ink); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.sl-pipes tbody th, .sl-pipes tbody td { padding: var(--space-md); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.sl-pipes tbody th { font-family: var(--font-heading); color: var(--color-ink); }
.sl-pipes td { color: var(--color-ink-2); }
.sl-pipes tbody tr { transition: background-color var(--transition); }
.sl-pipes tbody tr:hover { background: var(--color-paper); }
@media (max-width: 900px) { .sl-age__grid { grid-template-columns: 1fr; } }

/* ---- Which repair (table) ---- */
.sl-fix { background: var(--color-paper-2); }
.sl-table-wrap { border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-line); box-shadow: var(--shadow); background: var(--color-surface); }
.sl-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); }
.sl-table caption { text-align: left; padding: var(--space-md) var(--space-lg) 0; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.sl-table thead th { text-align: left; padding: var(--space-md) var(--space-lg); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); border-bottom: 2px solid var(--color-ink); }
.sl-table tbody th, .sl-table tbody td { padding: var(--space-md) var(--space-lg); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.sl-table tbody th { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); border-left: 4px solid transparent; }
.sl-table tbody tr:nth-child(1) th { border-left-color: var(--color-card-tint-1); }
.sl-table tbody tr:nth-child(3) th, .sl-table tbody tr:nth-child(4) th { border-left-color: var(--color-accent); }
.sl-table tbody tr:last-child th { border-left-color: var(--color-accent-dark); }
.sl-table td { color: var(--color-ink-2); }
.sl-table a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 760px) {
  .sl-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .sl-table, .sl-table tbody, .sl-table tr, .sl-table th, .sl-table td { display: block; width: 100%; }
  .sl-table tbody tr { padding: var(--space-sm) 0; border-bottom: 1px solid var(--color-line); }
  .sl-table tbody th, .sl-table tbody td { border-bottom: 0; padding: var(--space-1) var(--space-lg); }
  .sl-table td[data-label]::before { content: attr(data-label) ": "; font-weight: 700; color: var(--color-ink); }
}

/* ---- Repair timeline ---- */
.sl-process { background: var(--color-surface); }
.sl-process .process-steps { margin-top: var(--space-lg); }
.sl-process .process-steps li { padding: var(--space-md) var(--space-lg); border-left: 3px solid var(--color-accent); background: var(--color-paper); border-radius: 0 var(--radius) var(--radius) 0; }

/* ---- Why Ledco: light, icon tiles ---- */
.sl-why { background: var(--color-paper); }
.sl-why__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.3fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: center; }
.sl-why__list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.sl-why__list li { display: grid; gap: var(--space-2); padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.sl-why__list li:nth-child(1) { background: var(--color-card-tint-1); }
.sl-why__list li:nth-child(4) { background: var(--color-card-tint-3); }
.sl-why__list svg { color: var(--color-accent-dark); }
.sl-why__list b { font-family: var(--font-heading); color: var(--color-ink); }
.sl-why__list span { font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 900px) { .sl-why__grid { grid-template-columns: 1fr; } }
@media (max-width: 560px) { .sl-why__list { grid-template-columns: 1fr; } }

/* ---- FAQ ---- */
.sl-faq { background: var(--color-surface); }
.sl-faq .faq-grid { grid-template-columns: 1fr; max-width: var(--measure); }
.sl-faq .faq[open] { border-top-color: var(--color-accent); }

/* ---- Other services ---- */
.sl-more { background: var(--color-paper-2); }
.sl-more .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.sl-more .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.sl-more .service-card__icon { margin-top: 0; width: var(--space-12); height: var(--space-12); color: var(--color-accent-dark); border: 1px solid var(--color-line); }
.sl-more .services-foot { margin-top: var(--space-xl); }
.sl-more .services-foot a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 900px) { .sl-more .services-grid { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.sl-cta .sl-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.sl-cta .sl-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="sl-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type sl-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/services/">Services</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Sewer Line Repair</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Seminole, OK &middot; Sewer lines</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Sewer line repair</span> in Seminole, OK</h1>
        <p class="hero-answer">Ledco Plumbing repairs sewer lines that back up, leak or fill with roots, for homes and businesses in Seminole and Wewoka. If several drains are backing up at once, or water is coming up through the lowest drain in the house, stop using water and call <?php echo esc($slPhone); ?>.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($slPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($slPhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('waves', 16); ?> Backups &amp; slow main lines</li>
          <li><?php icon('trees', 16); ?> Cracked or root-filled pipe</li>
          <li><?php icon('building-2', 16); ?> Homes &amp; businesses</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a sewer line repair estimate?</h2>
        <p class="hero-form-tagline">For a backup happening now, call instead. Otherwise, send this and Ledco Plumbing will call you back.</p>
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

<article class="sl-article">
<!-- ============================================================ CLOG VS SEWER (signature) -->
<section class="section sl-vs" id="clog-or-sewer" aria-labelledby="vs-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Clog or sewer?</span>
      <h2 id="vs-title">How do you tell a <span class="text-accent">sewer line</span> problem from an ordinary clog?</h2>
      <p class="answer-block">An ordinary clog affects one fixture; a sewer line problem affects the whole house. When the toilet gurgles as the washer drains, water rises in the tub after a flush, or the lowest drain in the house backs up, the blockage or break is in the main line that every drain empties into.</p>
    </div>
    <div class="sl-vs__grid">
      <div class="sl-vs__panel reveal-left">
        <h3><?php icon('droplets', 22); ?> Ordinary clog</h3>
        <ul>
          <li>One sink, tub or toilet is slow</li>
          <li>Other drains in the house run normally</li>
          <li>Plunging helps, at least for a while</li>
          <li>No smell outside the house</li>
        </ul>
        <p>That is a job for <a href="/services/drain-cleaning/">drain cleaning in Seminole</a>.</p>
      </div>
      <span class="sl-vs__or reveal-scale" aria-hidden="true">or</span>
      <div class="sl-vs__panel sl-vs__panel--sewer reveal-right">
        <h3><?php icon('waves', 22); ?> Sewer line problem</h3>
        <ul>
          <li>Several drains slow or backing up at the same time</li>
          <li>Water rises in the lowest drain, floor drain or shower</li>
          <li>Gurgling in one fixture when another drains</li>
          <li>Sewage smell or a soggy, extra-green strip over the line outside</li>
        </ul>
        <p>Stop running water and call Ledco Plumbing.</p>
      </div>
    </div>
    <p class="pull-quote reveal-up">If every drain is slow, no amount of work on one sink will fix it.</p>
  </div>
</section>

<!-- ============================================================ BACKUP FIRST STEPS -->
<section class="section on-dark texture-grain slant-top sl-backup" id="backup" aria-labelledby="backup-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">During a backup</span>
      <h2 id="backup-title">What should you do when the sewer backs up into the house?</h2>
      <p class="answer-block">Stop running water anywhere in the house, keep people and pets away from the sewage, and call Ledco Plumbing at <?php echo esc($slPhone); ?>. While the main line is blocked, every gallon that goes down any drain comes back up at the lowest opening in the house.</p>
    </div>
    <ol class="sl-backup__steps reveal-up">
      <li><b>Stop the water</b><span>No flushing, showers, laundry or dishwasher. Tell everyone in the house.</span></li>
      <li><b>Skip the drain cleaner</b><span>Chemicals will not open a main line and leave caustic water for whoever opens the pipe.</span></li>
      <li><b>Find the cleanout</b><span>A capped pipe sticking out of the ground near the foundation or in the yard. Say where it is when you call.</span></li>
      <li><b>Photograph the damage</b><span>Take pictures before cleanup starts, in case you file a claim with your insurer.</span></li>
    </ol>
  </div>
</section>

<!-- ============================================================ WHY OLDER LINES FAIL -->
<section class="section sl-age" id="why-lines-fail" aria-labelledby="age-title">
  <div class="container">
    <div class="sl-age__grid">
      <div class="sl-age__body reveal-left">
        <span class="eyebrow-label">Older lines</span>
        <h2 id="age-title">Why do older <span class="text-accent">Seminole</span> sewer lines break?</h2>
        <p class="answer-block">Older Seminole sewer lines break from age, roots and ground movement. Many homes built during the late-1920s oil boom and the decades after went in with cast-iron or clay-tile sewer pipe, which corrodes, cracks and pulls apart at the joints, and roots grow into any gap they find.</p>
        <p>Roots are the most common reason a line keeps backing up. A sewer pipe carries warm, wet, nutrient-rich water, and a hairline crack or loose joint lets a little of it escape. Fine roots follow it in, thicken inside the pipe and catch everything that flows past. Clearing them opens the line, but the gap they came through is still there.</p>
        <p>The ground matters too. The clay soil common around Seminole drains slowly and holds water against the pipe. Over decades, settling ground and the weight of wet soil can crack a rigid pipe or let a section sag into a low spot, called a belly, where waste settles and backs up.</p>
        <div class="sl-age__stat">
          <span class="big-number">1</span>
          <p>Every drain in a house, from the kitchen sink to the last toilet, empties into a single sewer line. When it fails, all of them back up together.</p>
        </div>
      </div>
      <div class="reveal-right">
        <table class="sl-pipes">
          <caption>Sewer pipe materials found in older homes and how each one fails</caption>
          <thead>
            <tr>
              <th scope="col">Pipe</th>
              <th scope="col">Where you find it</th>
              <th scope="col">How it fails</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Clay tile</th>
              <td>Older homes; short sections joined every few feet</td>
              <td>Roots enter at the many joints; sections crack or shift</td>
            </tr>
            <tr>
              <th scope="row">Cast iron</th>
              <td>Homes built before plastic pipe became standard</td>
              <td>Rusts from the inside, scales up, and splits along the bottom</td>
            </tr>
            <tr>
              <th scope="row">Orangeburg</th>
              <td>Homes from roughly the 1940s to the early 1970s</td>
              <td>Made of tar-soaked wood fiber; softens, blisters and flattens out of round</td>
            </tr>
            <tr>
              <th scope="row">PVC or ABS plastic</th>
              <td>Newer homes and replaced lines</td>
              <td>Rarely corrodes; fails at bad joints, from crushing, or where it sags</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ WHICH REPAIR (table) -->
<section class="section edge-curve-top sl-fix" id="which-repair" aria-labelledby="fix-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Matching the fix</span>
      <h2 id="fix-title">Which sewer repair does your line need?</h2>
      <p class="answer-block">The right sewer repair depends on what is wrong with the line. A blockage needs clearing, a single cracked, root-broken or sagging section needs that section replaced, and a line failing along its length needs replacing. The plumber should see the line first, because clearing a broken pipe only buys time.</p>
    </div>
    <div class="sl-table-wrap reveal-up">
      <table class="sl-table">
        <caption>Sewer line problems, their signs and the repair each one usually needs</caption>
        <thead>
          <tr>
            <th scope="col">Problem</th>
            <th scope="col">Signs</th>
            <th scope="col">Usual repair</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Blockage</th>
            <td data-label="Signs">Backup that clears once the line is opened and stays clear</td>
            <td data-label="Repair">Clearing the line; see <a href="/services/drain-cleaning/">drain cleaning</a></td>
          </tr>
          <tr>
            <th scope="row">Roots at a joint</th>
            <td data-label="Signs">Backups that return weeks or months after clearing</td>
            <td data-label="Repair">Clearing the roots, then repairing the joint they came through</td>
          </tr>
          <tr>
            <th scope="row">Cracked or broken section</th>
            <td data-label="Signs">Backup that will not clear, sewage smell, soggy ground over the line</td>
            <td data-label="Repair">Digging at the break and replacing that section</td>
          </tr>
          <tr>
            <th scope="row">Belly (sagging section)</th>
            <td data-label="Signs">Recurring partial clogs at the same distance down the line</td>
            <td data-label="Repair">Re-laying the section so it slopes toward the sewer</td>
          </tr>
          <tr>
            <th scope="row">Failing along its length</th>
            <td data-label="Signs">Breaks in more than one place; collapsed Orangeburg or badly corroded cast iron</td>
            <td data-label="Repair">Replacing the line from the house to the main</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ============================================================ REPAIR PROCESS -->
<section class="section sl-process" id="process" aria-labelledby="process-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">The repair</span>
      <h2 id="process-title">How does Ledco Plumbing handle a sewer line repair?</h2>
      <p class="answer-block">A sewer line repair with Ledco Plumbing starts with finding what is wrong and where along the line, then pricing the repair that fits. Once you approve the estimate, the damaged section is repaired or replaced and every drain in the house is run to prove the line flows.</p>
    </div>
    <ol class="process-steps reveal-up">
      <li><b>Get the line flowing</b><span>If the house is backed up, the first job is to open the line so you can use your plumbing again.</span></li>
      <li><b>Find the cause and the spot</b><span>Blockage, roots, a break or a belly, and how far from the house it sits.</span></li>
      <li><b>Approve the repair</b><span>You see the price for the repair that fits the problem before any digging starts.</span></li>
      <li><b>Repair and run every drain</b><span>After the repair, fixtures throughout the house are run together to confirm the line keeps up.</span></li>
    </ol>
    <p class="reveal-up">More on everything Ledco Plumbing does is on the <a href="/services/">Seminole plumbing services page</a>.</p>
  </div>
</section>

<!-- ============================================================ WHY LEDCO -->
<section class="section sl-why" id="why" aria-labelledby="why-title">
  <div class="container">
    <div class="sl-why__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">Why Ledco Plumbing</span>
        <h2 id="why-title">Why call Ledco Plumbing for sewer line repair in <span class="text-accent">Seminole</span>?</h2>
        <p class="answer-block">Ledco Plumbing handles both drain cleaning and sewer line repair, so a backup that turns out to be a broken pipe is not handed to someone else. The Seminole company is owned by Mickey Ledbetter, you approve the price before any digging, and the office takes calls every day.</p>
      </div>
      <ul class="sl-why__list reveal-right">
        <li><?php icon('waves', 22); ?><b>Clearing and repair</b><span>The company that opens the line can also fix the break.</span></li>
        <li><?php icon('clipboard-list', 22); ?><b>Price before digging</b><span>You approve the estimate before the yard is opened.</span></li>
        <li><?php icon('calendar', 22); ?><b>Open every day</b><span>Monday through Sunday, 7 AM to 5 PM.</span></li>
        <li><?php icon('map-pin', 22); ?><b>Based on E Oak Ave</b><span>Serving Seminole and Wewoka from 316 E Oak Ave.</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- ============================================================ REVIEWS (Page One feed; renders only when real reviews exist) -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$slReviews = p1_google_reviews($slug, ['heading' => 'What do Seminole customers say about Ledco Plumbing on Google?', 'limit' => 6]);
if ($slReviews !== ''): ?>
<section class="section sl-reviews" aria-label="Google reviews"><div class="container"><?php echo $slReviews; ?></div></section>
<?php endif; ?>

<!-- ============================================================ FAQ -->
<section class="section slant-top sl-faq" id="faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">Will Ledco Plumbing come out for a <span class="text-accent">sewer backup</span>?</h2>
      <p class="answer-block">Ledco Plumbing takes sewer backup calls by phone every day of the week, 7 AM to 5 PM. A backup should always be a phone call rather than a web form, so the office hears about it right away. The answer below covers what to tell the office when you call.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($faqs as $slFaq): ?>
      <details class="faq" open>
        <summary><?php echo esc($slFaq['q']); ?></summary>
        <p><?php echo esc($slFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
</article>

<!-- ============================================================ OTHER SERVICES -->
<section class="section sl-more" aria-label="Other plumbing services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which other <span class="text-accent">Ledco Plumbing</span> services pair with sewer work?</h2>
      <p class="answer-block">Beyond sewer line repair, Ledco Plumbing handles commercial plumbing, clears drains, repairs and installs water heaters, and finds hidden leaks for Seminole and Wewoka properties. The three below each have their own page with the warning signs and how the work is done.</p>
    </div>
    <div class="services-grid">
<?php foreach (p1_other_services($svcSlug) as $slIdx => $slOther) p1_render_service_card($slOther, $slIdx + 1, 'reveal-up'); ?>
    </div>
    <p class="services-foot reveal-up"><a href="/services/">See all five Ledco Plumbing services &rarr;</a></p>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top sl-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Need your sewer line looked at?</h2>
      <p>Call Ledco Plumbing at <?php echo esc($slPhone); ?> or request an estimate online. If sewage is coming up into the house now, call.</p>
      <p class="sl-cta__links"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">See Ledco Plumbing on Google Maps</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($slPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
