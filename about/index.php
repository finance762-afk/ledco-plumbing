<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * about/index.php — About Ledco Plumbing (Phase 5, minimal-tech editorial).
 *
 * Section script: interior type hero → story + at-a-glance card (asymmetric) → ONE mid-page estimate band (cta-band)
 * → "what to expect" values (tinted bento) → job timeline (signature) → "check us out" proof (dark, slanted) → closing CTA.
 *
 * Claims: every fact traces to build-plan.json / config.php / the homepage (owner, office, hours, towns, five services,
 * "price before work starts", water run after the repair). NOT in intake and therefore NOT on the page: founding year,
 * years in business, license number, insurance, certifications, crew size, equipment, job photos, awards.
 * They are listed under "/about/" in /content-confirmations.json. The timeline is the job process, not company history,
 * because no milestones exist yet. No client photos exist, so there is no .split section and no image slot:
 * the page is type + facts, like the homepage.
 * Local history source (late-1920s Seminole oil boom): https://www.okhistory.org/publications/enc/entry?entry=SE012
 */
$pageTitle       = 'About Ledco Plumbing LLC | Plumber in Seminole, OK';
$pageDescription = 'Meet Ledco Plumbing LLC, a Seminole, OK plumbing company owned by Mickey Ledbetter. Office on E Oak Ave, open 7 days a week, serving Seminole and Wewoka.';
$canonicalUrl    = $siteUrl . '/about/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'about';
$pageType        = 'about';

$abPhone     = formatPhone($phone);
$abPhoneHref = phoneHref($phone);
$abBase      = rtrim($siteUrl, '/');
$abCity      = $address['city'];

$pageSchema = [
    [
        '@type'       => 'AboutPage',
        '@id'         => $abBase . '/about/#webpage',
        'url'         => $abBase . '/about/',
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'isPartOf'    => ['@id' => schemaId('website')],
        'about'       => ['@id' => schemaId('organization')],
        'mainEntity'  => ['@id' => $abBase . '/about/#owner'],
        'breadcrumb'  => ['@id' => $abBase . '/about/#breadcrumb'],
        'speakable'   => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['.hero-answer', '.answer-block']],
    ],
    [
        '@type'    => 'Person',
        '@id'      => $abBase . '/about/#owner',
        'name'     => $ownerName,
        'jobTitle' => 'Owner',
        'worksFor' => ['@id' => schemaId('organization')],
    ],
    ['@id' => $abBase . '/about/#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['About', '/about/']]),
];
$schemaMarkup = $pageSchema;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band-form.php';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   about/ — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.ab-page h1, .ab-page h2, .ab-page h3 { text-wrap: balance; }
.ab-page p { text-wrap: pretty; }

/* ---- Hero: dark type hero, offset rule + glow on the right (C1 layered) ---- */
.ab-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 100%); }
.ab-hero::before {
  content: "";
  position: absolute;
  inset: 0 0 0 55%;
  z-index: -1;
  pointer-events: none;
  background:
    linear-gradient(0deg, transparent calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% + 1px), transparent calc(50% + 1px)),
    radial-gradient(closest-side at 65% 55%, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 75%);
}
.ab-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background-image: repeating-linear-gradient(90deg, color-mix(in srgb, var(--color-white) 4%, transparent) 0 1px, transparent 1px var(--space-2xl));
  -webkit-mask-image: linear-gradient(100deg, transparent 45%, var(--color-black) 95%);
  mask-image: linear-gradient(100deg, transparent 45%, var(--color-black) 95%);
}
.ab-hero .grain { opacity: .3; }
.ab-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.ab-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.ab-hero .breadcrumb a:hover, .ab-hero .breadcrumb [aria-current] { color: var(--color-white); }
.ab-hero .hero-title { max-width: 22ch; margin-top: var(--space-2); }
.ab-hero .hero-answer { max-width: 40rem; margin-top: var(--space-sm); }
.ab-hero .hero-actions { margin-top: var(--space-md); }
.ab-hero .link-call { color: var(--color-white); }
@media (max-width: 900px) { .ab-hero::before { inset: 0 0 0 60%; } }
@media (max-width: 560px) { .ab-hero .hero-answer { font-size: var(--fs-body); } .ab-hero .hero-chips li { font-size: var(--font-size-xs); } }

