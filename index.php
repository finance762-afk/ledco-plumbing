<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * index.php — Ledco Plumbing LLC homepage (Phase 3, v7 scaffold, archetype minimal-tech).
 *
 * Section script (editorial — the intake has no client photos, so no gallery and a typography hero):
 *   hero--type → ticker → services → proof strip → symptom guide (signature, C7) → about/process
 *   → shut-off CTA band → Google reviews (feed-gated) → FAQ → estimate section.
 *
 * Every fact on this page traces to build-plan.json / config.php. Facts the page wanted but intake does
 * not supply (license, insurance, years, after-hours service, prices, real job photos) are left out and
 * listed in /content-confirmations.json for the client to confirm.
 *
 * Local history source for the about copy (Seminole oil boom, late 1920s):
 *   https://www.okhistory.org/publications/enc/entry?entry=SE012  (Oklahoma Historical Society, "Seminole")
 *   https://www.okhistory.org/publications/enc/entry?entry=GR020  ("Greater Seminole Oil Field")
 */
$pageTitle       = 'Drain Cleaning & Plumber in Seminole, OK | Ledco Plumbing';
$pageDescription = 'Ledco Plumbing LLC in Seminole, OK: drain cleaning, water heater repair & installation, leak detection, sewer line repair and commercial plumbing.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'home';
$pageType        = 'home';
$heroPreloadImage = null;   // no client photo in the manifest: typography hero, nothing to preload

$homeCity  = $address['city'];
$homeState = $address['state'];
$homePhone     = formatPhone($phone);
$homePhoneHref = phoneHref($phone);

// ---- Services (config.php registry) with homepage card copy — exactly 3 bullets each ----------------
$homeServiceCopy = [
    'drain-cleaning' => [
        'icon'    => 'droplets',
        'desc'    => 'Clearing clogged and slow drains in kitchens, bathrooms, laundry rooms and main lines.',
        'bullets' => ['Kitchen, bath and laundry drains', 'Main line backups cleared', 'Homes and commercial buildings'],
    ],
    'water-heater-repair-installation' => [
        'icon'    => 'flame',
        'desc'    => 'Repair or replacement when a water heater leaks, runs cold or rumbles.',
        'bullets' => ['No-hot-water problems diagnosed', 'Leaking tanks repaired or replaced', 'New heaters installed and tested'],
    ],
    'leak-detection-repair' => [
        'icon'    => 'search',
        'desc'    => 'Finding hidden leaks in walls, floors and yard lines, then fixing them.',
        'bullets' => ['High water bills traced', 'Stains and wet spots located', 'Repair made once found'],
    ],
    'sewer-line-repair' => [
        'icon'    => 'waves',
        'desc'    => 'Repair of backed-up, cracked or root-damaged sewer lines.',
        'bullets' => ['Backups and gurgling drains fixed', 'Cracked or broken pipe repaired', 'Root-damaged lines restored'],
    ],
    'commercial-plumbing' => [
        'icon'    => 'building-2',
        'desc'    => 'Plumbing repair for Seminole-area shops, offices and other commercial properties.',
        'bullets' => ['Restroom and fixture repairs', 'Drain and sewer problems handled', 'Water heaters for businesses'],
    ],
];

// ---- Symptom guide (signature section) — general plumbing diagnosis, no business claims ----------
$homeSymptoms = [
    ['symptom' => 'One sink, tub or shower drains slowly', 'cause' => 'A clog in that fixture\'s trap or branch line, usually hair, grease or soap buildup.', 'slug' => 'drain-cleaning'],
    ['symptom' => 'Several drains back up at once, toilets gurgle, water rises in the lowest drain', 'cause' => 'A blockage in the main sewer line, often tree roots or a sagging or broken section of pipe.', 'slug' => 'sewer-line-repair'],
    ['symptom' => 'Sewage smell outside, or a soggy, extra-green strip of yard over the sewer line', 'cause' => 'A cracked or separated sewer pipe leaking underground.', 'slug' => 'sewer-line-repair'],
    ['symptom' => 'The water bill jumps with no change in use, or the meter moves with every fixture off', 'cause' => 'A hidden leak in a supply line: under the slab, inside a wall or in the yard.', 'slug' => 'leak-detection-repair'],
    ['symptom' => 'Ceiling or wall stains, a warm spot on the floor, the sound of running water', 'cause' => 'A leaking pipe inside the wall or floor. A warm spot points to a hot-water line.', 'slug' => 'leak-detection-repair'],
    ['symptom' => 'No water from a faucet after a hard freeze, or a leak once it thaws', 'cause' => 'A frozen supply line. Water expands as it freezes and can split the pipe.', 'slug' => 'leak-detection-repair'],
    ['symptom' => 'No hot water, rusty hot water, popping from the tank or water around its base', 'cause' => 'A failed burner or element, mineral sediment in the tank, or a corroded tank.', 'slug' => 'water-heater-repair-installation'],
];

