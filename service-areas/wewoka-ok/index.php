<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * service-areas/wewoka-ok/index.php — Wewoka, OK area page (Phase 6, minimal-tech).
 *
 * Opening angle: the county seat and Seminole Nation capital, a compact town of old public and historic buildings.
 * Conditions emphasis: building age and access (leaks, water heaters, commercial), the short trip from the Seminole office.
 * Section script: type hero + form → county-seat answer + facts card (split) → landmark roster (signature)
 *   → services in Wewoka (tinted 2-up cards) → the trip from the Seminole office (dark) → FAQ → Seminole neighbor → closing CTA.
 *
 * RESEARCH (2026-10-19). Sources:
 *   https://en.wikipedia.org/wiki/Wewoka,_Oklahoma  (1849 founding near a small falls, county seat after 1908 election vs Seminole,
 *       Seminole Nation capital, 2020 pop 3,133 (infobox; the lead's 3,271 is the 2000 figure), 4.84 sq mi, ZIP 74884, NRHP:
 *       Andrew Jackson Brown house at 11th Ave & Muskogee, J. Coody Johnson office building, Seminole County Courthouse,
 *       1941 WPA post-office mural, oil 2 miles SE on March 16, 1923, Wewoka Lake built in the 1920s as a water reservoir)
 *   https://seminolenationmuseum.org/history-wewoka-community/  and  https://seminolenationmuseum.org/?p=381
 *       (A Brief History of Wewoka; name = "Barking Water" in Mvskoke; museum opened Nov 1974; 524 S Wewoka Ave)
 *   https://www.travelok.com/listings/view.profile/id.6716  (Seminole Nation Museum listing)
 *   https://phzmapi.org/74884.json  (USDA 2023 hardiness zone by ZIP: 7b, 5 to 10 F)
 *   https://aoghs.org/petroleum-pioneers/seminole-oil-boom/  (Greater Seminole field)
 * Conflicts, handled in copy: founder is John Horse (museum, Wikipedia history section) vs John Coheia (Wikipedia lead) -> copy
 *   says "Black Seminole settlers" with no name; county-seat year is 1908 (Wikipedia) vs 1907 (Britannica) -> copy gives no year;
 *   museum hours differ by source -> no hours printed.
 * Elevation: Wikipedia gives 873 ft and no second source was found, so no elevation is printed.
 * Dropped: any city water-system claim (only "built as a reservoir in the 1920s" is stated), Wewoka Falls as a named site
 *   (not on the page), Seminole Nation headquarters building, any claim about jobs Ledco has done in town.
 * Distance: ~10.7 mi straight line from the Seminole coordinates to Wewoka's; copy says "about 10 miles". Wewoka Lake is ESE of
 *   Seminole (Seminole page) and NNW of Wewoka (Wewoka page), which is why the copy says it lies between the towns.
 */
$areaSlug = 'wewoka-ok';

$pageTitle       = 'Plumber in Wewoka, OK | Ledco Plumbing LLC, Seminole Office';
$pageDescription = 'Ledco Plumbing LLC serves Wewoka, OK from its Seminole office: leak detection, water heaters, drains, sewer lines, commercial plumbing. Call (405) 257-3096.';
$canonicalUrl    = $siteUrl . '/service-areas/wewoka-ok/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'areas/wewoka-ok';
$pageType        = 'city';
$citySlug        = $areaSlug;

$saPhone     = formatPhone($phone);
$saPhoneHref = phoneHref($phone);

$faqs = [
    [
        'q' => 'Does Ledco Plumbing serve Wewoka, or only Seminole?',
        'a' => 'Ledco Plumbing LLC lists both Seminole and Wewoka as service areas. The office is at 316 E Oak Ave in Seminole, about 10 miles northwest of Wewoka, and takes calls Monday through Sunday, 7 AM to 5 PM. Call ' . $saPhone . ' with your Wewoka street address to set up a visit.',
    ],
    [
        'q' => 'Can Ledco Plumbing work in an older Wewoka house or historic building?',
        'a' => 'Ledco Plumbing handles leaks, drains, water heaters and sewer lines in buildings of any age, and older buildings are usually where a leak hides. When you call, say how old the building is and what you are seeing, so the plumber plans how to reach the pipe with as little opened wall as possible.',
    ],
];

