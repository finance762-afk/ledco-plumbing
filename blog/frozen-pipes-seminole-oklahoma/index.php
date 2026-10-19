<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * blog/frozen-pipes-seminole-oklahoma/index.php — launch post 1 (seasonal / freeze).
 *
 * Facts in this post and where they come from:
 *   - Seminole January mean minimum 26.2 F, 43.19 in precipitation, 4.4 in snowfall: NOAA 1991-2020 normals as reported on
 *     https://en.wikipedia.org/wiki/Seminole,_Oklahoma
 *   - USDA 2023 hardiness zone 7b (5 to 10 F) for ZIP 74868: https://phzmapi.org/74868.json
 *   - Freeze-prevention steps (main shutoff, hoses, cabinet doors, dripping faucet, gentle thaw, never a flame) are standard
 *     plumbing guidance, not Ledco claims. No prices, response times or emergency-hours promises are made: after-hours service is
 *     unconfirmed (see /content-confirmations.json), so the FAQ states only the listed hours and the shutoff-first rule.
 *   - Company facts: office 316 E Oak Ave, owner, Mon-Sun 7 AM-5 PM, five services, price before work starts (config.php / homepage).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';

$postSlug = 'frozen-pipes-seminole-oklahoma';
$post     = p1_blog_post($postSlug);

$pageTitle       = $post['title'];
$pageDescription = 'Seminole\'s January lows average 26°F. See which pipes freeze first, what to do before a hard freeze, and the first steps when a pipe bursts.';
$canonicalUrl    = $siteUrl . '/blog/' . $postSlug . '/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$ogType          = 'article';
$currentPage     = 'blog';
$pageType        = 'blog';

$bpPhone = formatPhone($phone);
$bpBase  = rtrim($siteUrl, '/');

$bpToc = [
    ['id' => 'cold',   'label' => 'How cold does Seminole get?'],
    ['id' => 'before', 'label' => 'What to do before a hard freeze'],
    ['id' => 'burst',  'label' => 'What to do when a pipe bursts'],
    ['id' => 'hidden', 'label' => 'How to spot hidden freeze damage'],
    ['id' => 'faq',    'label' => 'Questions'],
];

$faqs = [
    [
        'q' => 'Should I let faucets drip in Seminole when it freezes?',
        'a' => 'Yes, on a hard-freeze night. A thin, steady drip from a faucet on an exterior wall keeps water moving through the pipe, and the extra water used overnight costs far less than a split pipe. Open the cabinet doors under that sink as well.',
    ],
    [
        'q' => 'What hours is Ledco Plumbing open if a pipe freezes?',
        'a' => 'The listed hours for Ledco Plumbing are Monday through Sunday, 7 AM to 5 PM, at ' . $bpPhone . '. Whatever the hour, close the main shutoff valve first: that stops the water and limits the damage while you reach a plumber.',
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
        'keywords'         => 'frozen pipes Seminole OK, burst pipe, freeze plumbing, main shutoff valve, leak detection',
        'articleSection'   => $post['category'],
        'author'           => ['@type' => 'Organization', 'name' => 'Page One Insights LLC', 'url' => 'https://pageoneinsights.com'],
        'publisher'        => ['@id' => schemaId('organization')],
        'mainEntityOfPage' => $canonicalUrl,
    ],
    ['@id' => $canonicalUrl . '#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['Blog', '/blog/'], [$post['title'], '/blog/' . $postSlug . '/']]),
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
        <li><span aria-current="page">Frozen pipes in Seminole</span></li>
      </ol>
    </nav>
    <header class="blog-post__header">
      <span class="bp-badge"><?php echo esc($post['category']); ?></span>
      <h1 class="hero-title" id="hero-title"><?php echo esc($post['title']); ?></h1>
      <p class="blog-post__meta"><time datetime="<?php echo esc($post['dateISO']); ?>"><?php echo esc($post['date']); ?></time> &middot; <?php echo esc($post['readtime']); ?> &middot; Published by Page One Insights LLC for <?php echo esc($siteName); ?></p>
    </header>
  </div>
</section>

<!-- ============================================================ POST -->
<div class="section bp-body">
  <div class="container-wide">
    <div class="bp-layout">
      <article class="bp-article">
        <figure class="blog-post__featured-image">
          <img src="<?php echo esc($post['image']); ?>" alt="<?php echo esc($post['alt']); ?>" width="960" height="504" loading="eager" decoding="async">
        </figure>
        <div class="blog-post__content">
          <p class="answer-block">Pipes in exterior walls, crawl spaces and outdoor hose bibs freeze first in Seminole. Before a hard freeze, disconnect hoses, open cabinet doors on exterior walls and let one faucet drip. If a pipe bursts, close the main shutoff valve first, then call a plumber.</p>

          <section id="cold" aria-labelledby="cold-title">
            <h2 id="cold-title">How cold does Seminole get, and which pipes freeze first?</h2>
            <p>Seminole's January nights average about 26&nbsp;&deg;F, and the USDA's 2023 map puts ZIP code 74868 in hardiness zone 7b, where the coldest night in a typical year falls between 5 and 10&nbsp;&deg;F. Those are averages, so an individual winter can run colder, and one hard night is enough to split a pipe.</p>
            <ul class="bp-figures" aria-label="Seminole winter figures">
              <li><b>26&nbsp;&deg;F</b><span>Average January low, NOAA 1991&ndash;2020</span></li>
              <li><b>Zone 7b</b><span>USDA 2023 map: coldest night usually 5 to 10&nbsp;&deg;F</span></li>
              <li><b>4.4 in</b><span>Average yearly snowfall in Seminole</span></li>
            </ul>
            <p>The pipes that freeze first are the ones outside the heated part of the house: supply lines in exterior walls, pipes in a crawl space or under the floor, outdoor hose bibs, and lines in an attic or an unheated garage. A sink cabinet on an exterior wall is the classic indoor weak spot, because the cabinet door keeps house heat away from the pipes behind it.</p>
            <p>Many Seminole buildings date to the late-1920s oil boom, which the <a href="/service-areas/seminole-ok/">Seminole plumbing page</a> covers. Pipe routed through an exterior wall in a building that old may have little insulation around it, so those walls deserve the first look before a freeze.</p>
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
    'heading' => 'Pipe leaking or a faucet not running?',
    'copy'    => 'Tell ' . $brandName . ' what you are seeing and the office will call you back.',
]); ?>