// ---- FAQ: drawn from the research brief's customer questions only; no unverified claims ------------
$homeFaqs = [
    [
        'q' => 'Do you offer emergency plumbing service in Seminole?',
        'a' => 'Ledco Plumbing LLC takes calls for burst pipes, sewer backups and failed water heaters seven days a week, 7 AM to 5 PM. When water is actively leaking, call (405) 257-3096 rather than using the form, and close the main shutoff valve while you wait so the damage stops spreading.',
    ],
    [
        'q' => 'How much does a plumbing repair or water heater replacement cost?',
        'a' => 'The price of a plumbing repair depends on the problem, the parts and how hard the pipe or tank is to reach, so Ledco Plumbing gives you an estimate before work starts. A water heater replacement also depends on the tank size and whether the heater runs on gas or electricity.',
    ],
    [
        'q' => 'Why does my water heater wear out faster in Oklahoma?',
        'a' => 'Hard water is common in Oklahoma, and its minerals settle in the bottom of a water heater tank as scale. That layer makes the heater work harder and can shorten its life. Flushing the tank on a regular schedule helps, and a water softener or filter cuts down the minerals coming in.',
    ],
    [
        'q' => 'Which areas around Seminole do you serve?',
        'a' => 'Ledco Plumbing LLC serves Seminole and Wewoka from its office at 316 E Oak Ave in Seminole. If your home or business is elsewhere in Seminole County, call (405) 257-3096 or send the form with your address and the office will confirm whether a plumber can reach you.',
    ],
];

// ---- Schema: WebSite + WebPage + FAQPage (head.php adds the #organization Plumber node) ------------
$homeSiteBase = rtrim($siteUrl, '/');
$pageSchema = [
    [
        '@type'     => 'WebSite',
        '@id'       => schemaId('website'),
        'url'       => $homeSiteBase . '/',
        'name'      => $siteName,
        'publisher' => ['@id' => schemaId('organization')],
    ],
    [
        '@type'       => 'WebPage',
        '@id'         => $homeSiteBase . '/#webpage',
        'url'         => $homeSiteBase . '/',
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'isPartOf'    => ['@id' => schemaId('website')],
        'about'       => ['@id' => schemaId('organization')],
    ],
    generateFAQSchema($homeFaqs),
];
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   index.php — page composition (minimal-tech). framework.css owns the
   components; this block only composes them for the homepage. Tokens only.
   ============================================================================ */

/* ---- Headings: balanced wrap everywhere on this page ---- */
.home-hero h1, .home-hero h2, main h2, main h3, .symptom-table tbody th { text-wrap: balance; }
.home-faq .faq summary { text-wrap: balance; }

/* ---- Hero: typography-forward dark band, asymmetric accent glow + line grid (C1.3) ---- */
.home-hero {
  background:
    linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 100%);
}
.home-hero::before {
  content: "";
  position: absolute;
  inset: -25% -12% auto 48%;
  height: 150%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 30%, transparent), transparent 72%);
}
.home-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background-image:
    linear-gradient(color-mix(in srgb, var(--color-white) 6%, transparent) 1px, transparent 1px),
    linear-gradient(90deg, color-mix(in srgb, var(--color-white) 6%, transparent) 1px, transparent 1px);
  background-size: var(--space-3xl) var(--space-3xl);
  -webkit-mask-image: linear-gradient(105deg, transparent 35%, var(--color-black) 85%);
  mask-image: linear-gradient(105deg, transparent 35%, var(--color-black) 85%);
}
.home-hero .grain { opacity: .35; }
.home-hero .hero-title { max-width: 24ch; }
.home-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.home-hero .hero-answer { max-width: 34rem; }
.home-hero .hero-form-card {
  border-top: 3px solid var(--color-accent);
  position: relative;
}
.home-hero .hero-form .consent a { color: var(--color-primary); }
@media (max-width: 900px) {
  .home-hero .hero-text > .eyebrow { order: 0; }
  .home-hero .hero-text > .hero-title { order: 1; }
  .home-hero .hero-text > .hero-actions { order: 2; margin-top: 0; }
  .home-hero .hero-text > .hero-answer { order: 3; }
  .home-hero .hero-text > .hero-chips { order: 4; margin-top: 0; }
}
@media (max-width: 560px) {
  .home-hero .hero-text { gap: var(--space-md); }
  .home-hero .hero-answer { font-size: var(--fs-body); }
  .home-hero .hero-actions { gap: var(--space-sm); }
  .home-hero .hero-chips li { font-size: var(--font-size-xs); padding: var(--space-1) var(--space-sm) var(--space-1) var(--space-2); }
}

