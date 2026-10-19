<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * faq/index.php — FAQ (Phase 5). Directory + index.php so the /faq/ canonical resolves; linked from the footer
 * Company column (footer.php shows it once this file exists) and from the About page.
 *
 * 18 questions in four categories (General, Services, Pricing, Process). Answers use only facts from build-plan.json /
 * config.php / the homepage and service pages, plus general plumbing knowledge. NOT answered, because intake does not
 * supply them: license / insurance, free-estimate and diagnostic-fee terms, price ranges, response time, after-hours
 * service, equipment, water-heater brands/fuel types, septic, other towns (see /content-confirmations.json, "/faq/").
 * FAQPage schema is generated from the same $faqCats array that renders the page, so it mirrors the visible text.
 * Section script: interior type hero + category jump chips → General → ONE mid-page estimate band → Services →
 * Pricing → Process → closing CTA.
 */
$pageTitle       = 'Plumbing FAQ | Ledco Plumbing LLC, Seminole, OK';
$pageDescription = 'Answers to 18 plumbing questions from Seminole, OK customers: hours, costs, drain cleaning, water heaters, leaks, sewer lines and how a Ledco job runs.';
$canonicalUrl    = $siteUrl . '/faq/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'faq';
$pageType        = 'faq';

$fqPhone     = formatPhone($phone);
$fqPhoneHref = phoneHref($phone);
$fqBase      = rtrim($siteUrl, '/');
$fqCity      = $address['city'];

