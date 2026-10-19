<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * service-areas/seminole-ok/index.php — Seminole, OK area page (Phase 6, minimal-tech).
 *
 * Opening angle: the 1926 oil-boom town and what a building that old asks of its plumbing.
 * Conditions emphasis: boom-era pipe, freeze, wet ground, downtown + college commercial.
 * Section script: type hero + form → boom-era buildings (asymmetric, big number) → local-facts table (signature)
 *   → five services through a Seminole lens → why Ledco (dark) → FAQ → Wewoka neighbor → closing CTA.
 *
 * RESEARCH (2026-10-19). Sources:
 *   https://en.wikipedia.org/wiki/Seminole,_Oklahoma  (platting, 854 -> est. 25,000-30,000 after 1926, 2020 pop 7,146,
 *       NRHP list, ZIPs 74818/74868, school districts, highways, NOAA 1991-2020 normals, Sportsman Lake, Wewoka Lake)
 *   https://npgallery.nps.gov/AssetDetail/NRIS/86001094  (Home Stake Oil and Gas Company Building, 315 E Broadway, 1927-28)
 *   https://aoghs.org/petroleum-pioneers/seminole-oil-boom/  (Fixico No. 1, July 16, 1926; Greater Seminole field)
 *   https://en.wikipedia.org/wiki/Strother_Memorial_Chapel  (Gothic Revival chapel, 1928, Maple Grove Cemetery)
 *   https://phzmapi.org/74868.json  (USDA 2023 hardiness zone by ZIP: 7b, 5 to 10 F)
 *   https://www.okhistory.org/publications/enc/entry?entry=SE012  (Oklahoma Historical Society, "Seminole")
 * Elevation: sources conflict (Wikipedia 938 ft, TopoQuest 951 ft at Seminole State College, Weather Underground
 *   942 ft, usclimatedata 896 ft; range roughly 900 to 950 ft). Not used in the copy: nothing source-backed ties it to plumbing.
 * Not claimed: flat terrain, "oldest commercial buildings", mailing addresses outside city limits (none of it in the sources).
 * Dropped: the city water system (no confirmed source), soil type (no Seminole County data retrieved), the 2022 tornado
 *   (not a plumbing fact), any claim about jobs Ledco has done here (company facts only: office, owner, hours, services).
 * Distance to Wewoka: ~10.7 mi straight line between the two Wikipedia coordinate pairs, written as "about 10 miles".
 */
$areaSlug = 'seminole-ok';

$pageTitle       = 'Plumber in Seminole, OK | Ledco Plumbing LLC';
$pageDescription = 'Ledco Plumbing LLC, 316 E Oak Ave, Seminole, OK: drain cleaning, water heaters, leak detection, sewer lines and commercial plumbing. Open 7 days.';
$canonicalUrl    = $siteUrl . '/service-areas/seminole-ok/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'areas/seminole-ok';
$pageType        = 'city';
$citySlug        = $areaSlug;

$saPhone     = formatPhone($phone);
$saPhoneHref = phoneHref($phone);

$faqs = [
    [
        'q' => 'Does Ledco Plumbing serve every address in Seminole?',
        'a' => 'Ledco Plumbing LLC works from its office at 316 E Oak Ave in Seminole and lists Seminole and Wewoka as its service areas. Seminole uses two ZIP codes, 74818 and 74868, and parts of the city lie in the Varnum, Butner and New Lima school districts, so give the office your street address at ' . $saPhone . ' and it will confirm whether the address is covered.',
    ],
    [
        'q' => 'Can freezing weather damage plumbing in Seminole?',
        'a' => 'Yes. Seminole\'s January lows average about 26 degrees Fahrenheit, and a hard freeze can split pipes in an exterior wall, a crawl space or an outdoor hose bib. Shutting off the main valve stops the flow while you call Ledco Plumbing at ' . $saPhone . '.',
    ],
];