/* ---- Ticker: crisp, monochrome ---- */
.home-ticker .ticker-track svg { color: var(--color-accent-dark); }
.home-ticker .ticker-track > span + span::before {
  content: "";
  width: var(--space-1);
  height: var(--space-1);
  border-radius: var(--radius-full);
  background: var(--color-line);
  margin-right: var(--space-8);
}

/* ---- Services: icon-led tinted cards (no job photos supplied yet) + featured 2x2 tile ---- */
.home-services { background: var(--color-paper); }
.home-services .section-title { max-width: 64ch; }
.home-services .hero-answer { color: var(--color-ink-2); max-width: 62ch; }
.home-services .service-card-with-image { border-color: color-mix(in srgb, var(--color-ink) 10%, transparent); }
.home-services .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); gap: var(--space-sm); }
.home-services .service-card__icon {
  width: var(--space-12);
  height: var(--space-12);
  background: var(--color-surface);
  color: var(--color-accent-dark);
  box-shadow: var(--shadow-sm);
  border: 1px solid var(--color-line);
}
.home-services .service-card-with-image:hover .service-card__icon { color: var(--color-surface); background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.home-services .service-card__icon svg { transition: transform var(--transition); }
.home-services .service-card-with-image:hover .service-card__icon svg { transform: rotate(-8deg) scale(1.06); }
.home-services button.service-card__cta { background: none; border: 0; padding: var(--space-2) 0 0; font: inherit; font-size: var(--fs-small); font-weight: 600; color: var(--color-primary); cursor: pointer; }

/* Featured tile: dark, type-led, label top-right so it never sits on the icon */
.home-services .services-grid--featured > :first-child {
  display: flex;
  background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-primary-deep) 120%);
  color: var(--color-white);
  border-color: transparent;
  isolation: isolate;
}
.home-services .services-grid--featured > :first-child[data-featured-label]::after { left: auto; right: var(--space-lg); top: var(--space-lg); color: var(--color-white); background: var(--color-accent-dark); }
.home-services .services-grid--featured > :first-child .service-card__body { display: flex; flex-direction: column; justify-content: flex-end; padding: var(--space-xl); }
.home-services .services-grid--featured > :first-child .service-card__icon { margin-bottom: auto; width: var(--space-16); height: var(--space-16); }
.home-services .services-grid--featured > :first-child .service-card__icon svg { width: var(--space-8); height: var(--space-8); }
.home-services .services-grid--featured > :first-child h3 { margin-top: var(--space-2xl); }
.home-services .services-grid--featured > :first-child h3 { color: var(--color-white); font-size: var(--fs-h2); }
.home-services .services-grid--featured > :first-child .service-card__desc { color: color-mix(in srgb, var(--color-white) 82%, transparent); font-size: var(--fs-lead); max-width: 34ch; }
.home-services .services-grid--featured > :first-child ul { border-top-color: color-mix(in srgb, var(--color-white) 18%, transparent); }
.home-services .services-grid--featured > :first-child ul li { color: color-mix(in srgb, var(--color-white) 86%, transparent); font-size: var(--fs-body); }
.home-services .services-grid--featured > :first-child ul li::before { color: var(--color-accent-bright); }
.home-services .services-grid--featured > :first-child .service-card__cta,
.home-services .services-grid--featured > :first-child button.service-card__cta { color: var(--color-accent-bright); font-size: var(--fs-body); }
.home-services .services-grid--featured > :first-child .service-card__icon { background: color-mix(in srgb, var(--color-white) 10%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-accent-bright); box-shadow: none; }
.home-services .featured-drop {
  position: absolute;
  right: -8%;
  top: -6%;
  width: 68%;
  aspect-ratio: 1;
  z-index: -1;
  color: color-mix(in srgb, var(--color-accent) 22%, transparent);
  pointer-events: none;
}
.home-services .featured-drop svg { width: 100%; height: 100%; stroke-width: .6; }
@media (max-width: 1000px) { .home-services .featured-drop { width: 42%; top: -10%; } }
.home-services .services-foot { display: flex; justify-content: center; margin-top: var(--space-xl); }
@media (max-width: 1000px) {
  .home-services .services-grid { grid-template-columns: 1fr 1fr; }
  .home-services .services-grid--featured > :first-child { grid-column: span 2; grid-row: auto; }
}
@media (max-width: 560px) {
  .home-services .services-grid { grid-template-columns: 1fr; }
  .home-services .services-grid--featured > :first-child { grid-column: auto; }
  .home-services .services-grid--featured > :first-child .service-card__body { padding: var(--space-3xl) var(--space-lg) var(--space-lg); }
}