<div class="section bp-body">
  <div class="container-wide">
    <div class="bp-layout">
      <article class="bp-article">
        <div class="blog-post__content">
          <section id="before" aria-labelledby="before-title">
            <h2 id="before-title">What should you do before a hard freeze in Seminole?</h2>
            <p>Do five things the afternoon before a hard freeze: find and test the main shutoff, disconnect the hoses, open the cabinet doors on exterior walls, let one faucet drip, and leave the heat on. None needs a tool beyond a wrench.</p>
            <ol>
              <li><strong>Find the main shutoff and turn it once.</strong> Most homes have it where the water line enters the house, or in the meter box near the street. A valve that has never been turned can be stuck, and you want to learn that on a calm day.</li>
              <li><strong>Disconnect and drain garden hoses.</strong> A hose left on an outdoor spigot holds water against the faucet, and the freeze can split the spigot or the pipe behind it.</li>
              <li><strong>Open the cabinet doors</strong> under sinks on exterior walls, so room air reaches the pipes.</li>
              <li><strong>Let one faucet drip</strong>, a thin steady stream rather than a trickle, on an exterior wall or the far end of the house. Moving water is harder to freeze.</li>
              <li><strong>Keep the thermostat on</strong> at the setting you normally use, even if you are away for a few days.</li>
            </ol>
            <p>For a longer-term fix, foam sleeves on exposed pipe in a crawl space or garage cost little and slow a freeze. A water heater in an unheated garage or utility space is worth a look too; see <a href="/services/water-heater-repair-installation/">water heater repair and installation</a> if yours is leaking or running cold after a freeze.</p>
          </section>

          <section id="burst" aria-labelledby="burst-title">
            <h2 id="burst-title">What do you do first when a pipe freezes or bursts?</h2>
            <p>Close the main shutoff valve first. That stops the water, which is what does the damage, and it gives you time to find the problem. Then open a faucet to drain the line and call a plumber.</p>
            <ol>
              <li><strong>Close the main shutoff valve</strong> if water is flowing anywhere it should not be.</li>
              <li><strong>Open a faucet</strong> at the lowest point in the house to let the line drain.</li>
              <li><strong>If a faucet runs dry, thaw the pipe slowly.</strong> A hair dryer or warm towels on the pipe work. Never use an open flame, which can start a fire or damage the pipe.</li>
              <li><strong>Call a plumber</strong> at <a href="<?php echo esc(phoneHref($phone)); ?>"><?php echo esc($bpPhone); ?></a>, and describe where the pipe is and whether water is still running.</li>
            </ol>
            <p>What the repair costs depends on where the pipe is and what it needs, which the <a href="/blog/plumbing-repair-cost-seminole-ok/">guide to plumbing repair cost in Seminole</a> walks through.</p>
          </section>

          <section id="hidden" aria-labelledby="hidden-title">
            <h2 id="hidden-title">How can you tell if a freeze damaged a pipe you cannot see?</h2>
            <p>Check three things after the thaw: the water meter with every fixture off, the walls and ceilings under the coldest pipes, and the water bill. A split pipe often does not leak until the ice melts, so the damage can show a day or more after the freeze ends.</p>
            <p>If the meter dial moves with everything off, or a ceiling stain appears under a bathroom or an exterior wall, a pipe is leaking. Finding which pipe, without opening every wall, is what <a href="/services/leak-detection-repair/">leak detection and repair</a> is for. Ledco Plumbing works from its office at 316 E Oak Ave in Seminole and takes calls Monday through Sunday, 7 AM to 5 PM.</p>
          </section>

          <section id="faq" class="bp-faq" aria-labelledby="faq-title">
            <h2 id="faq-title">What do Seminole homeowners ask about freezing pipes?</h2>
            <p>Seminole homeowners mostly ask whether a dripping faucet really helps and when the plumber's office is open. Both answers are below.</p>
<?php foreach ($faqs as $bpFaqIdx => $bpFaq): ?>
            <details class="faq"<?php echo $bpFaqIdx === 0 ? ' open' : ''; ?>>
              <summary><?php echo esc($bpFaq['q']); ?></summary>
              <p><?php echo esc($bpFaq['a']); ?></p>
            </details>
<?php endforeach; ?>
          </section>
          <p class="bp-byline">Published by Page One Insights LLC for <?php echo esc($siteName); ?> on <?php echo esc($post['date']); ?>. Winter figures are NOAA 1991&ndash;2020 normals as reported on Wikipedia and the USDA 2023 hardiness map by ZIP code.</p>
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
          <li><a href="/services/leak-detection-repair/">Leak detection &amp; repair <span aria-hidden="true">&rarr;</span></a></li>
          <li><a href="/services/water-heater-repair-installation/">Water heater repair &amp; installation <span aria-hidden="true">&rarr;</span></a></li>
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
