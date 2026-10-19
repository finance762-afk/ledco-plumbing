<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * services/index.php — services hub (Phase 4, minimal-tech).
 *
 * Section script: interior type hero → full services grid (featured 2x2, required component) → "have this ready
 * when you call" table (signature: the hub's own information) → how pricing works (asymmetric, steps) → closing CTA.
 * No FAQ: the research brief's questions are answered on the homepage and the service pages.
 *
 * Claims: business facts from build-plan.json / config.php only. Prices, trip/diagnostic fees and
 * written-estimate terms are NOT in intake — the pricing section states only that the price comes before the work
 * (homepage process, research brief), and the rest is in /content-confirmations.json.
 */
$pageTitle       = 'Plumbing Services in Seminole, OK | Ledco Plumbing';
$pageDescription = 'Drain cleaning, water heater repair and installation, leak detection, sewer line repair and commercial plumbing in Seminole and Wewoka, OK. Call (405) 257-3096.';
$canonicalUrl    = $siteUrl . '/services/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'services';
$pageType        = 'other';

$hubPhone     = formatPhone($phone);
$hubPhoneHref = phoneHref($phone);
$hubBase      = rtrim($siteUrl, '/');

// ---- Schema: CollectionPage + ItemList of the five Service nodes' URLs + BreadcrumbList ---------------
$hubItems = [];
foreach ($services as $hubPos => $hubSvc) {
    $hubItems[] = ['@type' => 'ListItem', 'position' => $hubPos + 1, 'name' => $hubSvc['name'], 'url' => $hubBase . '/services/' . $hubSvc['slug'] . '/'];
}
$pageSchema = [
    [
        '@type'       => 'CollectionPage',
        '@id'         => $hubBase . '/services/#webpage',
        'url'         => $hubBase . '/services/',
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'isPartOf'    => ['@id' => schemaId('website')],
        'about'       => ['@id' => schemaId('organization')],
        'breadcrumb'  => ['@id' => $hubBase . '/services/#breadcrumb'],
        'mainEntity'  => ['@type' => 'ItemList', 'name' => $siteName . ' plumbing services', 'itemListElement' => $hubItems],
        'speakable'   => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['.hero-answer', '.answer-block']],
    ],
    ['@id' => $hubBase . '/services/#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['Services', '/services/']]),
];
$schemaMarkup = $pageSchema;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-cards.php';

// ---- "Have this ready" rows: what the office asks first for each service, and why ---------------------
$hubReady = [
    'drain-cleaning'                   => ['Which drains are slow, and whether more than one backs up at the same time', 'One drain points to that fixture; several at once points to the main line'],
    'water-heater-repair-installation' => ['A photo of the heater\'s label, gas or electric, and what it is doing (no heat, leaking, noise)', 'The label gives the size, fuel and build date, which shapes repair-or-replace'],
    'leak-detection-repair'            => ['Whether the water meter moves with everything off, and with the house valve closed', 'That splits the search between the yard line and the house'],
    'sewer-line-repair'                => ['Which drains back up, where the water comes up, and where the cleanout is', 'The lowest drain backing up and a known cleanout make the first visit faster'],
    'commercial-plumbing'              => ['Business name, who can let the plumber in, and who approves the estimate', 'Commercial jobs stall on access and sign-off more than on plumbing'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   services/index.php — services hub composition (minimal-tech). Tokens only.
   ============================================================================ */
.hub-page h1, .hub-page h2, .hub-page h3, .hub-table tbody th { text-wrap: balance; }
.hub-page p { text-wrap: pretty; }

/* ---- Hero: compact dark type hero, five-line "service bus" motif (C1 layered) ---- */
.hub-hero { background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 100%); }
.hub-hero::before {
  content: "";
  position: absolute;
  inset: 0 -5% 0 58%;
  z-index: -1;
  pointer-events: none;
  background: repeating-linear-gradient(90deg, transparent 0 var(--space-xl), color-mix(in srgb, var(--color-white) 7%, transparent) var(--space-xl) calc(var(--space-xl) + 2px), transparent calc(var(--space-xl) + 2px) var(--space-3xl));
  -webkit-mask-image: linear-gradient(180deg, var(--color-black), transparent 85%);
  mask-image: linear-gradient(180deg, var(--color-black), transparent 85%);
}
.hub-hero::after {
  content: "";
  position: absolute;
  inset: -30% -10% auto 50%;
  height: 130%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 72%);
}
.hub-hero .grain { opacity: .3; }
.hub-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.hub-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.hub-hero .breadcrumb a:hover, .hub-hero .breadcrumb [aria-current] { color: var(--color-white); }
.hub-hero__inner { display: grid; gap: var(--space-md); max-width: 46rem; }
.hub-hero .hero-title { max-width: 20ch; }
.hub-hero .hero-answer { max-width: 40rem; }
.hub-hero .link-call { color: var(--color-white); }
.hub-hero .hero-actions .btn { display: inline-flex; }
@media (max-width: 560px) { .hub-hero .hero-answer { font-size: var(--fs-body); } }