$pageSchema = generateAreaPageSchema(
    ['name' => 'Seminole', 'slug' => $areaSlug, 'lat' => 35.235, 'lng' => -96.6494, 'sameAs' => 'https://en.wikipedia.org/wiki/Seminole,_Oklahoma'],
    $pageTitle, $pageDescription
);
if ($faqs) $pageSchema[] = generateFAQSchema($faqs);   // FAQPage mirrors the visible FAQ exactly
$schemaMarkup = $pageSchema;

$heroFormTitle   = 'Free estimate in Seminole';
$heroFormTagline = 'Tell us what is going on at your Seminole address and Ledco Plumbing will call you back.';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   service-areas/seminole-ok — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.sem-page h1, .sem-page h2, .sem-page h3, .sem-table tbody th { text-wrap: balance; }
.sem-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, a "boom-era derrick grid" of fine rules (C1 layered) ---- */
.sem-hero { background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-dark-alt) 58%, var(--color-primary-deep) 100%); }
.sem-hero::before {
  content: "";
  position: absolute;
  inset: 0 0 0 50%;
  z-index: -1;
  pointer-events: none;
  background:
    repeating-linear-gradient(60deg, transparent 0 var(--space-2xl), color-mix(in srgb, var(--color-white) 6%, transparent) var(--space-2xl) calc(var(--space-2xl) + 1px)),
    repeating-linear-gradient(120deg, transparent 0 var(--space-2xl), color-mix(in srgb, var(--color-white) 6%, transparent) var(--space-2xl) calc(var(--space-2xl) + 1px));
  -webkit-mask-image: linear-gradient(100deg, transparent 5%, var(--color-black) 70%);
  mask-image: linear-gradient(100deg, transparent 5%, var(--color-black) 70%);
}
.sem-hero::after {
  content: "";
  position: absolute;
  inset: -25% -10% auto 55%;
  height: 120%;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 24%, transparent), transparent 72%);
}
.sem-hero .grain { opacity: .3; }
.sem-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.sem-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.sem-hero .breadcrumb a:hover, .sem-hero .breadcrumb [aria-current] { color: var(--color-white); }
.sem-hero .hero-title { max-width: 22ch; }
.sem-hero .hero-answer { max-width: 36rem; }
.sem-hero .hero-form-card { border-top: 3px solid var(--color-accent); }
.sem-hero .hero-form .consent a { color: var(--color-primary); }
.sem-hero .link-call { color: var(--color-white); }
@media (max-width: 560px) {
  .sem-hero .hero-answer { font-size: var(--fs-body); }
  .sem-hero .hero-chips li { font-size: var(--font-size-xs); }
}

/* ---- Boom-era buildings: asymmetric article + big-number card ---- */
.sem-boom { background: var(--color-paper); }
.sem-boom__grid { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.sem-boom__body { display: grid; gap: var(--space-md); }
.sem-boom__body > p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.sem-boom__body a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.sem-boom__card {
  position: relative;
  margin-top: var(--space-3xl);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-primary-deep) 130%);
  color: var(--color-white);
  box-shadow: var(--shadow-lg);
  overflow: hidden;
  isolation: isolate;
  display: grid;
  gap: var(--space-sm);
}
.sem-boom__card::after {
  content: "";
  position: absolute;
  inset: auto calc(-1 * var(--space-2xl)) calc(-1 * var(--space-2xl)) auto;
  width: 65%;
  aspect-ratio: 1;
  border-radius: var(--radius-full);
  border: var(--space-2) solid color-mix(in srgb, var(--color-accent) 30%, transparent);
  z-index: -1;
}
.sem-boom__card .eyebrow-label { color: var(--color-accent-bright); }
.sem-boom__num { font-family: var(--font-heading); font-weight: 700; line-height: 1; font-size: clamp(2.6rem, 2rem + 2.6vw, 4.2rem); color: var(--color-accent-bright); }
.sem-boom__num small { display: block; margin-top: var(--space-2); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-white); }
.sem-boom__card p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 84%, transparent); }
@media (max-width: 900px) {
  .sem-boom__grid { grid-template-columns: 1fr; }
  .sem-boom__card { margin-top: 0; }
}

