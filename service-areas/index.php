<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * service-areas/index.php — service-area hub (Phase 6, minimal-tech).
 *
 * Section script: interior type hero → coverage intro + two area cards (asymmetric, featured Seminole) → map of the office
 * (signature: embed + address card) → how to confirm an address → closing CTA.
 *
 * Claims: company facts from build-plan.json / config.php only (office, owner, hours, services, the two service areas).
 * Town facts are the ones researched on the two area pages (sources are in their comment headers). The build plan's
 * target_radius is 25 miles but its service_areas list holds only Seminole and Wewoka, so only those two are named.
 */
$pageTitle       = 'Service Areas: Seminole & Wewoka, OK | Ledco Plumbing';
$pageDescription = 'Ledco Plumbing LLC serves Seminole and Wewoka, OK from its office at 316 E Oak Ave: drain cleaning, water heaters, leaks, sewer lines and commercial plumbing.';
$canonicalUrl    = $siteUrl . '/service-areas/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'service-areas';
$pageType        = 'other';

$hubPhone     = formatPhone($phone);
$hubPhoneHref = phoneHref($phone);
$hubBase      = rtrim($siteUrl, '/');

// ---- Card copy per area slug: one local line, three facts, link text -------------------------------
$hubAreaCopy = [
    'seminole-ok' => [
        'tag'   => 'Home office',
        'line'  => 'The 1926 oil boom grew Seminole from 854 people to an estimated 25,000 to 30,000, so the oldest plumbing in town is now close to a century old.',
        'facts' => ['Office at 316 E Oak Ave', 'ZIP codes 74818 and 74868', 'Boom-era pipe, freeze and wet ground'],
        'cta'   => 'Plumbing in Seminole',
    ],
    'wewoka-ok' => [
        'tag'   => 'County seat',
        'line'  => 'Wewoka is the Seminole County seat and the Seminole Nation capital, a town of courthouses, a 1934 WPA museum and National Register buildings.',
        'facts' => ['About 10 miles southeast of the office', 'ZIP code 74884', 'Older buildings, offices and public sites'],
        'cta'   => 'Plumbing in Wewoka',
    ],
];

// ---- Schema: CollectionPage + ItemList of the area pages + BreadcrumbList ------------------------------
$hubItems = [];
foreach ((array) $serviceAreaDetails as $hubPos => $hubSchemaArea) {
    $hubItems[] = ['@type' => 'ListItem', 'position' => $hubPos + 1, 'name' => $hubSchemaArea['city'] . ', ' . $hubSchemaArea['state'], 'url' => $hubBase . '/service-areas/' . $hubSchemaArea['slug'] . '/'];
}
$pageSchema = [
    [
        '@type'       => 'CollectionPage',
        '@id'         => $hubBase . '/service-areas/#webpage',
        'url'         => $hubBase . '/service-areas/',
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'isPartOf'    => ['@id' => schemaId('website')],
        'about'       => ['@id' => schemaId('organization')],
        'breadcrumb'  => ['@id' => $hubBase . '/service-areas/#breadcrumb'],
        'mainEntity'  => ['@type' => 'ItemList', 'name' => $siteName . ' service areas', 'itemListElement' => $hubItems],
        'speakable'   => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['.hero-answer', '.answer-block']],
    ],
    ['@id' => $hubBase . '/service-areas/#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['Service Areas', '/service-areas/']]),
];
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   service-areas/index.php — service-area hub composition (minimal-tech). Tokens only.
   ============================================================================ */
.sah-page h1, .sah-page h2, .sah-page h3 { text-wrap: balance; }
.sah-page p { text-wrap: pretty; }

/* ---- Hero: compact dark type hero, two converging route lines (C1 layered) ---- */
.sah-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 100%); }
.sah-hero::before {
  content: "";
  position: absolute;
  inset: 0 -5% 0 55%;
  z-index: -1;
  pointer-events: none;
  background:
    linear-gradient(35deg, transparent calc(50% - 1px), color-mix(in srgb, var(--color-white) 12%, transparent) calc(50% - 1px), color-mix(in srgb, var(--color-white) 12%, transparent) calc(50% + 1px), transparent calc(50% + 1px)),
    linear-gradient(-20deg, transparent calc(50% - 1px), color-mix(in srgb, var(--color-white) 8%, transparent) calc(50% - 1px), color-mix(in srgb, var(--color-white) 8%, transparent) calc(50% + 1px), transparent calc(50% + 1px));
  -webkit-mask-image: linear-gradient(100deg, transparent 5%, var(--color-black) 60%);
  mask-image: linear-gradient(100deg, transparent 5%, var(--color-black) 60%);
}
.sah-hero::after {
  content: "";
  position: absolute;
  inset: -30% -10% auto 55%;
  height: 130%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 72%);
}
.sah-hero .grain { opacity: .3; }
.sah-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.sah-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.sah-hero .breadcrumb a:hover, .sah-hero .breadcrumb [aria-current] { color: var(--color-white); }
.sah-hero__inner { display: grid; gap: var(--space-md); max-width: 46rem; }
.sah-hero .hero-title { max-width: 24ch; }
.sah-hero .hero-answer { max-width: 40rem; }
.sah-hero .link-call { color: var(--color-white); }
.sah-hero .hero-actions .btn { display: inline-flex; }
@media (max-width: 560px) { .sah-hero .hero-answer { font-size: var(--fs-body); } }