$pageSchema = generateAreaPageSchema(
    ['name' => 'Wewoka', 'slug' => $areaSlug, 'lat' => 35.1439, 'lng' => -96.4967, 'sameAs' => 'https://en.wikipedia.org/wiki/Wewoka,_Oklahoma'],
    $pageTitle, $pageDescription
);
if ($faqs) $pageSchema[] = generateFAQSchema($faqs);   // FAQPage mirrors the visible FAQ exactly
$schemaMarkup = $pageSchema;

$heroFormTitle   = 'Free estimate in Wewoka';
$heroFormTagline = 'Tell us what is going on at your Wewoka address and Ledco Plumbing will call you back.';

// Landmark roster: place, what it is (sourced), and what a building like it asks of its plumbing
$wewLandmarks = [
    ['icon' => 'landmark', 'name' => 'Seminole County Courthouse', 'what' => 'Wewoka won the county seat from Seminole in an election after statehood. After statehood, the Seminole Nation\'s log capitol, built in 1877, was used as the county courthouse.', 'pipe' => 'Public buildings keep restrooms, drains and water heaters running every business day, which is the commercial side of the trade.', 'link' => '/services/commercial-plumbing/', 'label' => 'commercial plumbing'],
    ['icon' => 'building-2', 'name' => 'Seminole Nation Museum', 'what' => 'At 524 S Wewoka Ave in a stone building the WPA put up in 1934 as a community center; it opened as a museum in 1974.', 'pipe' => 'A building of that age is where a slow leak hides inside stone and plaster, and where finding it without opening every wall matters.', 'link' => '/services/leak-detection-repair/', 'label' => 'leak detection and repair'],
    ['icon' => 'house', 'name' => 'Andrew Jackson Brown house', 'what' => 'At 11th Avenue and Muskogee, on the National Register of Historic Places and described as the last remaining structure of the Nineteenth Seminole Republic.', 'pipe' => 'Old houses are where original supply pipe, aging water heaters and drain lines with decades of buildup turn up.', 'link' => '/services/water-heater-repair-installation/', 'label' => 'water heater repair and installation'],
    ['icon' => 'building', 'name' => 'J. Coody Johnson office building', 'what' => 'A National Register office building in town.', 'pipe' => 'Offices and rentals call about the same things: a restroom out of service, a floor drain that backs up, a water heater that quit.', 'link' => '/services/commercial-plumbing/', 'label' => 'commercial plumbing'],
    ['icon' => 'milestone', 'name' => 'Post office mural', 'what' => '"Historical Background of Wewoka," a 1941 WPA mural by Marjorie Rowland Clarke, hangs in the Wewoka post office.', 'pipe' => 'A public building of that era was plumbed before plastic pipe was common, so anything original is galvanized or cast iron, and worth a look when a leak or slow drain appears.', 'link' => '/services/drain-cleaning/', 'label' => 'drain cleaning'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   service-areas/wewoka-ok — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.wew-page h1, .wew-page h2, .wew-page h3 { text-wrap: balance; }
.wew-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, a creek-line contour motif (C1 layered) ---- */
.wew-hero { background: linear-gradient(165deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 105%); }
.wew-hero::before {
  content: "";
  position: absolute;
  inset: 0 -5% 0 48%;
  z-index: -1;
  pointer-events: none;
  background: repeating-radial-gradient(ellipse at 85% 110%, transparent 0 var(--space-xl), color-mix(in srgb, var(--color-white) 7%, transparent) var(--space-xl) calc(var(--space-xl) + 1px));
  -webkit-mask-image: linear-gradient(110deg, transparent 5%, var(--color-black) 65%);
  mask-image: linear-gradient(110deg, transparent 5%, var(--color-black) 65%);
}
.wew-hero::after {
  content: "";
  position: absolute;
  inset: auto auto -40% -10%;
  width: 70%;
  aspect-ratio: 1;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 72%);
}
.wew-hero .grain { opacity: .3; }
.wew-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.wew-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.wew-hero .breadcrumb a:hover, .wew-hero .breadcrumb [aria-current] { color: var(--color-white); }
.wew-hero .hero-title { max-width: 22ch; }
.wew-hero .hero-answer { max-width: 36rem; }
.wew-hero .hero-form-card { border-top: 3px solid var(--color-accent); }
.wew-hero .hero-form .consent a { color: var(--color-primary); }
.wew-hero .link-call { color: var(--color-white); }
@media (max-width: 560px) {
  .wew-hero .hero-answer { font-size: var(--fs-body); }
  .wew-hero .hero-chips li { font-size: var(--font-size-xs); }
}

/* ---- County seat: copy + stacked fact card (reverse of the Seminole split) ---- */
.wew-seat { background: var(--color-surface); }
.wew-seat__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.5fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.wew-facts { display: grid; gap: 0; margin: 0; padding: 0; list-style: none; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-line); box-shadow: var(--shadow); }
.wew-facts li { display: grid; gap: var(--space-1); padding: var(--space-lg); border-bottom: 1px solid var(--color-line); }
.wew-facts li:last-child { border-bottom: 0; }
.wew-facts li:nth-child(odd) { background: var(--color-card-tint-1); }
.wew-facts li:nth-child(even) { background: var(--color-card-tint-3); }
.wew-facts b { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.wew-facts span { color: var(--color-ink-2); font-size: var(--fs-small); }
.wew-seat__body { display: grid; gap: var(--space-md); }
.wew-seat__body > p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.wew-seat__body a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
@media (max-width: 900px) { .wew-seat__grid { grid-template-columns: 1fr; } }

/* ---- Landmark roster (signature): ruled list, place left, plumbing note right ---- */
.wew-roster { background: var(--color-paper); }
.wew-roster__list { margin: 0; padding: 0; list-style: none; display: grid; gap: 0; border-top: 2px solid var(--color-ink); }
.wew-roster__item { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(var(--space-md), 4vw, var(--space-3xl)); padding: var(--space-lg) 0; border-bottom: 1px solid var(--color-line); transition: background-color var(--transition); }
.wew-roster__item:hover { background: color-mix(in srgb, var(--color-accent) 5%, transparent); }
.wew-roster__place { display: grid; grid-template-columns: auto 1fr; gap: var(--space-md); align-items: start; }
.wew-roster__place svg { color: var(--color-accent-dark); margin-top: var(--space-1); }
.wew-roster__place h3 { margin: 0 0 var(--space-1); font-size: var(--fs-h3); }
.wew-roster__place p, .wew-roster__pipe p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.wew-roster__pipe { display: grid; gap: var(--space-2); align-content: start; }
.wew-roster__pipe a { color: var(--color-primary); font-weight: 600; font-size: var(--fs-small); }
.wew-roster__tag { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.wew-roster__note { margin: var(--space-md) 0 0; font-size: var(--fs-small); color: var(--color-muted); }
@media (max-width: 760px) { .wew-roster__item { grid-template-columns: 1fr; gap: var(--space-sm); } }

/* ---- Services in Wewoka: 2-up tinted cards, last one spans ---- */
.wew-services { background: var(--color-surface); }
.wew-svc-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); }
.wew-svc { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); transition: transform var(--transition), box-shadow var(--transition); }
.wew-svc:nth-child(3n+1) { background: var(--color-card-tint-1); }
.wew-svc:nth-child(3n+2) { background: var(--color-card-tint-2); }
.wew-svc:nth-child(3n) { background: var(--color-card-tint-3); }
.wew-svc:last-child { grid-column: 1 / -1; }
.wew-svc:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow); }
.wew-svc svg { color: var(--color-accent-dark); }
.wew-svc h3 { margin: 0; font-size: var(--fs-h3); }
.wew-svc h3 a { color: var(--color-ink); }
.wew-svc h3 a:hover { color: var(--color-accent-dark); }
.wew-svc p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); max-width: 62ch; }
@media (max-width: 760px) { .wew-svc-grid { grid-template-columns: 1fr; } }