/* ---- Services grid: featured 2x2 drain tile, icon-led cards ---- */
.hub-services { background: var(--color-paper); }
.hub-services .section-title { max-width: 66ch; }
.hub-services .answer-block { max-width: 64ch; }
.hub-services .service-card-with-image { border-color: color-mix(in srgb, var(--color-ink) 10%, transparent); }
.hub-services .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); gap: var(--space-sm); }
.hub-services .service-card__icon { margin-top: 0; width: var(--space-12); height: var(--space-12); background: var(--color-surface); color: var(--color-accent-dark); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.hub-services .service-card-with-image:hover .service-card__icon { color: var(--color-surface); background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.hub-services .services-grid--featured > :first-child { background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-primary-deep) 120%); color: var(--color-white); border-color: transparent; }
.hub-services .services-grid--featured > :first-child[data-featured-label]::after { left: auto; right: var(--space-lg); top: var(--space-lg); color: var(--color-white); background: var(--color-accent-dark); }
.hub-services .services-grid--featured > :first-child .service-card__body { justify-content: flex-end; padding: var(--space-xl); }
.hub-services .services-grid--featured > :first-child .service-card__icon { margin-bottom: auto; width: var(--space-16); height: var(--space-16); background: color-mix(in srgb, var(--color-white) 10%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-accent-bright); box-shadow: none; }
.hub-services .services-grid--featured > :first-child h3 { margin-top: var(--space-2xl); color: var(--color-white); font-size: var(--fs-h2); }
.hub-services .services-grid--featured > :first-child .service-card__desc { color: color-mix(in srgb, var(--color-white) 82%, transparent); font-size: var(--fs-lead); max-width: 34ch; }
.hub-services .services-grid--featured > :first-child ul { border-top-color: color-mix(in srgb, var(--color-white) 18%, transparent); }
.hub-services .services-grid--featured > :first-child ul li { color: color-mix(in srgb, var(--color-white) 86%, transparent); }
.hub-services .services-grid--featured > :first-child ul li::before { color: var(--color-accent-bright); }
.hub-services .services-grid--featured > :first-child .service-card__cta { color: var(--color-accent-bright); }
@media (max-width: 1000px) {
  .hub-services .services-grid { grid-template-columns: 1fr 1fr; }
  .hub-services .services-grid--featured > :first-child { grid-column: span 2; grid-row: auto; }
}
@media (max-width: 560px) {
  .hub-services .services-grid { grid-template-columns: 1fr; }
  .hub-services .services-grid--featured > :first-child { grid-column: auto; }
}