/* ---- Area cards: asymmetric 1.35 : 1, Seminole as the dark featured card ---- */
.sah-areas { background: var(--color-paper); }
.sah-areas .section-title { max-width: 66ch; }
.sah-grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr); gap: var(--space-lg); align-items: stretch; }
.sah-card { display: grid; gap: var(--space-md); align-content: start; padding: var(--space-xl); border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-card-tint-3); scroll-margin-top: calc(var(--nav-height) + var(--space-xl)); transition: transform var(--transition), box-shadow var(--transition); }
.sah-card:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow-lg); }
.sah-card__tag { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.sah-card h3 { margin: 0; font-size: var(--fs-h2); }
.sah-card p { margin: 0; color: var(--color-ink-2); }
.sah-card ul { margin: 0; padding: var(--space-md) 0 0; list-style: none; display: grid; gap: var(--space-2); border-top: 1px solid color-mix(in srgb, var(--color-ink) 14%, transparent); font-size: var(--fs-small); }
.sah-card li { display: flex; gap: var(--space-2); align-items: flex-start; }
.sah-card li svg { flex: 0 0 auto; margin-top: .2em; color: var(--color-accent-dark); }
.sah-card .btn { justify-self: start; }
.sah-card--feature { background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-primary-deep) 120%); color: var(--color-white); border-color: transparent; }
.sah-card--feature .sah-card__tag { color: var(--color-accent-bright); }
.sah-card--feature h3 { color: var(--color-white); }
.sah-card--feature p { color: color-mix(in srgb, var(--color-white) 84%, transparent); font-size: var(--fs-lead); }
.sah-card--feature ul { border-top-color: color-mix(in srgb, var(--color-white) 18%, transparent); color: color-mix(in srgb, var(--color-white) 86%, transparent); }
.sah-card--feature li svg { color: var(--color-accent-bright); }
@media (max-width: 900px) { .sah-grid { grid-template-columns: 1fr; } }

/* ---- Map (signature): embed + office card ---- */
.sah-map { background: var(--color-surface); }
.sah-map__grid { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: center; }
.sah-map .map-embed { box-shadow: var(--shadow-lg); border: 1px solid var(--color-line); }
.sah-map__body { display: grid; gap: var(--space-md); }
.sah-map__body > p:not(.answer-block) { margin: 0; color: var(--color-ink-2); max-width: var(--measure); }
.sah-map__nap { display: grid; gap: var(--space-2); margin: 0; padding: var(--space-lg); list-style: none; border-radius: var(--radius-lg); background: var(--color-card-tint-1); border: 1px solid var(--color-line); font-size: var(--fs-small); }
.sah-map__nap li { display: flex; gap: var(--space-2); align-items: flex-start; }
.sah-map__nap svg { flex: 0 0 auto; margin-top: .2em; color: var(--color-accent-dark); }
.sah-map__nap a { color: var(--color-primary); font-weight: 600; }
.sah-map__body .btn { justify-self: start; }
@media (max-width: 900px) { .sah-map__grid { grid-template-columns: 1fr; } }