/* ---- The trip from the Seminole office: dark band with route graphic ---- */
.wew-trip .container { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: center; }
.wew-trip__body { display: grid; gap: var(--space-md); }
.wew-trip__body > p:not(.answer-block) { margin: 0; max-width: var(--measure); color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.wew-trip .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.wew-trip a:not(.btn) { color: var(--color-accent-bright); }
.wew-route { position: relative; display: grid; gap: var(--space-xl); padding: var(--space-xl) var(--space-lg) var(--space-xl) var(--space-3xl); margin: 0; list-style: none; border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); background: color-mix(in srgb, var(--color-white) 4%, transparent); }
.wew-route::before { content: ""; position: absolute; left: var(--space-xl); top: var(--space-2xl); bottom: var(--space-2xl); border-left: 2px dashed color-mix(in srgb, var(--color-accent-bright) 70%, transparent); }
.wew-route li { position: relative; display: grid; gap: var(--space-1); }
.wew-route li::before { content: ""; position: absolute; left: calc(-1 * var(--space-2xl) - 5px); top: .35em; width: 12px; height: 12px; border-radius: var(--radius-full); background: var(--color-accent-bright); box-shadow: 0 0 0 4px color-mix(in srgb, var(--color-accent) 30%, transparent); }
.wew-route b { font-family: var(--font-heading); color: var(--color-white); }
.wew-route span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
@media (max-width: 900px) { .wew-trip .container { grid-template-columns: 1fr; } }

