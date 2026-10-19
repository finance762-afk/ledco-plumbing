<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * blog/plumbing-repair-cost-seminole-ok/index.php — launch post 2 (cost guide).
 *
 * NO DOLLAR FIGURES: intake holds no pricing (estimate_tool.pricing is empty and the owner has not approved a range), so this post
 * explains what moves a price and what an estimate should show. Per blog-standard.md section 7, a number the client did not give is
 * never printed. Owner prices go in /content-confirmations.json; add a "typical range" table here once Mickey Ledbetter approves one.
 *
 * Facts and sources:
 *   - Price after a plumber has seen the problem, and you see it before work starts: homepage process step + /services/ pricing section.
 *   - Water heater cost varies with tank size and fuel type; many Oklahoma homes have hard water: build-plan research_brief FAQs.
 *   - Late-1920s oil-boom buildings and typical pipe materials of that era: https://en.wikipedia.org/wiki/Seminole,_Oklahoma
 *     (population jump after the 1926 strike) and general plumbing history, hedged in the copy ("commonly", "may").
 *   - Whether estimates are free or written, and any trip fee, are unconfirmed (content-confirmations.json), so the post never states them.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';

$postSlug = 'plumbing-repair-cost-seminole-ok';
$post     = p1_blog_post($postSlug);

$pageTitle       = $post['title'];
$pageDescription = 'Four things set plumbing repair cost in Seminole, OK: the cause, the pipe\'s location, the parts and the building. See what an estimate should show.';
$canonicalUrl    = $siteUrl . '/blog/' . $postSlug . '/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$ogType          = 'article';
$currentPage     = 'blog';
$pageType        = 'blog';

$bpPhone = formatPhone($phone);
$bpBase  = rtrim($siteUrl, '/');

$bpToc = [
    ['id' => 'factors',  'label' => 'The four things that set the price'],
    ['id' => 'older',    'label' => 'Why older buildings change an estimate'],
    ['id' => 'heater',   'label' => 'Water heater: repair or replace?'],
    ['id' => 'what-estimate', 'label' => 'What an estimate should tell you'],
    ['id' => 'early',    'label' => 'Keeping a repair small'],
    ['id' => 'faq',      'label' => 'Questions'],
];

$faqs = [
    [
        'q' => 'Does Ledco Plumbing publish a price list?',
        'a' => 'No. Ledco Plumbing LLC does not print a price list on this site, because the price depends on what is wrong, where the pipe is and which parts it needs. The company prices a job after a plumber has seen the problem, and you see the price before any work starts. Call ' . $bpPhone . ' to start.',
    ],
    [
        'q' => 'Why do two plumbers quote different prices for the same problem?',
        'a' => 'Often they are quoting different repairs. One may clear a clog while the other replaces the section of pipe that keeps clogging, or one price may include parts that the other leaves out. Ask each plumber what the price covers and what could change it.',
    ],
];