/* ---- Address check: dark band, three steps ---- */
.sah-check .container { display: grid; gap: var(--space-xl); }
.sah-check .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.sah-check__steps { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; counter-reset: sah-step; }
.sah-check__steps li { counter-increment: sah-step; display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); background: color-mix(in srgb, var(--color-white) 4%, transparent); }
.sah-check__steps li::before { content: counter(sah-step, decimal-leading-zero); font-family: var(--font-accent); font-size: var(--fs-h3); letter-spacing: .08em; color: var(--color-accent-bright); }
.sah-check__steps b { font-family: var(--font-heading); color: var(--color-white); }
.sah-check__steps span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
@media (max-width: 760px) { .sah-check__steps { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.sah-cta .container { align-items: center; }
.sah-cta .sah-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.sah-cta .sah-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="sah-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type sah-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Service Areas</span></li>
      </ol>
    </nav>
    <div class="sah-hero__inner">
      <span class="eyebrow">Seminole County, OK &middot; <?php echo count((array) $serviceAreaDetails); ?> service areas</span>
      <h1 class="hero-title" id="hero-title"><span class="text-accent">Plumbing</span> in Seminole, OK &amp; Surrounding Communities</h1>
      <p class="hero-answer">Ledco Plumbing LLC works out of 316 E Oak Ave in Seminole and serves Seminole and Wewoka, with drain cleaning, water heaters, leak detection, sewer line repair and commercial plumbing. Call <?php echo esc($hubPhone); ?>, seven days a week.</p>
      <div class="hero-actions">
        <?php echo estimateTrigger('btn btn-accent btn-lg', 'Request an estimate'), "\n"; ?>
        <a class="link-call" href="<?php echo esc($hubPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($hubPhone); ?></a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ AREA CARDS -->
<section class="section sah-areas" id="areas" aria-labelledby="areas-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Where We Work</span>
      <h2 id="areas-title">Which communities does <span class="text-accent">Ledco Plumbing</span> serve around Seminole?</h2>
      <p class="answer-block">Ledco Plumbing LLC serves two communities: Seminole, where its office is at 316 E Oak Ave, and Wewoka, the Seminole County seat about 10 miles to the southeast. Both get all five services, and each has its own page covering the local conditions a plumber plans around.</p>
    </div>
    <div class="sah-grid">
<?php foreach ((array) $serviceAreaDetails as $hubIdx => $hubArea):
    $hubCopy = $hubAreaCopy[$hubArea['slug']] ?? null;
    if (!$hubCopy) continue;
    $hubHref = areaHref($hubArea['slug']);
    $hubFeature = $hubIdx === 0; ?>
      <article class="sah-card<?php echo $hubFeature ? ' sah-card--feature' : ''; ?> <?php echo $hubFeature ? 'reveal-left' : 'reveal-right'; ?>" id="<?php echo esc($hubArea['slug']); ?>">
        <span class="sah-card__tag"><?php echo esc($hubCopy['tag']); ?></span>
        <h3><?php echo esc($hubArea['city'] . ', ' . $hubArea['state']); ?></h3>
        <p><?php echo esc($hubCopy['line']); ?></p>
        <ul>
<?php foreach ($hubCopy['facts'] as $hubFact): ?>
          <li><?php icon('check', 16); ?><span><?php echo esc($hubFact); ?></span></li>
<?php endforeach; ?>
        </ul>
<?php if ($hubHref && areaLive($hubArea['slug'])): ?>
        <a class="btn <?php echo $hubFeature ? 'btn-accent' : 'btn-primary'; ?>" href="<?php echo esc($hubHref); ?>"><?php echo esc($hubCopy['cta']); ?><span class="sr-only"> — read the <?php echo esc($hubArea['city']); ?> page</span></a>
<?php endif; ?>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ MAP (signature) -->
<section class="section edge-curve-top sah-map" id="map" aria-labelledby="map-title">
  <div class="container-wide">
    <div class="sah-map__grid">
      <div class="map-embed reveal-left">
        <iframe src="<?php echo esc($gbp['embed_src']); ?>" title="Map of the Ledco Plumbing office at 316 E Oak Ave, Seminole, Oklahoma" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="sah-map__body reveal-right">
        <span class="eyebrow-label">Coverage map</span>
        <h2 id="map-title">Where is Ledco Plumbing based, and how far does it reach?</h2>
        <p class="answer-block">Ledco Plumbing LLC is based at 316 E Oak Ave in Seminole, Oklahoma, and reaches Wewoka, about 10 miles southeast. The map shows the office. Wewoka Lake lies between the two towns.</p>
        <ul class="sah-map__nap">
          <li><?php icon('map-pin', 18); ?><span><?php echo esc($address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip']); ?></span></li>
          <li><?php icon('phone', 18); ?><a href="<?php echo esc($hubPhoneHref); ?>"><?php echo esc($hubPhone); ?></a></li>
          <li><?php icon('clock', 18); ?><span><?php echo esc($businessHours); ?></span></li>
        </ul>
        <a class="btn btn-primary" href="<?php echo esc($gbp['directions']); ?>" target="_blank" rel="noopener"><?php icon('map-pin', 18); ?> Get directions</a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ ADDRESS CHECK -->
<section class="section on-dark texture-grain slant-top sah-check" id="check" aria-labelledby="check-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Not sure you are covered?</span>
      <h2 id="check-title">How do you check that Ledco Plumbing serves your <span class="text-accent">address</span>?</h2>
      <p class="answer-block">Call Ledco Plumbing at <?php echo esc($hubPhone); ?> or send the estimate form with your street address, and the office confirms whether the address is in a service area. Seminole spans two ZIP codes and several school districts, so the street address is a better test than the town name.</p>
    </div>
    <ol class="sah-check__steps reveal-up">
      <li><b>Give the street address</b><span>Say the street address and town, not only the ZIP code. Seminole uses 74818 and 74868.</span></li>
      <li><b>Describe the problem</b><span>Which fixture, how long, and whether water is running now. If it is, close the main shutoff first.</span></li>
      <li><b>Get the price first</b><span>The office tells you what the visit involves, and you see the price before any work starts.</span></li>
    </ol>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top sah-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Get a Free Estimate in Seminole or Wewoka</h2>
      <p>Call Ledco Plumbing at <?php echo esc($hubPhone); ?> or request an estimate online. See the full <a href="/services/">list of services</a> before you call.</p>
      <p class="sah-cta__links"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">See Ledco Plumbing on Google Maps</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($hubPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