/* ---- Have-this-ready table (signature) ---- */
.hub-ready { background: var(--color-surface); }
.hub-ready__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 2fr); gap: clamp(var(--space-xl), 4vw, var(--space-3xl)); align-items: start; }
.hub-ready .section-title { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.hub-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); }
.hub-table caption { text-align: left; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); padding-bottom: var(--space-sm); }
.hub-table thead th { text-align: left; padding: var(--space-sm) var(--space-md); border-bottom: 2px solid var(--color-ink); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.hub-table tbody th, .hub-table tbody td { padding: var(--space-md); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.hub-table tbody th { width: 26%; }
.hub-table tbody th a { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); text-decoration-color: var(--color-accent); text-underline-offset: .25em; }
.hub-table tbody th a:hover { color: var(--color-accent-dark); }
.hub-table td { color: var(--color-ink-2); }
.hub-table td:last-child { color: var(--color-muted); }
.hub-table tbody tr { transition: background-color var(--transition); }
.hub-table tbody tr:hover { background: var(--color-paper); }
@media (max-width: 1000px) { .hub-ready__grid { grid-template-columns: 1fr; } .hub-ready .section-title { position: static; } }
@media (max-width: 700px) {
  .hub-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .hub-table, .hub-table tbody, .hub-table tr, .hub-table th, .hub-table td { display: block; width: 100%; }
  .hub-table tbody tr { padding: var(--space-sm) 0; border-bottom: 1px solid var(--color-line); }
  .hub-table tbody th, .hub-table tbody td { border: 0; padding: var(--space-1) 0; width: 100%; }
  .hub-table td[data-label]::before { content: attr(data-label) ": "; font-weight: 700; color: var(--color-ink); }
}

/* ---- Pricing: dark band, slant, asymmetric with steps ---- */
.hub-price .container { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.hub-price .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.hub-price__body { display: grid; gap: var(--space-md); }
.hub-price__body > p { margin: 0; max-width: var(--measure); }
.hub-price__factors { display: grid; gap: var(--space-sm); margin: 0; padding: 0; list-style: none; }
.hub-price__factors li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-sm); align-items: start; padding: var(--space-md) var(--space-lg); border-radius: var(--radius); background: color-mix(in srgb, var(--color-white) 5%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 12%, transparent); font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.hub-price__factors svg { color: var(--color-accent-bright); margin-top: var(--space-1); }
.hub-price__factors b { color: var(--color-white); }
@media (max-width: 900px) { .hub-price .container { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.hub-cta .hub-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.hub-cta .hub-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="hub-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type hub-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Services</span></li>
      </ol>
    </nav>
    <div class="hub-hero__inner">
      <span class="eyebrow">Seminole, OK &middot; <?php echo count($services); ?> services</span>
      <h1 class="hero-title" id="hero-title"><span class="text-accent">Plumbing services</span> in Seminole, OK</h1>
      <p class="hero-answer">Ledco Plumbing is a Seminole plumber offering five services: drain cleaning, water heater repair and installation, leak detection and repair, sewer line repair, and commercial plumbing. The company works on homes and businesses in Seminole and Wewoka and takes calls seven days a week.</p>
      <div class="hero-actions">
        <?php echo estimateTrigger('btn btn-accent btn-lg', 'Request an estimate'), "\n"; ?>
        <a class="link-call" href="<?php echo esc($hubPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($hubPhone); ?></a>
      </div>
      <ul class="hero-chips">
        <li><?php icon('map-pin', 16); ?> Seminole &amp; Wewoka</li>
        <li><?php icon('building-2', 16); ?> Homes &amp; businesses</li>
        <li><?php icon('clock', 16); ?> Mon&ndash;Sun, 7 AM&ndash;5 PM</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============================================================ SERVICES GRID -->
<section class="section hub-services" id="services" aria-label="Plumbing services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which <span class="text-accent">plumbing services</span> does Ledco Plumbing offer in Seminole and Wewoka?</h2>
      <p class="answer-block">Ledco Plumbing offers drain cleaning, water heater repair and installation, leak detection and repair, sewer line repair, and commercial plumbing in Seminole and Wewoka. Each service below has its own page with the warning signs to look for, what the work involves, and how a visit runs from the first call to the final test.</p>
    </div>
    <div class="services-grid services-grid--featured">
<?php foreach ($services as $hubIdx => $hubSvc) {
    p1_render_service_card($hubSvc, ($hubIdx % 3) + 1, $hubIdx === 0 ? 'reveal-left' : 'reveal-up', $hubIdx === 0 ? 'data-featured-label="Most requested"' : '');
} ?>
    </div>
  </div>
</section>

<!-- ============================================================ HAVE THIS READY (signature) -->
<section class="section slant-top hub-ready" id="before-you-call" aria-labelledby="ready-title">
  <div class="container-wide">
    <div class="hub-ready__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">Before you call</span>
        <h2 id="ready-title">What should you have ready when you call about each service?</h2>
        <p class="answer-block">Have one or two details ready for the service you need, so the office can plan the right visit. That means which drains are slow, the label on the water heater, what the water meter does, where the sewer cleanout is, or who can open the building. Each answer tells Ledco Plumbing what to expect before anyone arrives.</p>
      </div>
      <div class="reveal-right">
        <table class="hub-table">
          <caption>What the Ledco Plumbing office asks first for each service, and why it helps</caption>
          <thead>
            <tr>
              <th scope="col">Service</th>
              <th scope="col">Have this ready</th>
              <th scope="col">Why it helps</th>
            </tr>
          </thead>
          <tbody>
<?php foreach ($services as $hubRowSvc):
    $hubRow = $hubReady[$hubRowSvc['slug']] ?? null;
    if (!$hubRow) continue; ?>
            <tr>
              <th scope="row"><?php if (serviceLive($hubRowSvc['slug'])): ?><a href="/services/<?php echo esc($hubRowSvc['slug']); ?>/"><?php echo esc($hubRowSvc['name']); ?></a><?php else: echo esc($hubRowSvc['name']); endif; ?></th>
              <td data-label="Have ready"><?php echo esc($hubRow[0]); ?></td>
              <td data-label="Why"><?php echo esc($hubRow[1]); ?></td>
            </tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ PRICING -->
<section class="section on-dark texture-grain edge-curve-top hub-price" id="pricing" aria-labelledby="price-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="hub-price__body reveal-left">
      <span class="eyebrow-label">Pricing</span>
      <h2 id="price-title">How does Ledco Plumbing price a plumbing job?</h2>
      <p class="answer-block">Ledco Plumbing prices each job after a plumber has seen the problem, and you get that price before any work starts. Because the cause decides the fix, a slow drain, a failed water heater part and a broken sewer line are priced on what each one actually needs.</p>
      <p>That is also why one service can lead to another. A drain that will not stay clear may need <a href="/services/sewer-line-repair/">sewer line repair</a>; a puddle near the water heater may be a supply line that calls for <a href="/services/leak-detection-repair/">leak detection</a>. The estimate covers the repair the problem needs, and you decide whether to go ahead.</p>
    </div>
    <ul class="hub-price__factors reveal-right" aria-label="What changes the price of a plumbing job">
      <li><?php icon('search', 18); ?><span><b>The cause.</b> A clog, a worn part, a split pipe or a failed tank are different repairs.</span></li>
      <li><?php icon('ruler', 18); ?><span><b>Where it is.</b> Under a sink, inside a wall, under a slab or out in the yard.</span></li>
      <li><?php icon('wrench', 18); ?><span><b>Parts.</b> A flapper, a heating element or a new water heater.</span></li>
      <li><?php icon('building-2', 18); ?><span><b>Home or business.</b> Commercial fixtures and access can change the job.</span></li>
    </ul>
  </div>
</section>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top hub-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Not sure which service you need?</h2>
      <p>Describe what you are seeing to Ledco Plumbing at <?php echo esc($hubPhone); ?> and the office will point you to the right visit. The <a href="/#symptoms">symptom guide on the homepage</a> can help too.</p>
      <p class="hub-cta__links"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">See Ledco Plumbing on Google Maps</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($hubPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