$faqCats = [
    'general' => [
        'label'  => 'General',
        'icon'   => 'info',
        'title'  => 'Who is Ledco Plumbing, and where does it work?',
        'answer' => 'Ledco Plumbing LLC is a plumbing company owned by Mickey Ledbetter, based at 316 E Oak Ave in Seminole, Oklahoma. It works in Seminole and Wewoka, and the office takes calls seven days a week from 7 AM to 5 PM.',
        'items'  => [
            ['q' => 'Who owns Ledco Plumbing?',
             'a' => 'Mickey Ledbetter owns Ledco Plumbing LLC. The office is at 316 E Oak Ave in Seminole, and calling ' . $fqPhone . ' reaches it.'],
            ['q' => 'Which areas around Seminole do you serve?',
             'a' => 'Ledco Plumbing LLC serves Seminole and Wewoka from its office at 316 E Oak Ave in Seminole. If your home or business is elsewhere in Seminole County, call ' . $fqPhone . ' or send the form with your address, and the office will confirm whether a plumber can reach you.'],
            ['q' => 'What are your hours?',
             'a' => 'The Ledco Plumbing office is open Monday through Sunday, 7 AM to 5 PM. Saturday and Sunday hours are the same as weekday hours.'],
            ['q' => 'Do you offer emergency plumbing service in Seminole?',
             'a' => 'Ledco Plumbing LLC takes calls for burst pipes, sewer backups and failed water heaters seven days a week, 7 AM to 5 PM. When water is actively leaking, call ' . $fqPhone . ' rather than using the form, and close the main shutoff valve while you wait so the damage stops spreading.'],
            ['q' => 'Do you work on homes and businesses?',
             'a' => 'Yes. Ledco Plumbing repairs plumbing in Seminole and Wewoka houses, and it also does commercial plumbing for shops, offices and rental properties, including weekend calls.',
             'link' => ['/services/commercial-plumbing/', 'Commercial plumbing in Seminole']],
        ],
    ],
    'services' => [
        'label'  => 'Services',
        'icon'   => 'wrench',
        'title'  => 'What plumbing problems can Ledco Plumbing fix?',
        'answer' => 'Ledco Plumbing LLC fixes five kinds of plumbing problems: clogged drains, water heaters that fail or leak, hidden leaks, damaged or backed-up sewer lines, and commercial plumbing. Each has its own page, and the answers below cover the questions customers ask first about each one.',
        'items'  => [
            ['q' => 'What does drain cleaning cover?',
             'a' => 'Drain cleaning from Ledco Plumbing covers every drain in the building and the main line they all empty into: kitchen and bathroom sinks, tubs, showers, toilets, laundry standpipes and floor drains. The plumber finds which drain or line is blocked, clears it and runs water to show it flows.',
             'link' => ['/services/drain-cleaning/', 'Drain cleaning in Seminole']],
            ['q' => 'Should I repair or replace my water heater?',
             'a' => 'A heater that makes no hot water or not enough can often be repaired, because the fault is usually a single failed part. A tank that is leaking from the tank itself generally cannot be repaired and needs to be replaced. A plumber has to look at the heater to tell which one you have.',
             'link' => ['/services/water-heater-repair-installation/', 'Water heater repair and installation']],
            ['q' => 'Why does my water heater wear out faster in Oklahoma?',
             'a' => 'Hard water is common in Oklahoma, and its minerals settle in the bottom of a water heater tank as scale. That layer makes the heater work harder and can shorten its life. Flushing the tank on a regular schedule helps, and a water softener or filter cuts down the minerals coming in.'],
            ['q' => 'How can I tell if I have a hidden water leak?',
             'a' => 'A water bill that jumps without a change in how much water you use is the most common sign, along with damp spots, warm patches on a floor, or the sound of running water when everything is off. Check the water meter with every fixture turned off: if it still moves, water is escaping somewhere between the meter and the fixtures.',
             'link' => ['/services/leak-detection-repair/', 'Leak detection and repair']],
            ['q' => 'What should I do when a sewer line backs up?',
             'a' => 'Stop running water in the house, including the washer and dishwasher, and call ' . $fqPhone . '. A backup that shows up in the lowest drain, or in several drains at once, points to the main sewer line rather than a single fixture. Tell the office which drains are affected and where your sewer cleanout is, if you know.',
             'link' => ['/services/sewer-line-repair/', 'Sewer line repair']],
        ],
    ],
    'pricing' => [
        'label'  => 'Pricing',
        'icon'   => 'clipboard-list',
        'title'  => 'How does Ledco Plumbing price a job?',
        'answer' => 'Ledco Plumbing LLC prices a job after a plumber has seen the problem and before any work starts. The cost depends on what is wrong, the parts, and how hard the pipe or equipment is to reach, so a price over the phone is only a guide.',
        'items'  => [
            ['q' => 'How much does a plumbing repair or water heater replacement cost?',
             'a' => 'The price of a plumbing repair depends on the problem, the parts and how hard the pipe or tank is to reach, so Ledco Plumbing gives you an estimate before work starts. A water heater replacement also depends on the tank size and whether the heater runs on gas or electricity.'],
            ['q' => 'How much does drain cleaning cost?',
             'a' => 'The cost of clearing a drain depends on which drain is blocked, how far down the line the clog sits and how easy the access point is to reach. A kitchen sink trap is a different job from a main line. Ledco Plumbing gives you the price before any work starts.'],
            ['q' => 'What decides the cost of a sewer line repair?',
             'a' => 'Three things set the cost of a sewer line repair: how much of the line is damaged, how deep it runs, and what sits on top of it, such as a yard, a driveway or a slab. The plumber needs to see the line before a number means anything.'],
            ['q' => 'Will I know the price before the work starts?',
             'a' => 'Yes. Ledco Plumbing shows you the estimate before any work starts, and you decide whether to go ahead.'],
        ],
    ],
    'process' => [
        'label'  => 'Process',
        'icon'   => 'route',
        'title'  => 'What happens when I call Ledco Plumbing?',
        'answer' => 'When you call Ledco Plumbing LLC, the office asks what the problem is, then a plumber comes to look at it. You approve the price, the repair is made, and the water is run to check it. The questions below cover each step.',
        'items'  => [
            ['q' => 'How do I get an estimate?',
             'a' => 'Call ' . $fqPhone . ' or send the estimate form on the Contact page with your name, phone number, the service you need and a few lines about the problem. The office calls you back to set up a visit.',
             'link' => ['/contact/', 'Contact Ledco Plumbing']],
            ['q' => 'What should I do before the plumber arrives?',
             'a' => 'If water is escaping, close the main shutoff valve, usually where the water line enters the house or in the meter box near the street. Then make sure the plumber can reach the problem: clear the area around the water heater, the sink cabinet or the sewer cleanout, and note which drains or fixtures are affected.'],
            ['q' => 'How do I tell a single clogged drain from a sewer line problem?',
             'a' => 'One slow drain is usually a problem with that fixture or its branch line. Two or more drains slow or backing up at the same time, gurgling from a toilet when another drain runs, or dirty water coming up in the lowest drain in the house point to the main line.'],
            ['q' => 'Is the repair tested before the plumber leaves?',
             'a' => 'Yes. When the work is done, Ledco Plumbing runs water through the affected fixtures so you can see the drain empty, the line hold or the heater make hot water before the plumber leaves.'],
        ],
    ],
];

// ---- Schema: FAQPage built from the SAME array that renders the page -----------------------------------
$fqAll = [];
foreach ($faqCats as $fqCat) foreach ($fqCat['items'] as $fqItem) $fqAll[] = ['q' => $fqItem['q'], 'a' => $fqItem['a']];