/* ---- Story: asymmetric long copy + sticky at-a-glance card ---- */
.ab-story { background: var(--color-paper); }
.ab-story__grid { display: grid; grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.ab-story__body { display: grid; gap: var(--space-md); }
.ab-story__body > p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.ab-story__body a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.ab-glance {
  position: sticky;
  top: calc(var(--nav-height) + var(--space-xl));
  display: grid;
  gap: var(--space-md);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  border-top: 3px solid var(--color-accent);
  box-shadow: var(--shadow);
}
.ab-glance h3 { font-size: var(--fs-eyebrow); font-family: var(--font-accent); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.ab-glance dl { display: grid; gap: var(--space-md); margin: 0; }
.ab-glance dt { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.ab-glance dd { margin: 0; font-family: var(--font-heading); font-weight: 700; line-height: 1.3; color: var(--color-ink); }
.ab-glance dd small { display: block; font-family: var(--font-body); font-weight: 400; font-size: var(--fs-small); color: var(--color-muted); }
.ab-glance a { color: var(--color-primary); }
@media (max-width: 900px) { .ab-story__grid { grid-template-columns: 1fr; } .ab-glance { position: static; } }

/* ---- Expectations: tinted bento, last tile dark ---- */
.ab-expect { background: var(--color-surface); }
.ab-expect__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); }
.ab-tile { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); transition: transform var(--transition), box-shadow var(--transition); }
.ab-tile:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow); }
.ab-tile:nth-child(1) { background: var(--color-card-tint-1); }
.ab-tile:nth-child(2) { background: var(--color-card-tint-2); }
.ab-tile:nth-child(3) { background: var(--color-card-tint-3); }
.ab-tile:nth-child(4) { background: var(--color-dark); color: var(--color-white); border-color: transparent; }
.ab-tile:nth-child(4) h3 { color: var(--color-white); }
.ab-tile:nth-child(4) p { color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.ab-tile:nth-child(4) svg { color: var(--color-accent-bright); }
.ab-tile svg { color: var(--color-accent-dark); }
.ab-tile h3 { margin: 0; }
.ab-tile p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) { .ab-expect__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .ab-expect__grid { grid-template-columns: 1fr; } }

/* ---- Job timeline (signature) ---- */
.ab-job { background: var(--color-paper-2); }
.ab-job__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.3fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.ab-job .timeline { margin: 0; gap: var(--space-xl); }
.ab-job .timeline > li { display: grid; gap: var(--space-1); padding-left: var(--space-sm); }
.ab-job .timeline > li::before { box-shadow: 0 0 0 var(--space-1) var(--color-card-tint-3); }
.ab-job .timeline b { font-family: var(--font-heading); font-size: var(--fs-h3); color: var(--color-ink); }
.ab-job .timeline span { color: var(--color-ink-2); font-size: var(--fs-small); max-width: 52ch; }
@media (max-width: 900px) { .ab-job__grid { grid-template-columns: 1fr; } }

/* ---- Verify: dark band, slanted top, three proof cards ---- */
.ab-proof .container { display: grid; gap: var(--space-xl); }
.ab-proof .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ab-proof__list { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ab-proof__list li { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); background: color-mix(in srgb, var(--color-white) 4%, transparent); }
.ab-proof__list svg { color: var(--color-accent-bright); }
.ab-proof__list b { font-family: var(--font-heading); color: var(--color-white); }
.ab-proof__list span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.ab-proof__list a { color: var(--color-accent-bright); font-weight: 600; }
@media (max-width: 900px) { .ab-proof__list { grid-template-columns: 1fr; } }

