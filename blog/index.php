<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * blog/index.php — registry-driven blog index (Phase 6). Every card comes from $blogPosts in includes/blog-data.php;
 * never hardcode a post here. The full topic cluster is grown after launch via the design-portal Blogs tab.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';

$pageTitle       = 'Plumbing Guides for Seminole, OK | Ledco Plumbing Blog';
$pageDescription = 'Plain-language plumbing guides for Seminole, OK homeowners from Ledco Plumbing: freeze protection, repair costs and what to do before you call a plumber.';
$canonicalUrl    = $siteUrl . '/blog/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'blog';
$pageType        = 'blog';

$blBase = rtrim($siteUrl, '/');
$blItems = [];
foreach ($blogPosts as $blPos => $blPost) {
    $blItems[] = ['@type' => 'ListItem', 'position' => $blPos + 1, 'name' => $blPost['title'], 'url' => $blBase . '/blog/' . $blPost['slug'] . '/'];
}
$pageSchema = [
    [
        '@type'       => 'CollectionPage',
        '@id'         => $blBase . '/blog/#webpage',
        'url'         => $blBase . '/blog/',
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'isPartOf'    => ['@id' => schemaId('website')],
        'about'       => ['@id' => schemaId('organization')],
        'breadcrumb'  => ['@id' => $blBase . '/blog/#breadcrumb'],
        'mainEntity'  => ['@type' => 'ItemList', 'name' => $siteName . ' blog', 'itemListElement' => $blItems],
    ],
    ['@id' => $blBase . '/blog/#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['Blog', '/blog/']]),
];
$schemaMarkup = $pageSchema;

$blPhone = formatPhone($phone);
$blFeatured = $blogPosts[0] ?? null;
$blRest = array_slice((array) $blogPosts, 1);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   blog/index.php — blog index composition (minimal-tech). Tokens only.
   ============================================================================ */
.bl-page h1, .bl-page h2, .bl-page h3 { text-wrap: balance; }
.bl-page p { text-wrap: pretty; }

.bl-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 100%); }
.bl-hero::before { content: ""; position: absolute; inset: 0 -5% 0 58%; z-index: -1; pointer-events: none; background: repeating-linear-gradient(0deg, transparent 0 var(--space-xl), color-mix(in srgb, var(--color-white) 6%, transparent) var(--space-xl) calc(var(--space-xl) + 1px)); -webkit-mask-image: linear-gradient(100deg, transparent 5%, var(--color-black) 70%); mask-image: linear-gradient(100deg, transparent 5%, var(--color-black) 70%); }
.bl-hero::after { content: ""; position: absolute; inset: -30% -10% auto 55%; height: 130%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 24%, transparent), transparent 72%); }
.bl-hero .grain { opacity: .3; }
.bl-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.bl-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.bl-hero .breadcrumb a:hover, .bl-hero .breadcrumb [aria-current] { color: var(--color-white); }
.bl-hero__inner { display: grid; gap: var(--space-md); max-width: 46rem; }
.bl-hero .hero-title { max-width: 22ch; }
.bl-hero .hero-answer { max-width: 40rem; }
.bl-hero .link-call { color: var(--color-white); }
@media (max-width: 560px) { .bl-hero .hero-answer { font-size: var(--fs-body); } }

.bl-posts { background: var(--color-paper); }
.bl-posts .section-title { max-width: 66ch; }
.bl-featured { display: grid; margin-bottom: var(--space-lg); }
.bl-featured .blog-card { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); }
.bl-featured .blog-card__image { aspect-ratio: auto; min-height: 100%; }
.bl-featured .blog-card__body { padding: var(--space-xl); align-content: center; gap: var(--space-sm); }
.bl-featured .blog-card__title { font-size: var(--fs-h2); }
.bl-featured .blog-card__excerpt { font-size: var(--fs-body); }
.bl-posts .blog-card { transition: transform var(--transition), box-shadow var(--transition); }
.bl-posts .blog-card:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow-lg); }
.bl-posts .blog-card:nth-child(3n+1) .blog-card__body { background: var(--color-card-tint-1); }
.bl-posts .blog-card:nth-child(3n+2) .blog-card__body { background: var(--color-card-tint-2); }
.bl-posts .blog-card:nth-child(3n) .blog-card__body { background: var(--color-card-tint-3); }
.bl-featured .blog-card .blog-card__body { background: var(--color-card-tint-3); }
.bl-posts .blog-card__cta { color: var(--color-accent-dark); }
@media (max-width: 760px) { .bl-featured .blog-card { grid-template-columns: 1fr; } .bl-featured .blog-card__image { aspect-ratio: 16 / 10; } }