/* ---- Local facts table (signature) ---- */
.sem-facts { background: var(--color-paper-2); }
.sem-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); box-shadow: var(--shadow); }
.sem-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); }
.sem-table caption { text-align: left; padding: var(--space-md) var(--space-lg) 0; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.sem-table thead th { text-align: left; padding: var(--space-md) var(--space-lg); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); border-bottom: 2px solid var(--color-ink); }
.sem-table tbody th, .sem-table tbody td { padding: var(--space-md) var(--space-lg); border-bottom: 1px solid var(--color-line); vertical-align: top; text-align: left; }
.sem-table tbody tr:last-child th, .sem-table tbody tr:last-child td { border-bottom: 0; }
.sem-table tbody th { font-family: var(--font-heading); font-size: var(--fs-body); color: var(--color-ink); width: 34%; }
.sem-table tbody th svg { color: var(--color-accent-dark); vertical-align: -.15em; margin-right: var(--space-2); }
.sem-table td { color: var(--color-ink-2); }
.sem-table tbody tr { transition: background-color var(--transition); }
.sem-table tbody tr:hover { background: var(--color-paper); }
.sem-table tr.sem-table__key { background: var(--color-card-tint-3); }
.sem-table a { color: var(--color-primary); font-weight: 600; }
.sem-facts__note { margin: var(--space-md) 0 0; font-size: var(--fs-small); color: var(--color-muted); }
@media (max-width: 760px) {
  .sem-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .sem-table, .sem-table tbody, .sem-table tr, .sem-table th, .sem-table td { display: block; width: 100%; }
  .sem-table tbody tr { padding: var(--space-md) var(--space-lg); border-bottom: 1px solid var(--color-line); }
  .sem-table tbody th, .sem-table tbody td { padding: var(--space-1) 0; border: 0; }
  .sem-table td[data-label]::before { content: attr(data-label) ": "; font-weight: 700; color: var(--color-ink); }
}

/* ---- Services through a Seminole lens: numbered rows ---- */
.sem-services { background: var(--color-surface); }
.sem-services__layout { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.6fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.sem-services__intro { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.sem-svc-list { margin: 0; padding: 0; list-style: none; display: grid; gap: var(--space-md); counter-reset: sem-svc; }
.sem-svc-list li { counter-increment: sem-svc; position: relative; padding: var(--space-lg) var(--space-lg) var(--space-lg) var(--space-4xl); border-radius: var(--radius-lg); border: 1px solid var(--color-line); transition: transform var(--transition), box-shadow var(--transition); }
.sem-svc-list li:nth-child(3n+1) { background: var(--color-card-tint-1); }
.sem-svc-list li:nth-child(3n+2) { background: var(--color-card-tint-2); }
.sem-svc-list li:nth-child(3n) { background: var(--color-card-tint-3); }
.sem-svc-list li:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow); }
.sem-svc-list li::before { content: counter(sem-svc, decimal-leading-zero); position: absolute; left: var(--space-lg); top: var(--space-lg); font-family: var(--font-accent); font-size: var(--fs-h3); letter-spacing: .08em; color: var(--color-accent-dark); }
.sem-svc-list h3 { margin: 0 0 var(--space-1); font-size: var(--fs-h3); }
.sem-svc-list h3 a { color: var(--color-ink); }
.sem-svc-list h3 a:hover { color: var(--color-accent-dark); }
.sem-svc-list p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) {
  .sem-services__layout { grid-template-columns: 1fr; }
  .sem-services__intro { position: static; }
}
@media (max-width: 560px) { .sem-svc-list li { padding-left: var(--space-lg); padding-top: var(--space-4xl); } }