/* ---- Closing CTA ---- */
.ab-cta .container { align-items: center; }
.ab-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.ab-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="ab-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type ab-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">About</span></li>
      </ol>
    </nav>
    <span class="eyebrow">About &middot; <?php echo esc($abCity . ', ' . $address['state']); ?></span>
    <h1 class="hero-title" id="hero-title">About <span class="text-accent">Ledco Plumbing</span> in <?php echo esc($abCity); ?>, OK</h1>
    <p class="hero-answer"><?php echo esc($siteName); ?> is a plumbing company owned by <?php echo esc($ownerName); ?>, with its office at <?php echo esc($address['street']); ?> in <?php echo esc($abCity); ?>. It repairs drains, water heaters, leaks and sewer lines for homes and businesses in <?php echo esc($abCity); ?> and Wewoka.</p>
    <div class="hero-actions">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($abPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($abPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
    <ul class="hero-chips">
      <li><?php icon('handshake', 16); ?> Owner: <?php echo esc($ownerName); ?></li>
      <li><?php icon('calendar', 16); ?> Open 7 days, 7 AM&ndash;5 PM</li>
      <li><?php icon('map-pin', 16); ?> <?php echo esc($abCity); ?> &amp; Wewoka</li>
    </ul>
  </div>
</section>

<article>
<!-- ============================================================ STORY -->
<section class="section ab-story" id="story" aria-labelledby="story-title">
  <div class="container-wide">
    <div class="ab-story__grid">
      <div class="ab-story__body reveal-left">
        <span class="eyebrow-label">Our story</span>
        <h2 id="story-title">Who is behind <span class="text-accent">Ledco Plumbing</span> in <?php echo esc($abCity); ?>?</h2>
        <p class="answer-block"><?php echo esc($siteName); ?> is owned by <?php echo esc($ownerName); ?> and run from an office at <?php echo esc($address['street']); ?> in <?php echo esc($abCity); ?>, Oklahoma. When you call <?php echo esc($abPhone); ?>, you reach that office, and the company takes calls seven days a week from 7 AM to 5 PM.</p>
        <p>Ledco Plumbing works on the plumbing a Seminole County household or small business actually runs into: a drain that will not clear, a water heater that has gone cold or started to leak, a water bill that does not match how much water was used, a sewer line that backs up into the lowest drain in the house, and the restrooms, kitchens and floor drains of commercial buildings. Those five jobs make up the whole menu, listed on the <a href="/services/">Ledco Plumbing services page</a>, and each has its own page that explains what the work involves.</p>
        <p>The company stays close to home on purpose. Its office is on E Oak Ave in <?php echo esc($abCity); ?>, and its service area is <?php echo esc($abCity); ?> and Wewoka. Seminole grew fast during the oil boom of the late 1920s, so a single street can hold houses from several decades with different pipe in each one. Cast-iron drains and galvanized supply lines in the older homes are a common reason for slow drains and hidden leaks, and newer houses and commercial buildings have their own weak points. Knowing which of those you are likely to find behind the wall is a large part of finding a problem quickly.</p>
        <p>Every job begins the same way: someone looks at the actual pipe, drain or heater before a repair is priced. You see the estimate before any work starts, you decide whether to go ahead, and when the repair is finished the water is run to check that it works. If clearing a drain turns up a broken sewer pipe, or a leak search points to a failing water heater, the same company can price the next step, so you do not have to start over with someone new.</p>
        <p>Questions that are quicker to answer in writing are on the <a href="/faq/">Ledco Plumbing FAQ page</a>, and the <a href="/contact/">contact page</a> has the office address, a map and a form.</p>
      </div>

      <aside class="ab-glance reveal-right" aria-label="Ledco Plumbing at a glance">
        <h3>At a glance</h3>
        <dl>
          <div><dt>Owner</dt><dd><?php echo esc($ownerName); ?><small><?php echo esc($siteName); ?></small></dd></div>
          <div><dt>Office</dt><dd><?php echo esc($address['street']); ?><small><?php echo esc($abCity . ', ' . $address['state'] . ' ' . $address['zip']); ?></small></dd></div>
          <div><dt>Hours</dt><dd>Monday&ndash;Sunday<small>7:00 AM &ndash; 5:00 PM</small></dd></div>
          <div><dt>Service area</dt><dd><?php echo esc($abCity); ?> and Wewoka<small>Elsewhere in Seminole County: call to confirm</small></dd></div>
          <div><dt>Phone</dt><dd><a href="<?php echo esc($abPhoneHref); ?>"><?php echo esc($abPhone); ?></a></dd></div>
        </dl>
      </aside>
    </div>
  </div>
</section>

<!-- ============================================================ MID-PAGE ESTIMATE BAND (the one form on this page) -->
<?php echo p1_cta_band_form([
    'eyebrow' => 'Free estimate',
    'heading' => 'Have a plumbing problem in ' . $abCity . '?',
    'copy'    => 'Tell ' . $brandName . ' what you are seeing and the office will call you back.',
]); ?>

<!-- ============================================================ WHAT TO EXPECT -->
<section class="section edge-curve-top ab-expect" id="expect" aria-labelledby="expect-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What to expect</span>
      <h2 id="expect-title">What can you count on when you hire <span class="text-accent">Ledco Plumbing</span>?</h2>
      <p class="answer-block"><?php echo esc($siteName); ?> works to four standards: you see the price before work starts, a plumber looks at the real problem before quoting it, the water is run to test the repair, and the same hours apply on Saturday and Sunday as on Monday.</p>
    </div>
    <div class="ab-expect__grid">
      <div class="ab-tile reveal-up reveal-delay-1">
        <?php icon('clipboard-list', 26); ?>
        <h3>The price comes first</h3>
        <p>You see the estimate before any work starts and you decide whether to go ahead.</p>
      </div>
      <div class="ab-tile reveal-down reveal-delay-2">
        <?php icon('search', 26); ?>
        <h3>Look before we quote</h3>
        <p>The drain, line, leak or water heater is checked in person before a repair is priced, because a guess over the phone costs you either way.</p>
      </div>
      <div class="ab-tile reveal-up reveal-delay-3">
        <?php icon('droplets', 26); ?>
        <h3>Water runs before we leave</h3>
        <p>When the repair is done, the fixtures are run so you can see the drain empty or the heater make hot water before the plumber goes.</p>
      </div>
      <div class="ab-tile reveal-scale reveal-delay-4">
        <?php icon('calendar', 26); ?>
        <h3>Seven days, same hours</h3>
        <p>The office takes calls Monday through Sunday, 7 AM to 5 PM, so a Saturday leak does not have to wait for Monday.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ JOB TIMELINE (signature) -->
<section class="section ab-job" id="how-a-job-runs" aria-labelledby="job-title">
  <div class="container">
    <div class="ab-job__grid">
      <div class="section-title reveal-left">
        <span class="eyebrow-label">From first call to finished repair</span>
        <h2 id="job-title">How does a Ledco Plumbing job run, from the first call?</h2>
        <p class="answer-block">A Ledco Plumbing job runs in four steps: you call or send the form, a plumber looks at the problem, you approve the price, and the repair is made and tested with running water. The price is agreed in step three, before any work begins.</p>
      </div>
      <ol class="timeline reveal-right">
        <li><b>You call or send the form</b><span>Call <?php echo esc($abPhone); ?> or use the estimate form and say what you see: which drain is slow, where the water is, what the heater is doing. If water is escaping right now, close the main shutoff valve and call rather than sending the form.</span></li>
        <li><b>A plumber looks at it</b><span>The drain, line, leak or water heater is checked at your home or business, so the quote is based on the real problem.</span></li>
        <li><b>You approve the price</b><span>You get the estimate before any work starts, and the decision to go ahead is yours.</span></li>
        <li><b>The repair is made and tested</b><span>Once the work is done, the water is run to check that it drains, holds pressure or heats as it should.</span></li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ VERIFY -->
<section class="section on-dark texture-grain slant-top ab-proof" id="verify" aria-labelledby="verify-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Check us out</span>
      <h2 id="verify-title">How can you check that Ledco Plumbing is a real <span class="text-accent">Seminole</span> business?</h2>
      <p class="answer-block"><?php echo esc($siteName); ?> operates as a limited liability company with a street address in <?php echo esc($abCity); ?>, a Google Business Profile and a phone line the office answers. You can check each of those yourself before you call.</p>
    </div>
    <ul class="ab-proof__list reveal-up">
      <li><?php icon('map-pin', 24); ?><b>A street address you can drive to</b><span><?php echo esc($address['street']); ?>, <?php echo esc($abCity . ', ' . $address['state'] . ' ' . $address['zip']); ?>. <a href="<?php echo esc($gbp['directions']); ?>" target="_blank" rel="noopener">Get directions</a></span></li>
      <li><?php icon('search', 24); ?><b>A public Google listing</b><span>See the office on the map, the posted hours and what customers have written. <a href="<?php echo esc($gbp['profile_url']); ?>" target="_blank" rel="noopener">Open Ledco Plumbing on Google Maps</a></span></li>
      <li><?php icon('phone', 24); ?><b>A phone line with a person on it</b><span>Call <a href="<?php echo esc($abPhoneHref); ?>"><?php echo esc($abPhone); ?></a> any day, 7 AM to 5 PM, and ask <?php echo esc($ownerName); ?>'s office anything before you book.</span></li>
    </ul>
  </div>
</section>
</article>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top ab-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Talk to the office</span>
      <h2 id="cta-title">Ready to talk to a Seminole plumber?</h2>
      <p>Call <?php echo esc($abPhone); ?> or send an estimate request. If water is backing up or leaking right now, call.</p>
      <p class="ab-cta__links"><a href="/services/">See all five Ledco Plumbing services</a> &middot; <a href="/contact/">Contact page and map</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($abPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($abPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