.bl-help .container { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: center; }
.bl-help .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.bl-help__list { margin: 0; padding: 0; list-style: none; display: grid; gap: var(--space-sm); }
.bl-help__list a { display: flex; justify-content: space-between; gap: var(--space-sm); padding: var(--space-md) var(--space-lg); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); background: color-mix(in srgb, var(--color-white) 4%, transparent); color: var(--color-white); font-family: var(--font-heading); transition: border-color var(--transition), transform var(--transition); }
.bl-help__list a:hover { border-color: var(--color-accent-bright); transform: translateX(var(--space-1)); }
@media (max-width: 900px) { .bl-help .container { grid-template-columns: 1fr; } }

.bl-cta .container { align-items: center; }
.bl-cta .bl-cta__links { margin: var(--space-sm) 0 0; font-size: var(--fs-small); }
.bl-cta .bl-cta__links a { color: var(--color-accent-bright); }
</style>

<div class="bl-page">
<section class="hero hero--interior hero--type bl-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Blog</span></li>
      </ol>
    </nav>
    <div class="bl-hero__inner">
      <span class="eyebrow">Seminole, OK &middot; Plumbing guides</span>
      <h1 class="hero-title" id="hero-title"><span class="text-accent">Plumbing guides</span> for Seminole, OK homeowners</h1>
      <p class="hero-answer">Ledco Plumbing writes short, plain-language guides for Seminole and Wewoka homeowners: how to protect pipes before a freeze and what decides the price of a repair.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="<?php echo esc(phoneHref($phone)); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($blPhone); ?></a>
        <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
      </div>
    </div>
  </div>
</section>

<section class="section bl-posts" id="articles" aria-labelledby="articles-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">Latest articles</span>
      <h2 id="articles-title">What can you learn from the <span class="text-accent">Ledco Plumbing</span> blog?</h2>
      <p class="answer-block">The Ledco Plumbing blog answers the questions Seminole homeowners ask before they call a plumber, using local weather figures and the age of the town's buildings instead of generic advice. Each article links to the service that fixes the problem it describes.</p>
    </div>
<?php if ($blFeatured): ?>
    <div class="bl-featured reveal-up">
<?php p1_blog_card($blFeatured, '', true); ?>
    </div>
<?php endif; ?>
<?php if ($blRest): ?>
    <div class="blog-grid">
<?php foreach ($blRest as $blCardPost) p1_blog_card($blCardPost, 'reveal-up'); ?>
    </div>
<?php endif; ?>
  </div>
</section>

<section class="section on-dark texture-grain slant-top bl-help" aria-labelledby="help-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Need a plumber now?</span>
      <h2 id="help-title">Which service matches the problem in your article?</h2>
      <p class="answer-block">If an article describes what you are seeing, the matching service page lists the warning signs, the scope and the steps of a visit. Ledco Plumbing offers five services in Seminole and Wewoka and takes calls Monday through Sunday, 7 AM to 5 PM.</p>
    </div>
    <ul class="bl-help__list reveal-right">
<?php foreach ((array) $services as $blSvc): if (!serviceLive($blSvc['slug'])) continue; ?>
      <li><a href="/services/<?php echo esc($blSvc['slug']); ?>/"><span><?php echo esc($blSvc['name']); ?></span><span aria-hidden="true">&rarr;</span></a></li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="closing-cta texture-grain edge-wave-top bl-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="cta-title">Ready to talk to a Seminole plumber?</h2>
      <p>Call Ledco Plumbing at <?php echo esc($blPhone); ?> or request an estimate online. Water running where it should not? Close the main shutoff valve first, then call.</p>
      <p class="bl-cta__links"><a href="/service-areas/">See where Ledco Plumbing works</a></p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneE164); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($blPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