$pageSchema = [
    [
        '@type'       => 'FAQPage',
        '@id'         => $fqBase . '/faq/#webpage',
        'url'         => $fqBase . '/faq/',
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'isPartOf'    => ['@id' => schemaId('website')],
        'about'       => ['@id' => schemaId('organization')],
        'breadcrumb'  => ['@id' => $fqBase . '/faq/#breadcrumb'],
        'mainEntity'  => generateFAQSchema($fqAll)['mainEntity'],
    ],
    ['@id' => $fqBase . '/faq/#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['FAQ', '/faq/']]),
];
$schemaMarkup = $pageSchema;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band-form.php';

/** One category block: sticky heading column + the questions as <details>. */
function fq_render_category(string $id, array $cat, bool $reverse, bool $firstOpen = true): void {
    ?>
    <div class="fq-cat<?php echo $reverse ? ' fq-cat--reverse' : ''; ?>">
      <div class="fq-cat__head reveal-<?php echo $reverse ? 'right' : 'left'; ?>">
        <span class="eyebrow-label"><?php echo esc($cat['label']); ?></span>
        <h2 id="<?php echo esc($id); ?>-title"><?php echo esc($cat['title']); ?></h2>
        <p class="answer-block"><?php echo esc($cat['answer']); ?></p>
      </div>
      <div class="fq-cat__list reveal-up">
<?php foreach ($cat['items'] as $i => $item): ?>
        <details class="faq"<?php echo ($firstOpen && $i === 0) ? ' open' : ''; ?>>
          <summary><?php echo esc($item['q']); ?></summary>
          <p><?php echo esc($item['a']); ?></p>
<?php if (!empty($item['link'])): ?>
          <p class="fq-more"><a href="<?php echo esc($item['link'][0]); ?>"><?php echo esc($item['link'][1]); ?> &rarr;</a></p>
<?php endif; ?>
        </details>
<?php endforeach; ?>
      </div>
    </div>
    <?php
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   faq/ — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.fq-page h1, .fq-page h2, .fq-page h3 { text-wrap: balance; }
.fq-page p { text-wrap: pretty; }

/* ---- Hero ---- */
.fq-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 100%); }
.fq-hero::before {
  content: "";
  position: absolute;
  inset: 0 0 0 55%;
  z-index: -1;
  pointer-events: none;
  background:
    linear-gradient(0deg, transparent calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% - 1px), color-mix(in srgb, var(--color-white) 9%, transparent) calc(50% + 1px), transparent calc(50% + 1px)),
    radial-gradient(closest-side at 70% 45%, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 75%);
}
.fq-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background-image: repeating-linear-gradient(90deg, color-mix(in srgb, var(--color-white) 4%, transparent) 0 1px, transparent 1px var(--space-2xl));
  -webkit-mask-image: linear-gradient(100deg, transparent 45%, var(--color-black) 95%);
  mask-image: linear-gradient(100deg, transparent 45%, var(--color-black) 95%);
}
.fq-hero .grain { opacity: .3; }
.fq-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.fq-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.fq-hero .breadcrumb a:hover, .fq-hero .breadcrumb [aria-current] { color: var(--color-white); }
.fq-hero .hero-title { max-width: 24ch; margin-top: var(--space-2); }
.fq-hero .hero-answer { max-width: 40rem; margin-top: var(--space-sm); }
.fq-hero .hero-actions { margin-top: var(--space-md); }
.fq-hero .link-call { color: var(--color-white); }
.fq-jump { display: flex; flex-wrap: wrap; gap: var(--space-2); margin: var(--space-md) 0 0; padding: 0; list-style: none; }
.fq-jump a { text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2); min-height: 44px; padding: var(--space-2) var(--space-md); border-radius: var(--radius-full); border: 1px solid color-mix(in srgb, var(--color-white) 22%, transparent); background: color-mix(in srgb, var(--color-white) 8%, transparent); color: var(--color-white); font-size: var(--fs-small); font-weight: 600; transition: background-color var(--transition), border-color var(--transition); }
.fq-jump a:hover { background: color-mix(in srgb, var(--color-white) 16%, transparent); border-color: var(--color-accent-bright); }
.fq-jump svg { color: var(--color-accent-bright); }
@media (max-width: 900px) { .fq-hero::before { inset: 0 0 0 60%; } }
@media (max-width: 560px) { .fq-hero .hero-answer { font-size: var(--fs-body); } }