/* ---- Why Ledco: dark band, slanted top ---- */
.sem-why .container { display: grid; gap: var(--space-xl); }
.sem-why .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.sem-why__list { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.sem-why__list li { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); background: color-mix(in srgb, var(--color-white) 4%, transparent); }
.sem-why__list svg { color: var(--color-accent-bright); }
.sem-why__list b { font-family: var(--font-heading); color: var(--color-white); }
.sem-why__list span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
@media (max-width: 1000px) { .sem-why__list { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .sem-why__list { grid-template-columns: 1fr; } }

/* ---- FAQ + neighbor ---- */
.sem-faq { background: var(--color-paper); }
.sem-faq .faq[open] { border-top-color: var(--color-accent); }
.sem-faq .faq summary:hover { color: var(--color-accent-dark); }
.sem-next { background: var(--color-surface); }
.sem-next__inner { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: var(--space-xl); align-items: center; }
.sem-next__inner p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.sem-next__inner a:not(.btn) { color: var(--color-primary); font-weight: 600; }
@media (max-width: 760px) { .sem-next__inner { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.sem-cta .container { align-items: center; }
.sem-cta .sem-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.sem-cta .sem-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="sem-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type sem-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/service-areas/">Service Areas</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Seminole, OK</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Seminole, OK &middot; Plumbing</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Drain cleaning &amp; plumbing</span> in Seminole, OK</h1>
        <p class="hero-answer">Ledco Plumbing LLC is based at 316 E Oak Ave in Seminole and handles drains, water heaters, leaks, sewer lines and commercial plumbing, seven days a week.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($saPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($saPhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('map-pin', 16); ?> Office on E Oak Ave</li>
          <li><?php icon('clock', 16); ?> Mon&ndash;Sun, 7 AM&ndash;5 PM</li>
          <li><?php icon('building-2', 16); ?> Homes &amp; businesses</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sem-article">
<!-- ============================================================ BOOM-ERA BUILDINGS -->
<section class="section sem-boom" id="boom" aria-labelledby="boom-title">
  <div class="container-wide">
    <div class="sem-boom__grid">
      <div class="sem-boom__body reveal-left">
        <span class="eyebrow-label">Built in a hurry</span>
        <h2 id="boom-title">What does a town built by an oil boom mean for plumbing in <span class="text-accent">Seminole</span>?</h2>
        <p class="answer-block">Seminole's oldest buildings went up fast. After a 1926 oil strike the town grew from 854 people to an estimated 25,000 to 30,000, and the plumbing in boom-era buildings is now close to a century old. Ledco Plumbing LLC, based on E Oak Ave in Seminole, treats the age of the pipe as the first question on an older building.</p>
        <p>Three of the town's National Register landmarks come straight out of those years: the Home Stake Oil and Gas Company Building at 315 E Broadway (1927 to 1928), the W.E. Grisso Mansion, begun in 1926, and Strother Memorial Chapel in Maple Grove Cemetery (1928). Ordinary houses and storefronts from the same years are not landmarks, but they share the clock. Pipe installed in the late 1920s was commonly galvanized steel on the supply side and cast iron on the drain side, and both wear from the inside out.</p>
        <p>What that looks like on a service call: low water pressure at a fixture that used to run strong, brown water after the supply has sat unused, a drain line that clogs in the same spot every few months, a slow leak behind a wall that shows up first as a high water bill. A plumber confirms what a particular building actually has before quoting a repair, and some Seminole buildings have had pipe replaced over the decades. Ledco Plumbing's <a href="/services/leak-detection-repair/">leak detection and repair</a> and <a href="/services/drain-cleaning/">drain cleaning</a> cover the two most common results of old pipe, and a full replacement is priced the same way as any other job: you see the number before work starts.</p>
      </div>
      <aside class="sem-boom__card reveal-right" aria-label="Seminole oil boom population">
        <span class="eyebrow-label">1926 oil strike</span>
        <span class="sem-boom__num">854<small>to 25,000&ndash;30,000 people</small></span>
        <p>That is the jump in Seminole's population after the Fixico No. 1 well came in on July 16, 1926, according to Wikipedia and the American Oil &amp; Gas Historical Society. Plumbing from that rush is now about a century old.</p>
      </aside>
    </div>
  </div>
</section>

<!-- ============================================================ LOCAL FACTS (signature) -->
<section class="section edge-curve-top sem-facts" id="conditions" aria-labelledby="conditions-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Seminole conditions</span>
      <h2 id="conditions-title">What local conditions does Ledco Plumbing plan around in <span class="text-accent">Seminole</span>?</h2>
      <p class="answer-block">Ledco Plumbing LLC plans around four Seminole facts: a winter cold enough to freeze exposed pipe, about 43 inches of rain a year, a downtown and a college that put commercial plumbing in town, and a city split across two ZIP codes and several school districts. The table pairs each fact with what it means on a plumbing call.</p>
    </div>
    <div class="sem-table-wrap reveal-up">
      <table class="sem-table">
        <caption>Seminole, OK local facts and what each means for a plumbing call</caption>
        <thead>
          <tr>
            <th scope="col">Local fact</th>
            <th scope="col">What the fact is</th>
            <th scope="col">What it means for plumbing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><?php icon('flame', 16); ?>Winter cold</th>
            <td data-label="Fact">January lows average about 26&nbsp;&deg;F (NOAA 1991&ndash;2020), and the USDA 2023 map puts ZIP 74868 in zone 7b, where winter lows run 5 to 10&nbsp;&deg;F.</td>
            <td data-label="Plumbing">Pipes in exterior walls, crawl spaces and outdoor hose bibs are the ones that split. The main shutoff stops the flow while you call.</td>
          </tr>
          <tr>
            <th scope="row"><?php icon('droplets', 16); ?>Rainfall</th>
            <td data-label="Fact">About 43 inches of rain a year, and about 4 inches of snow.</td>
            <td data-label="Plumbing">Wet ground shows underground trouble: a soggy patch in the yard, or a sunken strip over the line, can mean a service line or sewer problem. See <a href="/services/sewer-line-repair/">sewer line repair</a>.</td>
          </tr>
          <tr class="sem-table__key">
            <th scope="row"><?php icon('building-2', 16); ?>Downtown and campus</th>
            <td data-label="Fact">Downtown Broadway holds the 1927&ndash;28 Home Stake Oil and Gas Company Building, and Seminole State College sits within the city.</td>
            <td data-label="Plumbing">Buildings of that age and campus buildings keep restrooms and floor drains in service. See <a href="/services/commercial-plumbing/">commercial plumbing</a>.</td>
          </tr>
          <tr>
            <th scope="row"><?php icon('map-pin', 16); ?>Two ZIP codes</th>
            <td data-label="Fact">ZIP codes 74818 and 74868 serve the city, and parts of it fall in the Varnum, Butner and New Lima school districts.</td>
            <td data-label="Plumbing">One ZIP code or one school district does not describe the whole city. Give the office your street address and it confirms whether it is covered.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="sem-facts__note reveal-up">Climate figures are the 1991&ndash;2020 NOAA normals for Seminole as reported on Wikipedia; zone from the USDA 2023 plant hardiness map by ZIP code.</p>
  </div>
</section>

<!-- ============================================================ SERVICES IN SEMINOLE -->
<section class="section sem-services" id="services" aria-labelledby="services-title">
  <div class="container-wide">
    <div class="sem-services__layout">
      <div class="sem-services__intro reveal-left">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="services-title">Which plumbing services can you get from Ledco Plumbing in <span class="text-accent">Seminole</span>?</h2>
        <p class="answer-block">Ledco Plumbing LLC offers five services to Seminole homes and businesses: drain cleaning, water heater repair and installation, leak detection and repair, sewer line repair, and commercial plumbing. Each links to a page with the full scope. Below is how each one shows up in Seminole.</p>
      </div>
      <ol class="sem-svc-list reveal-right">
        <li>
          <h3><a href="/services/drain-cleaning/">Drain cleaning near me in Seminole</a></h3>
          <p>Old cast-iron drain lines are rough inside and catch grease and hair, so a kitchen or bath line that clogs again and again is common in homes from the boom years.</p>
        </li>
        <li>
          <h3><a href="/services/water-heater-repair-installation/">Water heater repair &amp; installation</a></h3>
          <p>Winter is when a weak heater gets noticed: with Seminole's January lows near 26&nbsp;&deg;F the incoming water is cold, so a failing element or a tank full of sediment shows up as lukewarm showers.</p>
        </li>
        <li>
          <h3><a href="/services/leak-detection-repair/">Leak detection &amp; repair</a></h3>
          <p>A water bill that climbs with no change in use, or a damp patch in the yard, points to a hidden leak. Finding it without opening every wall is the point of the service.</p>
        </li>
        <li>
          <h3><a href="/services/sewer-line-repair/">Sewer line repair</a></h3>
          <p>A sewer line needs steady downhill slope to the main. One settled section holds water and backs up the lowest drain in the house, and in Seminole's wet months it can show first as a soggy yard.</p>
        </li>
        <li>
          <h3><a href="/services/commercial-plumbing/">Commercial plumbing</a></h3>
          <p>Broadway storefronts, offices and rentals need restrooms, kitchens and floor drains working. Weekend calls are taken, Saturday and Sunday, 7 AM to 5 PM.</p>
        </li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ WHY LEDCO -->
<section class="section on-dark texture-grain slant-top sem-why" id="why" aria-labelledby="why-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Why Ledco Plumbing</span>
      <h2 id="why-title">Why call a plumber based right in <span class="text-accent">Seminole</span>?</h2>
      <p class="answer-block">Ledco Plumbing LLC is owned by Mickey Ledbetter and operates from 316 E Oak Ave in Seminole. The office takes calls seven days a week, and you see the price before any work starts.</p>
    </div>
    <ul class="sem-why__list reveal-up">
      <li><?php icon('map-pin', 22); ?><b>Office on E Oak Ave</b><span>316 E Oak Ave, Seminole, OK 74868. Directions are on the homepage and the contact page.</span></li>
      <li><?php icon('calendar', 22); ?><b>Open all seven days</b><span>Monday through Sunday, 7 AM to 5 PM, so a weekend leak is not a Monday problem.</span></li>
      <li><?php icon('clipboard-list', 22); ?><b>Price first</b><span>The estimate comes before the work, and you decide whether to go ahead.</span></li>
      <li><?php icon('wrench', 22); ?><b>One call, five services</b><span>A clog that turns out to be a broken pipe stays with the same company.</span></li>
    </ul>
  </div>
</section>

<!-- ============================================================ FAQ -->
<section class="section sem-faq" id="faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">What do Seminole customers ask about <span class="text-accent">plumbing service</span>?</h2>
      <p class="answer-block">Seminole customers ask whether an address just outside town is covered, and whether freezing weather is a real plumbing risk. Ledco Plumbing LLC answers both below. For anything else, call the office at <?php echo esc($saPhone); ?>.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($faqs as $saFaqIdx => $saFaq): ?>
      <details class="faq"<?php echo $saFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($saFaq['q']); ?></summary>
        <p><?php echo esc($saFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
</article>

<!-- ============================================================ NEIGHBOR -->
<?php if (areaLive('wewoka-ok')): ?>
<section class="section sem-next" aria-label="Nearby service area">
  <div class="container">
    <div class="sem-next__inner reveal-up">
      <p>Ledco Plumbing LLC also serves Wewoka, the Seminole County seat, about 10 miles southeast of the Seminole office. Read what Ledco plans around there on the <a href="/service-areas/wewoka-ok/">Wewoka plumbing page</a>, or see <a href="/service-areas/">all service areas</a>.</p>
      <a class="btn btn-primary" href="/service-areas/wewoka-ok/">Plumbing in Wewoka</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top sem-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Get a Free Estimate in Seminole</h2>
      <p>Call Ledco Plumbing at <?php echo esc($saPhone); ?> or request an estimate online. If water is coming through a ceiling or backing up a drain right now, call instead of using the form.</p>
      <p class="sem-cta__links"><a href="<?php echo esc($gbp['directions']); ?>" target="_blank" rel="noopener">Get directions to the Seminole office</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($saPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