$pageSchema = [
    [
        '@type'            => 'BlogPosting',
        '@id'              => $canonicalUrl . '#article',
        'headline'         => $post['title'],
        'description'      => $pageDescription,
        'image'            => $bpBase . '/assets/images/og-default-v1.jpg',
        'datePublished'    => $post['dateISO'],
        'dateModified'     => $post['dateISO'],
        'keywords'         => 'plumbing repair cost Seminole OK, plumber estimate, water heater repair or replace, older home plumbing',
        'articleSection'   => $post['category'],
        'author'           => ['@type' => 'Organization', 'name' => 'Page One Insights LLC', 'url' => 'https://pageoneinsights.com'],
        'publisher'        => ['@id' => schemaId('organization')],
        'mainEntityOfPage' => $canonicalUrl,
    ],
    ['@id' => $canonicalUrl . '#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['Blog', '/blog/'], [$post['title'], '/blog/' . $postSlug . '/']]),
    generateFAQSchema($faqs),
];
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-post-style.php'; ?>

<div class="bp-page">
<!-- ============================================================ HEADER -->
<section class="hero hero--interior hero--type bp-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/blog/">Blog</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Plumbing repair cost in Seminole</span></li>
      </ol>
    </nav>
    <header class="blog-post__header">
      <span class="bp-badge"><?php echo esc($post['category']); ?></span>
      <h1 class="hero-title" id="hero-title"><?php echo esc($post['title']); ?></h1>
      <p class="blog-post__meta"><time datetime="<?php echo esc($post['dateISO']); ?>"><?php echo esc($post['date']); ?></time> &middot; <?php echo esc($post['readtime']); ?> &middot; Published by Page One Insights LLC for <?php echo esc($siteName); ?></p>
    </header>
  </div>
</section>

<!-- ============================================================ POST, PART 1 -->
<div class="section bp-body">
  <div class="container-wide">
    <div class="bp-layout">
      <article class="bp-article">
        <figure class="blog-post__featured-image">
          <img src="<?php echo esc($post['image']); ?>" alt="<?php echo esc($post['alt']); ?>" width="960" height="504" loading="eager" decoding="async">
        </figure>
        <div class="blog-post__content">
          <p class="answer-block">Four things set the price of a plumbing repair in Seminole: what is actually wrong, where the pipe is, which parts it needs, and whether the building is a home or a business. Ledco Plumbing LLC prices a job after a plumber has seen it, and you see the price before work starts.</p>

          <section id="factors" aria-labelledby="factors-title">
            <h2 id="factors-title">What four things decide the price of a plumbing repair?</h2>
            <p>The cause, the location, the parts and the type of building decide the price. Two jobs that sound alike on the phone, such as "a slow drain," can land far apart once a plumber sees which of the four applies. That is why a quote over the phone without a look is a guess.</p>
            <ol>
              <li><strong>The cause.</strong> A clog, a worn part, a split pipe and a failed tank are different repairs. A drain that is slow in one fixture is a smaller job than one that backs up in several; see <a href="/services/drain-cleaning/">drain cleaning</a> for how a plumber tells them apart.</li>
              <li><strong>Where it is.</strong> A pipe under a sink is a short job. The same pipe inside a wall, under a slab or out in the yard takes more time to reach, and the cost of reaching it is part of the price.</li>
              <li><strong>The parts.</strong> A flapper, a heating element and a new water heater are very different line items. Water heater cost also varies with tank size and fuel type.</li>
              <li><strong>Home or business.</strong> Commercial fixtures, after-hours access and who has to approve the estimate can change a job. <a href="/services/commercial-plumbing/">Commercial plumbing</a> calls go faster when the office knows who can let the plumber in.</li>
            </ol>
          </section>
        </div>
      </article>
<?php $bpSidebarMode = 'full'; include $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-sidebar.php'; ?>
    </div>
  </div>
</div>

<!-- ============================================================ MID-PAGE ESTIMATE BAND (the one form on this page) -->
<?php echo p1_cta_band_form([
    'eyebrow' => 'Free estimate',
    'heading' => 'Want the price for your Seminole plumbing problem?',
    'copy'    => 'Tell ' . $brandName . ' what you are seeing and the office will call you back.',
]); ?>

<!-- ============================================================ POST, PART 2 -->
<div class="section bp-body">
  <div class="container-wide">
    <div class="bp-layout">
      <article class="bp-article">
        <div class="blog-post__content">
          <section id="older" aria-labelledby="older-title">
            <h2 id="older-title">Why do older Seminole buildings change a plumbing estimate?</h2>
            <p>Older buildings change an estimate because the pipe's condition and the access to it are unknown until a plumber looks. Seminole grew fast after a 1926 oil strike, so many of its houses and storefronts are close to a century old, and pipe from that era is commonly galvanized steel on the supply side and cast iron on the drain side.</p>
            <p>Both materials wear from the inside. A plumber can say what is likely, but the real scope shows once the pipe is in view: replacing one worn section can expose the next one. That is why a repair in an older building is priced after the look, not before it. The <a href="/service-areas/seminole-ok/">Seminole plumbing page</a> covers the boom-era buildings in detail, and <a href="/services/leak-detection-repair/">leak detection and repair</a> is the service that finds a leak inside a wall without opening every wall.</p>
          </section>

          <section id="heater" aria-labelledby="heater-title">
            <h2 id="heater-title">How do you tell a water heater repair from a replacement?</h2>
            <p>Repair a water heater when a part has failed and the tank is sound; replace it when the tank itself is leaking, because a leaking tank cannot be patched. Age and mineral scale matter too, and the repair-or-replace call is where a water heater estimate changes the most.</p>
            <p>Many Oklahoma homes have hard water, which leaves scale in the tank and wears a heater out early, so a heater that rumbles or runs short of hot water is worth looking at before it fails. See <a href="/services/water-heater-repair-installation/">water heater repair and installation</a> for the signs and the steps of a visit.</p>
          </section>

          <section id="what-estimate" aria-labelledby="estimate-title">
            <h2 id="estimate-title">What should a plumbing estimate tell you before you say yes?</h2>
            <p>A good estimate tells you five things: what the plumber found, what work the price includes, which parts are in it, the total, and what could change it. If any of the five is missing, ask. You decide whether to go ahead after you have seen the price.</p>
            <ul>
              <li>What the plumber found, in plain words, and what caused it.</li>
              <li>What work the price covers, and what it leaves out.</li>
              <li>Which parts are included, such as a new valve or a new water heater.</li>
              <li>The total price for that work.</li>
              <li>What could change the price, such as a pipe that turns out to be worse than it looked.</li>
            </ul>
            <p>Ask for it in writing or by email if you want a record. Ledco Plumbing LLC gives the price before work starts; call the Seminole office at <a href="<?php echo esc(phoneHref($phone)); ?>"><?php echo esc($bpPhone); ?></a> to describe the problem.</p>
          </section>

          <section id="early" aria-labelledby="early-title">
            <h2 id="early-title">How can you keep a small plumbing problem from getting expensive?</h2>
            <p>Act on the early signs: a drain that comes back within a week, a water meter that moves with everything off, a damp spot that returns. Small problems are usually the cheapest to fix, and a leak left running for weeks can mean a bigger repair and a bigger water bill.</p>
            <p>Seasonal timing matters in Seminole too. A pipe that freezes can split and leak after the thaw, which the guide to <a href="/blog/frozen-pipes-seminole-oklahoma/">keeping pipes from freezing in Seminole</a> covers, including what to do the night before a hard freeze.</p>
          </section>

          <section id="faq" class="bp-faq" aria-labelledby="faq-title">
            <h2 id="faq-title">What do Seminole customers ask about plumbing costs?</h2>
            <p>Seminole customers mostly ask whether Ledco Plumbing has a price list and why quotes differ between plumbers. Both answers are below.</p>
<?php foreach ($faqs as $bpFaqIdx => $bpFaq): ?>
            <details class="faq"<?php echo $bpFaqIdx === 0 ? ' open' : ''; ?>>
              <summary><?php echo esc($bpFaq['q']); ?></summary>
              <p><?php echo esc($bpFaq['a']); ?></p>
            </details>
<?php endforeach; ?>
          </section>
          <p class="bp-byline">Published by Page One Insights LLC for <?php echo esc($siteName); ?> on <?php echo esc($post['date']); ?>. This guide gives no dollar figures: prices depend on the job, and Ledco Plumbing quotes each one after a plumber has seen it.</p>
        </div>
      </article>
<?php $bpSidebarMode = 'cta'; include $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-sidebar.php'; ?>
    </div>
  </div>
</div>

<!-- ============================================================ RELATED -->
<section class="section bp-related" aria-label="Related services and articles">
  <div class="container">
    <div class="bp-related__grid">
      <div class="blog-post__related-services">
        <h2>Related services</h2>
        <ul class="bp-related__links">
          <li><a href="/services/water-heater-repair-installation/">Water heater repair &amp; installation <span aria-hidden="true">&rarr;</span></a></li>
          <li><a href="/services/leak-detection-repair/">Leak detection &amp; repair <span aria-hidden="true">&rarr;</span></a></li>
          <li><a href="/services/sewer-line-repair/">Sewer line repair <span aria-hidden="true">&rarr;</span></a></li>
          <li><a href="/service-areas/seminole-ok/">Plumbing in Seminole, OK <span aria-hidden="true">&rarr;</span></a></li>
          <li><a href="/contact/">Contact Ledco Plumbing <span aria-hidden="true">&rarr;</span></a></li>
        </ul>
      </div>
      <div class="blog-post__related-articles">
        <h2>Related articles</h2>
        <div class="blog-grid">
<?php foreach (p1_blog_related($postSlug, 2) as $bpRel) p1_blog_card($bpRel, 'reveal-up'); ?>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