/* ---- FAQ + neighbor ---- */
.wew-faq { background: var(--color-paper); }
.wew-faq .faq[open] { border-top-color: var(--color-accent); }
.wew-faq .faq summary:hover { color: var(--color-accent-dark); }
.wew-next { background: var(--color-surface); }
.wew-next__inner { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: var(--space-xl); align-items: center; }
.wew-next__inner p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.wew-next__inner a:not(.btn) { color: var(--color-primary); font-weight: 600; }
@media (max-width: 760px) { .wew-next__inner { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.wew-cta .container { align-items: center; }
.wew-cta .wew-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.wew-cta .wew-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="wew-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type wew-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/service-areas/">Service Areas</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Wewoka, OK</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Wewoka, OK &middot; County seat</span>
        <h1 class="hero-title" id="hero-title"><span class="text-accent">Drain cleaning &amp; plumbing</span> in Wewoka, OK</h1>
        <p class="hero-answer">Ledco Plumbing LLC serves Wewoka homes, offices and shops from its Seminole office, with leak detection, water heaters, drains, sewer lines and commercial plumbing.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo esc($saPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($saPhone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php icon('map-pin', 16); ?> About 10 miles from our office</li>
          <li><?php icon('clock', 16); ?> Mon&ndash;Sun, 7 AM&ndash;5 PM</li>
          <li><?php icon('building-2', 16); ?> Homes &amp; businesses</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="wew-article">
<!-- ============================================================ COUNTY SEAT -->
<section class="section wew-seat" id="county-seat" aria-labelledby="seat-title">
  <div class="container">
    <div class="wew-seat__grid">
      <ul class="wew-facts reveal-left" aria-label="Wewoka at a glance">
        <li><b>Founded</b><span>1849, by Black Seminole settlers near the falls of a small stream. The Mvskoke name means "Barking Water."</span></li>
        <li><b>County seat</b><span>Wewoka won the Seminole County seat from Seminole in an election after statehood.</span></li>
        <li><b>Size</b><span>3,133 people in the 2020 census, in 4.84 square miles. ZIP code 74884.</span></li>
        <li><b>Oil</b><span>The first Greater Seminole field strike came two miles southeast of town on March 16, 1923, three years before the 1926 boom in Seminole.</span></li>
      </ul>
      <div class="wew-seat__body reveal-right">
        <span class="eyebrow-label">Wewoka, Oklahoma</span>
        <h2 id="seat-title">Does Ledco Plumbing serve <span class="text-accent">Wewoka</span>, the Seminole County seat?</h2>
        <p class="answer-block">Yes. Ledco Plumbing LLC lists Wewoka as one of its two service areas and works from its Seminole office at 316 E Oak Ave, about 10 miles northwest. Wewoka calls are taken Monday through Sunday, 7 AM to 5 PM, for homes, offices and shops.</p>
        <p>Wewoka is the capital of the Seminole Nation of Oklahoma and the seat of Seminole County, and its landmarks include a courthouse, a 1934 WPA stone community center that is now the Seminole Nation Museum, and National Register houses and offices. The town covers 4.84 square miles.</p>
        <p>For a plumber, that mix means two kinds of calls. Homeowners ask about <a href="/services/water-heater-repair-installation/">water heaters</a> and slow drains. Offices, rentals and public buildings need <a href="/services/commercial-plumbing/">commercial plumbing</a>. Both start the same way at Ledco Plumbing: you describe what is happening, a plumber looks at it, and you get the price before any work begins.</p>
        <p>Many Oklahoma homes also have hard water, which leaves mineral scale that wears out a water heater early. If a Wewoka heater is rumbling or running short of hot water, the age and the scale in the tank are the first things to check.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ LANDMARK ROSTER (signature) -->
<section class="section edge-curve-top wew-roster" id="landmarks" aria-labelledby="landmarks-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Wewoka landmarks</span>
      <h2 id="landmarks-title">What do Wewoka's landmark buildings say about the plumbing in <span class="text-accent">Wewoka</span>?</h2>
      <p class="answer-block">Wewoka's landmarks date from the 1800s to the 1940s, and buildings from that span can carry old pipe. The five places below are real Wewoka buildings. Beside each one, Ledco Plumbing LLC notes the kind of plumbing problem a building of that age and use can have. None of them is a claim about Ledco's past customers.</p>
    </div>
    <ul class="wew-roster__list reveal-up">
<?php foreach ($wewLandmarks as $wewMark): ?>
      <li class="wew-roster__item">
        <div class="wew-roster__place">
          <?php icon($wewMark['icon'], 22); ?>
          <div>
            <h3><?php echo esc($wewMark['name']); ?></h3>
            <p><?php echo esc($wewMark['what']); ?></p>
          </div>
        </div>
        <div class="wew-roster__pipe">
          <span class="wew-roster__tag">What it asks of the plumbing</span>
          <p><?php echo esc($wewMark['pipe']); ?></p>
          <a href="<?php echo esc($wewMark['link']); ?>">See <?php echo esc($wewMark['label']); ?> &rarr;</a>
        </div>
      </li>
<?php endforeach; ?>
    </ul>
    <p class="wew-roster__note reveal-up">Landmark details from Wikipedia's Wewoka article and the Seminole Nation Museum's Wewoka history. Listing a building here does not mean it is a Ledco customer.</p>
  </div>
</section>

<!-- ============================================================ SERVICES IN WEWOKA -->
<section class="section wew-services" id="services" aria-labelledby="services-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="services-title">Which plumbing services can you book from Ledco Plumbing in <span class="text-accent">Wewoka</span>?</h2>
      <p class="answer-block">Ledco Plumbing LLC offers the same five services in Wewoka as in Seminole: drain cleaning, water heater repair and installation, leak detection and repair, sewer line repair, and commercial plumbing. Each page lists the warning signs, the scope and the steps of a visit.</p>
    </div>
    <div class="wew-svc-grid">
      <article class="wew-svc reveal-left">
        <?php icon('search', 24); ?>
        <h3><a href="/services/leak-detection-repair/">Leak detection &amp; repair</a></h3>
        <p>In Wewoka's older buildings a leak often travels inside a wall or under a floor before it shows. Tracing a high water bill to its source comes before any repair.</p>
      </article>
      <article class="wew-svc reveal-right">
        <?php icon('flame', 24); ?>
        <h3><a href="/services/water-heater-repair-installation/">Water heater repair &amp; installation</a></h3>
        <p>Repair when a part has failed, replacement when the tank itself is leaking. Hard-water scale is a common reason a heater wears out early.</p>
      </article>
      <article class="wew-svc reveal-left">
        <?php icon('droplets', 24); ?>
        <h3><a href="/services/drain-cleaning/">Drain cleaning near me in Wewoka</a></h3>
        <p>Kitchen, bath, laundry and main-line clogs. When two fixtures back up at once, the blockage is in the shared line, not the fixture.</p>
      </article>
      <article class="wew-svc reveal-right">
        <?php icon('waves', 24); ?>
        <h3><a href="/services/sewer-line-repair/">Sewer line repair</a></h3>
        <p>A cracked, root-filled or settled sewer line shows up as backups in the lowest drain. The repair starts with finding which section failed.</p>
      </article>
      <article class="wew-svc reveal-up">
        <?php icon('building-2', 24); ?>
        <h3><a href="/services/commercial-plumbing/">Commercial plumbing</a></h3>
        <p>For Wewoka offices, shops, rentals and public buildings: restrooms back in service, kitchen and floor drains cleared, and weekend calls taken Saturday and Sunday, 7 AM to 5 PM. Tell the office who can let the plumber in and who approves the estimate.</p>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================ THE TRIP -->
<section class="section on-dark texture-grain slant-top wew-trip" id="trip" aria-labelledby="trip-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="wew-trip__body reveal-left">
      <span class="eyebrow-label">From the Seminole office</span>
      <h2 id="trip-title">How far is Wewoka from the <span class="text-accent">Ledco Plumbing</span> office?</h2>
      <p class="answer-block">Wewoka is about 10 miles southeast of Ledco Plumbing's office at 316 E Oak Ave in Seminole, measured in a straight line. Wewoka Lake, built in the 1920s as a water reservoir, lies between the two towns. Call <?php echo esc($saPhone); ?> with your Wewoka street address.</p>
      <p>The office is owned by Mickey Ledbetter and is open every day of the week, so a Wewoka call on a Saturday or Sunday morning goes to the same number as a Monday call. Describe the problem, give the address, and the office tells you what the visit will involve and the price before the work starts.</p>
      <p>Seminole is the larger of the two service areas. Read the <a href="/service-areas/seminole-ok/">Seminole plumbing page</a> for what Ledco plans around in town, or the <a href="/service-areas/">service area overview</a> for both.</p>
    </div>
    <ol class="wew-route reveal-right" aria-label="Route from the Ledco Plumbing office to Wewoka">
      <li><b>Seminole office</b><span>316 E Oak Ave, Seminole, OK 74868</span></li>
      <li><b>Wewoka Lake</b><span>Between the two towns, southeast of Seminole and northwest of Wewoka</span></li>
      <li><b>Wewoka, OK 74884</b><span>About 10 miles southeast, straight-line distance</span></li>
    </ol>
  </div>
</section>

<!-- ============================================================ FAQ -->
<section class="section wew-faq" id="faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="faq-title">What do Wewoka customers ask about <span class="text-accent">plumbing service</span>?</h2>
      <p class="answer-block">Wewoka customers ask whether Ledco Plumbing LLC comes to Wewoka at all, and whether an older building is a problem. Both answers are below. For anything else, call the office at <?php echo esc($saPhone); ?>.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($faqs as $wewFaqIdx => $wewFaq): ?>
      <details class="faq"<?php echo $wewFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($wewFaq['q']); ?></summary>
        <p><?php echo esc($wewFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
</article>

<!-- ============================================================ NEIGHBOR -->
<?php if (areaLive('seminole-ok')): ?>
<section class="section wew-next" aria-label="Nearby service area">
  <div class="container">
    <div class="wew-next__inner reveal-up">
      <p>Ledco Plumbing LLC is based in Seminole, where its office is open every day. Read the <a href="/service-areas/seminole-ok/">Seminole plumbing page</a> or see <a href="/service-areas/">all service areas</a>.</p>
      <a class="btn btn-primary" href="/service-areas/seminole-ok/">Plumbing in Seminole</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top wew-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Get a Free Estimate in Wewoka</h2>
      <p>Call Ledco Plumbing at <?php echo esc($saPhone); ?> or request an estimate online. If water is coming through a ceiling or backing up a drain right now, call instead of using the form.</p>
      <p class="wew-cta__links"><a href="<?php echo esc($gbp['directions']); ?>" target="_blank" rel="noopener">Get directions to the Seminole office</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($saPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