/* ---- Proof strip: dark band, slant edge, accent-face facts ---- */
.home-proof.stats-band {
  background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 130%);
  color: var(--color-white);
  border: 0;
}
.home-proof .stat-item { border-left-color: color-mix(in srgb, var(--color-white) 14%, transparent); }
.home-proof .stat-number { color: var(--color-white); font-size: clamp(1.5rem, 1.1rem + 1.2vw, 2.1rem); text-transform: uppercase; }
.home-proof .stat-number span { color: var(--color-accent-bright); }
.home-proof .stat-label { color: color-mix(in srgb, var(--color-white) 74%, transparent); }
.home-proof .stat-label a { color: inherit; text-underline-offset: .2em; }
.home-proof .stat-label a:hover { color: var(--color-white); }

/* ---- Symptom guide (signature, C7 full-bleed typography moment) ---- */
.home-symptoms { background: var(--color-surface); }
.home-symptoms .symptoms-layout { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 2fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.home-symptoms .symptoms-intro { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); display: grid; gap: var(--space-md); }
.home-symptoms .symptoms-intro p { margin: 0; color: var(--color-ink-2); }
.home-symptoms .symptoms-note {
  display: flex;
  gap: var(--space-sm);
  align-items: flex-start;
  padding: var(--space-md);
  border-radius: var(--radius);
  background: var(--color-card-tint-3);
  font-size: var(--fs-small);
  color: var(--color-ink-2);
}
.home-symptoms .symptoms-note svg { color: var(--color-accent-dark); flex: 0 0 auto; margin-top: var(--space-1); }
.symptom-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); counter-reset: sym; }
.symptom-table caption { text-align: left; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); padding-bottom: var(--space-sm); }
.symptom-table thead th { text-align: left; font-family: var(--font-accent); font-weight: 700; font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); padding: var(--space-sm) var(--space-md); border-bottom: 2px solid var(--color-ink); }
.symptom-table tbody tr { counter-increment: sym; transition: background-color var(--transition); }
.symptom-table tbody tr:hover { background: var(--color-paper); }
.symptom-table tbody th,
.symptom-table tbody td { padding: var(--space-md); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.symptom-table tbody th { font-family: var(--font-heading); font-weight: 700; font-size: var(--fs-body); color: var(--color-ink); width: 38%; }
.symptom-table tbody th::before { content: counter(sym, decimal-leading-zero); display: block; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; color: var(--color-accent-dark); margin-bottom: var(--space-1); }
.symptom-table td { color: var(--color-ink-2); }
.symptom-table td.symptom-service { width: 24%; }
.symptom-table .symptom-link { display: inline-flex; align-items: center; gap: var(--space-2); font-weight: 600; color: var(--color-primary); text-decoration: none; border-bottom: 2px solid var(--color-accent); padding-bottom: var(--space-1); }
.symptom-table .symptom-link svg { transition: transform var(--transition); }
.symptom-table .symptom-link:hover svg { transform: translateX(var(--space-1)); }
@media (max-width: 1000px) {
  .home-symptoms .symptoms-layout { grid-template-columns: 1fr; }
  .home-symptoms .symptoms-intro { position: static; }
}
@media (max-width: 700px) {
  .symptom-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .symptom-table, .symptom-table tbody, .symptom-table tr, .symptom-table th, .symptom-table td { display: block; width: 100%; }
  .symptom-table tbody tr { padding: var(--space-md) 0; border-bottom: 1px solid var(--color-line); }
  .symptom-table tbody th, .symptom-table tbody td { border: 0; padding: var(--space-1) 0; }
  .symptom-table caption { display: block; width: 100%; }
  .symptom-table tbody th, .symptom-table td.symptom-service { width: 100%; }
  .symptom-table td.symptom-service { padding-top: var(--space-2); }
}

/* ---- About / process: the page's asymmetric section ---- */
.home-about { background: var(--color-paper); }
.home-about .about-split { grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); align-items: start; }
.home-about .about-left { display: grid; gap: var(--space-md); }
.home-about .about-left > p { margin: 0; color: var(--color-ink-2); max-width: var(--measure); }
.home-about .process-steps { margin-top: var(--space-lg); }
.home-about .process-steps li { padding: var(--space-md); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius); }
.home-about .about-right { margin-top: var(--space-4xl); }
.home-about .about-right::before {
  content: "";
  position: absolute;
  inset: calc(-1 * var(--space-6)) var(--space-6) var(--space-6) calc(-1 * var(--space-6));
  border: 2px solid var(--color-accent);
  border-radius: var(--radius-lg);
  opacity: .55;
  z-index: 0;
}
.home-about .about-map {
  position: relative;
  z-index: 1;
  aspect-ratio: 4 / 4.6;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-lg);
  background: var(--color-paper-2);
  clip-path: polygon(0 0, 100% 0, 100% 90%, 88% 100%, 0 100%);
}
.home-about .about-map iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; filter: grayscale(.85) contrast(1.05); }
.home-about .about-map__fallback { position: absolute; inset: 0; display: grid; place-content: center; justify-items: center; gap: var(--space-2); text-align: center; color: var(--color-muted); font-size: var(--fs-small); background-image: linear-gradient(var(--color-line) 1px, transparent 1px), linear-gradient(90deg, var(--color-line) 1px, transparent 1px); background-size: var(--space-8) var(--space-8); }
.home-about .about-map__fallback svg { color: var(--color-accent-dark); }
.home-about .about-stat-card { display: grid; gap: var(--space-1); max-width: 17rem; }
.home-about .about-stat-card b { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.home-about .about-stat-card span { font-family: var(--font-heading); font-weight: 700; color: var(--color-ink); line-height: 1.3; }
.home-about .about-stat-card a { font-size: var(--fs-small); font-weight: 600; color: var(--color-primary); display: inline-flex; align-items: center; gap: var(--space-1); }
@media (max-width: 900px) {
  .home-about .about-split { grid-template-columns: 1fr; }
  .home-about .about-right { margin: var(--space-xl) var(--space-lg) var(--space-xl) var(--space-xl); }
  .home-about .about-map { aspect-ratio: 4 / 3; }
}

/* ---- Shut-off CTA band: dark, grain, wave edge ---- */
.home-cta.cta-banner { color: var(--color-white); }
.home-cta .cta-inner { display: grid; gap: var(--space-md); justify-items: center; text-align: center; }
.home-cta .cta-inner p { margin: 0; max-width: 56ch; }
.home-cta .cta-inner .actions { justify-content: center; margin-top: var(--space-sm); }
.home-cta .cta-valve { width: var(--space-16); height: var(--space-16); display: grid; place-items: center; border-radius: var(--radius-full); border: 1px solid color-mix(in srgb, var(--color-white) 22%, transparent); color: var(--color-accent-bright); }
.home-cta .cta-valve svg { animation: valve-turn 6s var(--ease) infinite; }
@keyframes valve-turn { 0%, 70% { transform: rotate(0); } 85%, 100% { transform: rotate(90deg); } }

/* ---- Reviews band (feed-gated; light, never inside a reveal) ---- */
.home-reviews { background: var(--color-paper-2); }

/* ---- FAQ ---- */
.home-faq { background: var(--color-paper); }
.home-faq .faq summary { transition: color var(--transition); }
.home-faq .faq summary:hover { color: var(--color-accent-dark); }
.home-faq .faq[open] { border-top-color: var(--color-accent); }

/* ---- Estimate section: curved edge, form card + what-happens-next rail ---- */
.home-estimate { background: var(--color-surface); }
.home-estimate .card { display: grid; gap: var(--space-md); border-top: 3px solid var(--color-accent); }
.home-estimate .card h2 { margin: 0; }
.home-estimate .estimate-aside { display: grid; gap: var(--space-sm); padding-top: var(--space-md); }
.home-estimate .estimate-aside h3 { margin: 0; }
.home-estimate .estimate-area { margin: var(--space-md) 0 0; font-size: var(--fs-small); color: var(--color-muted); }
.home-estimate .form-consent-fieldset { border: 0; padding: 0; margin: 0; display: grid; gap: var(--space-1); }
.home-estimate .consent input[type="checkbox"] { width: var(--space-5); height: var(--space-5); min-height: 0; padding: 0; margin-top: var(--space-1); }
</style>

<!-- ============================================================ HERO -->
<section class="hero hero--type home-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-text">
        <span class="eyebrow"><?php echo esc($homeCity . ', ' . $homeState); ?> &middot; <?php echo esc($companyCounty); ?> County</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Drain cleaning</span> &amp; plumbing repair in <?php echo esc($homeCity); ?>, <?php echo esc($homeState); ?></h1>
        <p class="hero-answer">Ledco Plumbing LLC is a Seminole, Oklahoma plumber for clogged drains, water heaters, hidden leaks and broken sewer lines. The company handles repair and new installation work in homes, shops and offices across Seminole and Wewoka.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($homePhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($homePhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('map-pin', 16); ?> Seminole &amp; Wewoka</li>
          <li><?php icon('building-2', 16); ?> Homes &amp; businesses</li>
          <li><?php icon('clock', 16); ?> Open 7 days a week</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Get a free estimate</h2>
        <p class="hero-form-tagline">No obligation. Tell us the problem and we will call you back.</p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form" id="hero-form">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Get my free estimate</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<!-- ============================================================ TICKER -->
<div class="ticker-strip home-ticker" aria-hidden="true">
  <div class="ticker-track">
<?php
$homeTicker = [
    ['droplets', 'Drain cleaning'], ['flame', 'Water heater repair'], ['wrench', 'Water heater installation'],
    ['search', 'Leak detection'], ['waves', 'Sewer line repair'], ['building-2', 'Commercial plumbing'],
    ['map-pin', 'Seminole, OK'], ['map-pin', 'Wewoka, OK'], ['clock', 'Open Mon–Sun'],
];
for ($homeLoop = 0; $homeLoop < 2; $homeLoop++):
    foreach ($homeTicker as $homeTick): ?>
    <span><?php icon($homeTick[0], 16); ?><?php echo esc($homeTick[1]); ?></span>
<?php endforeach; endfor; ?>
  </div>
</div>

<!-- ============================================================ SERVICES -->
<section class="section home-services" id="services" aria-label="Plumbing services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which plumbing problems does <span class="text-accent">Ledco Plumbing</span> fix in <span class="text-accent">Seminole</span>?</h2>
      <p class="hero-answer">Ledco Plumbing LLC handles five kinds of plumbing work in Seminole and Wewoka: drain cleaning, water heater repair and installation, leak detection and repair, sewer line repair, and commercial plumbing. If you are not sure which one fits, the symptom guide below matches common warning signs to the right service.</p>
    </div>

    <div class="services-grid services-grid--featured">
<?php
$homeTint = 0;
foreach ($services as $homeIdx => $homeSvc):
    $homeCopy  = $homeServiceCopy[$homeSvc['slug']] ?? ['icon' => 'wrench', 'desc' => $homeSvc['description'], 'bullets' => []];
    $homeTint  = ($homeIdx % 3) + 1;
    $homeIsLive = serviceLive($homeSvc['slug']);
    $homeRevealDir = $homeIdx === 0 ? 'reveal-left' : 'reveal-up';
?>
      <article class="service-card-with-image card-tint-<?php echo $homeTint; ?> <?php echo $homeRevealDir; ?> reveal-delay-<?php echo $homeTint; ?>"<?php echo $homeIdx === 0 ? ' data-featured-label="Featured service"' : ''; ?>>
<?php if ($homeIdx === 0): ?>
        <span class="featured-drop" aria-hidden="true"><?php icon('droplets', 320); ?></span>
<?php endif; ?>
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($homeCopy['icon'], 24); ?></div>
          <h3><?php echo esc($homeSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo esc($homeCopy['desc']); ?></p>
          <ul>
<?php foreach ($homeCopy['bullets'] as $homeBullet): ?>
            <li><?php echo esc($homeBullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($homeIsLive): ?>
          <a href="/services/<?php echo esc($homeSvc['slug']); ?>/" class="service-card__cta">Learn more<span class="sr-only"> about <?php echo esc(strtolower($homeSvc['name'])); ?></span></a>
<?php else: ?>
          <button type="button" class="service-card__cta" data-open-estimate>Get an estimate<span class="sr-only"> for <?php echo esc(strtolower($homeSvc['name'])); ?></span></button>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>

<?php if (pageLive('/services/')): ?>
    <div class="services-foot reveal-up">
      <a href="/services/" class="btn btn-secondary">View All Services <?php icon('arrow-right', 18); ?></a>
    </div>
<?php endif; ?>
  </div>
</section>

<!-- ============================================================ PROOF STRIP -->
<section class="stats-band texture-grain slant-top home-proof" aria-label="About Ledco Plumbing at a glance">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="stats-row reveal-scale">
      <div class="stat-item">
        <span class="stat-number">Mickey <span>Ledbetter</span></span>
        <span class="stat-label">Owner, <?php echo esc($siteName); ?></span>
      </div>
      <div class="stat-item">
        <span class="stat-number">E Oak <span>Ave</span></span>
        <span class="stat-label">Office at <?php echo esc($address['street']); ?>, <?php echo esc($homeCity); ?></span>
      </div>
      <div class="stat-item">
        <span class="stat-number"><?php echo count($services); ?> <span>Services</span></span>
        <span class="stat-label">Drains, water heaters, leaks, sewer, commercial</span>
      </div>
      <div class="stat-item">
        <span class="stat-number">On <span>Google</span></span>
        <span class="stat-label"><a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">Ledco Plumbing on Google Maps</a></span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ SYMPTOM GUIDE (signature) -->
<section class="section home-symptoms" id="symptoms" aria-labelledby="symptoms-title">
  <div class="container-wide">
    <div class="symptoms-layout">
      <div class="symptoms-intro reveal-left">
        <span class="eyebrow-label">Symptom guide</span>
        <h2 id="symptoms-title">Which <span class="text-accent">plumbing service</span> does your problem need?</h2>
        <p>The warning sign usually tells you where the problem is. A single slow drain points to that fixture, while several drains backing up at once points to the main sewer line. Use this table to match what you are seeing in your Seminole home or business to the Ledco Plumbing service that fixes it.</p>
        <p class="symptoms-note"><?php icon('snowflake', 18); ?><span>Oklahoma gets hard freezes most winters. Pipes on outside walls, in crawl spaces and on hose bibs are the first to split.</span></p>
      </div>

      <div class="symptoms-table-wrap reveal-right">
        <table class="symptom-table">
          <caption>Common plumbing symptoms and the Ledco Plumbing service for each</caption>
          <thead>
            <tr>
              <th scope="col">What you see</th>
              <th scope="col">What it usually means</th>
              <th scope="col">Service</th>
            </tr>
          </thead>
          <tbody>
<?php foreach ($homeSymptoms as $homeSym):
    $homeSymName = '';
    foreach ($services as $homeSymSvc) { if ($homeSymSvc['slug'] === $homeSym['slug']) { $homeSymName = $homeSymSvc['name']; break; } }
?>
            <tr>
              <th scope="row"><?php echo esc($homeSym['symptom']); ?></th>
              <td><?php echo esc($homeSym['cause']); ?></td>
              <td class="symptom-service">
<?php if (serviceLive($homeSym['slug'])): ?>
                <a class="symptom-link" href="/services/<?php echo esc($homeSym['slug']); ?>/"><?php echo esc($homeSymName); ?> <?php icon('arrow-right', 14); ?></a>
<?php else: ?>
                <span class="symptom-link"><?php echo esc($homeSymName); ?></span>
<?php endif; ?>
              </td>
            </tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ ABOUT / PROCESS (asymmetric) -->
<section class="section home-about" id="about" aria-labelledby="about-title">
  <div class="container">
    <div class="about-split">
      <div class="about-left reveal-left">
        <span class="eyebrow-label">About Ledco Plumbing</span>
        <h2 id="about-title">Who runs <span class="text-accent">Ledco Plumbing</span> in Seminole?</h2>
        <p>Ledco Plumbing LLC is a Seminole plumbing company owned by Mickey Ledbetter, with an office at 316 E Oak Ave. The company works on homes and businesses in Seminole and Wewoka, and its five services run from a single stopped-up sink to a broken sewer line.</p>
        <p>Seminole grew quickly during the oil boom of the late 1920s, so older houses stand alongside newer homes and commercial buildings across town. Older plumbing, such as cast-iron drains and galvanized supply pipe, is a common source of slow drains and hidden leaks, which is why each job starts with a look at the actual pipe before any repair is priced.</p>

        <h3>How a Ledco Plumbing job works</h3>
        <ol class="process-steps">
          <li><b>Call or send the form</b><span>Call <?php echo esc($homePhone); ?> or use the estimate form and describe what you are seeing.</span></li>
          <li><b>A plumber looks at it</b><span>The drain, line, leak or water heater is checked at your home or business.</span></li>
          <li><b>You approve the price</b><span>You see the estimate before any work starts.</span></li>
          <li><b>Repair and test</b><span>The repair is made, then the water is run to check it.</span></li>
        </ol>
      </div>

      <div class="about-right reveal-right">
        <div class="about-map">
          <div class="about-map__fallback" aria-hidden="true"><?php icon('map-pin', 36); ?><span><?php echo esc($address['street'] . ', ' . $homeCity); ?></span></div>
          <iframe src="<?php echo esc($gbp['embed_src']); ?>" title="Map of Ledco Plumbing LLC at <?php echo esc($address['street'] . ', ' . $homeCity . ', ' . $homeState); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        </div>
        <div class="about-stat-card">
          <b>Seminole office</b>
          <span><?php echo esc($address['street']); ?><br><?php echo esc($homeCity . ', ' . $homeState . ' ' . $address['zip']); ?></span>
          <a href="<?php echo esc($gbp['directions']); ?>" target="_blank" rel="noopener">Get directions <?php icon('arrow-right', 14); ?></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ CTA BAND -->
<section class="cta-banner texture-grain edge-wave-top home-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container-narrow">
    <div class="cta-inner reveal-scale">
      <span class="cta-valve" aria-hidden="true"><?php icon('wrench', 28); ?></span>
      <span class="eyebrow-label">Water where it should not be?</span>
      <h2 id="cta-title">Shut off the main valve first, then call Ledco Plumbing</h2>
      <p>Most homes have a main shutoff valve where the water line enters the house, or in the meter box near the street. Closing it stops a burst pipe or a failed water heater from doing more damage while a plumber is on the way.</p>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo esc($homePhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($homePhone); ?></a>
        <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ GOOGLE REVIEWS (Page One feed; renders only when real reviews exist) -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$homeReviews = p1_google_reviews($slug, ['heading' => 'What ' . $homeCity . ' customers say on Google']);
if ($homeReviews !== ''): ?>
<section class="section home-reviews" aria-label="Google reviews"><div class="container"><?php echo $homeReviews; ?></div></section>
<?php endif; ?>

<!-- ============================================================ FAQ -->
<section class="section home-faq" id="faq" aria-labelledby="faq-title">
  <div class="container-wide">
    <div class="section-title reveal-down">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">What do <span class="text-accent">Seminole</span> customers ask a plumber first?</h2>
      <p>Seminole customers usually ask a plumber about emergency calls, cost, hard water and service area before they book. Ledco Plumbing LLC answers those four questions here; call the office for anything else.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($homeFaqs as $homeFaqIdx => $homeFaq): ?>
      <details class="faq"<?php echo $homeFaqIdx < 2 ? ' open' : ''; ?>>
        <summary><?php echo esc($homeFaq['q']); ?></summary>
        <p><?php echo esc($homeFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ ESTIMATE SECTION -->
<section class="section edge-curve-top home-estimate" id="estimate" aria-labelledby="estimate-title">
  <div class="container">
    <div class="estimate">
      <div class="card reveal-left">
        <span class="eyebrow-label">Free estimate</span>
        <h2 id="estimate-title">Tell us about the job</h2>
        <form class="estimate-form" action="<?php echo esc($formAction); ?>" method="POST" id="estimate-section-form">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="_next" value="<?php echo esc($siteUrl); ?>/thank-you">
          <input type="hidden" name="form_location" value="estimate-section">
          <?php echo p1_attribution_fields('estimate-section'); ?>
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
          <div class="form-grid">
            <div class="field">
              <label for="est-name">Your name *</label>
              <input id="est-name" type="text" name="name" required autocomplete="name">
            </div>
            <div class="field">
              <label for="est-phone">Phone *</label>
              <input id="est-phone" type="tel" name="phone" required autocomplete="tel" inputmode="tel">
            </div>
            <div class="field">
              <label for="est-email">Email *</label>
              <input id="est-email" type="email" name="email" required autocomplete="email">
            </div>
            <div class="field">
              <label for="est-service">Service needed</label>
              <select id="est-service" name="service"><?php echo p1_service_options(); ?></select>
            </div>
            <div class="field full">
              <label for="est-message">What is happening? (optional)</label>
              <textarea id="est-message" name="message" rows="4"></textarea>
            </div>
          </div>

          <fieldset class="form-consent-fieldset">
            <legend class="form-consent-legend sr-only">Communication consent</legend>
            <label class="consent" for="est-email-optin">
              <input id="est-email-optin" type="checkbox" name="email_opt_in" value="yes">
              <span><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry and services. I can unsubscribe at any time by using the link in any email or by emailing <?php echo esc($contactEmail); ?>.</span>
            </label>
            <label class="consent" for="est-sms-optin">
              <input id="est-sms-optin" type="checkbox" name="sms_opt_in" value="yes">
              <span><strong>Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the number I provided. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. Consent is not a condition of purchase.</span>
            </label>
            <?php echo p1_consent_row('est'), "\n"; ?>
          </fieldset>

          <button class="btn btn-primary btn-lg btn-block" type="submit">Send my request</button>
        </form>
      </div>

      <div class="estimate-aside reveal-right">
        <h3>What happens next</h3>
        <ol class="next-steps">
          <li><strong>You send the form</strong>Your name, phone, email and a line about the problem is enough to start.</li>
          <li><strong>Ledco Plumbing calls you back</strong>Expect a few questions about what you are seeing, then a time that works for you.</li>
          <li><strong>Clear the work area</strong>Empty the cabinet under the sink or the space around the water heater so the plumber can reach it.</li>
        </ol>
        <div class="nap">
          <div><?php icon('phone', 18); ?><a href="<?php echo esc($homePhoneHref); ?>"><?php echo esc($homePhone); ?></a></div>
          <div><?php icon('mail', 18); ?><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></div>
          <div><?php icon('map-pin', 18); ?><span><?php echo esc($address['street'] . ', ' . $homeCity . ', ' . $homeState . ' ' . $address['zip']); ?></span></div>
        </div>
        <p class="estimate-area">Ledco Plumbing LLC serves homes and businesses in
<?php
$homeAreaParts = [];
foreach ($serviceAreaDetails as $homeArea) {
    $homeAreaLink = areaHref($homeArea['slug']);
    $homeAreaLabel = esc($homeArea['city'] . ', ' . $homeArea['state']);
    $homeAreaParts[] = $homeAreaLink ? '<a href="' . esc($homeAreaLink) . '">' . $homeAreaLabel . '</a>' : $homeAreaLabel;
}
echo implode(' and ', $homeAreaParts);
?>.</p>
      </div>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