/* ---- Category blocks: sticky head column + questions (asymmetric, alternating sides) ---- */
.fq-section { scroll-margin-top: calc(var(--nav-height) + var(--space-md)); }
.fq-section--general { background: var(--color-paper); }
.fq-section--services { background: var(--color-surface); }
.fq-section--pricing { background: var(--color-paper-2); }
.fq-section--process { background: var(--color-surface); }
.fq-cat { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1.5fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.fq-cat--reverse { grid-template-columns: minmax(0, 1.5fr) minmax(0, .85fr); }
.fq-cat--reverse .fq-cat__head { order: 2; }
.fq-cat__head { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.fq-cat__head h2 { margin: 0; }
.fq-cat__head .answer-block { margin: 0; font-size: var(--fs-small); }
.fq-cat__list { display: grid; }
.fq-cat__list .faq { padding-inline: var(--space-md); transition: background-color var(--transition); }
.fq-cat__list .faq:last-child { border-bottom: 1px solid var(--color-line); }
.fq-cat__list .faq[open] { background: var(--color-card-tint-1); border-top-color: var(--color-accent); }
.fq-cat__list .faq summary { min-height: 44px; }
.fq-cat__list .faq summary:hover { color: var(--color-accent-dark); }
.fq-cat__list .faq p { max-width: var(--measure); }
.fq-more { margin: var(--space-2) 0 0; font-size: var(--fs-small); }
.fq-cat__list .fq-more a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.fq-section--pricing .faq[open] { background: var(--color-surface); }
@media (max-width: 900px) {
  .fq-cat, .fq-cat--reverse { grid-template-columns: 1fr; }
  .fq-cat--reverse .fq-cat__head { order: 0; }
  .fq-cat__head { position: static; }
}

/* ---- Closing CTA ---- */
.fq-cta .container { align-items: center; }
.fq-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.fq-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="fq-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type fq-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">FAQ</span></li>
      </ol>
    </nav>
    <span class="eyebrow">FAQ &middot; <?php echo esc($fqCity . ', ' . $address['state']); ?></span>
    <h1 class="hero-title" id="hero-title">Plumbing questions <span class="text-accent">Seminole</span> customers ask</h1>
    <p class="hero-answer"><?php echo esc($siteName); ?> answers <?php echo count($fqAll); ?> common questions here about its hours, service area, drain cleaning, water heaters, leaks, sewer lines, cost and how a job runs. Something missing? Call <?php echo esc($fqPhone); ?>.</p>
    <div class="hero-actions">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($fqPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($fqPhone); ?></a>
      <a class="link-call" href="/contact/"><?php icon('mail', 18); ?> or send a question</a>
    </div>
    <ul class="fq-jump" aria-label="Jump to a topic">
<?php foreach ($faqCats as $fqKey => $fqCat): ?>
      <li><a href="#<?php echo esc($fqKey); ?>"><?php icon($fqCat['icon'], 16); ?> <?php echo esc($fqCat['label']); ?></a></li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<article>
<!-- ============================================================ GENERAL -->
<section class="section fq-section fq-section--general" id="general" aria-labelledby="general-title">
  <div class="container-wide">
<?php fq_render_category('general', $faqCats['general'], false); ?>
  </div>
</section>

<!-- ============================================================ MID-PAGE ESTIMATE BAND (the one form on this page) -->
<?php echo p1_cta_band_form([
    'eyebrow' => 'Free estimate',
    'heading' => 'Still have a plumbing problem?',
    'copy'    => 'Describe it and the ' . $brandName . ' office will call you back.',
]); ?>

<!-- ============================================================ SERVICES -->
<section class="section edge-curve-top fq-section fq-section--services" id="services" aria-labelledby="services-title">
  <div class="container">
<?php fq_render_category('services', $faqCats['services'], true); ?>
  </div>
</section>

<!-- ============================================================ PRICING -->
<section class="section fq-section fq-section--pricing" id="pricing" aria-labelledby="pricing-title">
  <div class="container-wide">
<?php fq_render_category('pricing', $faqCats['pricing'], false); ?>
  </div>
</section>

<!-- ============================================================ PROCESS -->
<section class="section slant-top fq-section fq-section--process" id="process" aria-labelledby="process-title">
  <div class="container">
<?php fq_render_category('process', $faqCats['process'], true); ?>
  </div>
</section>
</article>

<!-- ============================================================ CLOSING CTA -->
<section class="closing-cta texture-grain edge-wave-top fq-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Not on the list?</span>
      <h2 id="cta-title">Ask the Ledco Plumbing office directly</h2>
      <p>Call <?php echo esc($fqPhone); ?> any day from 7 AM to 5 PM, or send an estimate request with your question. If water is backing up or leaking right now, call.</p>
      <p class="fq-cta__links"><a href="/services/">See all five Ledco Plumbing services</a> &middot; <a href="/about/">About Ledco Plumbing</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($fqPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($fqPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
