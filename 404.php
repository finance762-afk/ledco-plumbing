<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * 404.php — friendly error page (served by .htaccess ErrorDocument 404 /404.php).
 * Sends a real 404 status, is noindex, and links only to pages that exist on disk (pageLive / serviceLive).
 * There is no site search on this build, so the "search suggestion" is a what-were-you-after list that routes by
 * problem to the right service page, plus a typo tip.
 */
http_response_code(404);

$pageTitle       = 'Page Not Found | Ledco Plumbing LLC, Seminole, OK';
$pageDescription = 'That page was not found. Use these links to reach Ledco Plumbing services in Seminole, OK, or call ' . $phone . '.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = '404';
$pageType        = 'other';
$noindex         = true;

$nfPhone     = formatPhone($phone);
$nfPhoneHref = phoneHref($phone);

// Symptom -> service slug (only rendered when that service page exists)
$nfFinder = [
    ['A drain that is slow or backing up',      'drain-cleaning',                    'droplets'],
    ['A water heater with no hot water or a leak', 'water-heater-repair-installation', 'flame'],
    ['A high water bill or a damp spot',        'leak-detection-repair',             'search'],
    ['Sewage or dirty water coming up',         'sewer-line-repair',                 'waves'],
    ['Plumbing at a shop, office or rental',    'commercial-plumbing',               'building-2'],
];
$nfPages = [['Home', '/', 'house']];
if (pageLive('/services/')) $nfPages[] = ['All services', '/services/', 'wrench'];
if (pageLive('/about/'))    $nfPages[] = ['About Ledco Plumbing', '/about/', 'handshake'];
if (pageLive('/faq/'))      $nfPages[] = ['Plumbing FAQ', '/faq/', 'info'];
if (pageLive('/contact/'))  $nfPages[] = ['Contact and map', '/contact/', 'map-pin'];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   404 — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.nf-page h1, .nf-page h2, .nf-page h3 { text-wrap: balance; }
.nf-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 100%); }
.nf-hero::before {
  content: "404";
  position: absolute;
  right: clamp(var(--space-md), 6vw, var(--space-4xl));
  bottom: calc(-1 * var(--space-lg));
  z-index: -1;
  font-family: var(--font-accent);
  font-weight: 700;
  font-size: clamp(8rem, 5rem + 18vw, 20rem);
  line-height: 1;
  letter-spacing: .02em;
  color: color-mix(in srgb, var(--color-white) 6%, transparent);
  pointer-events: none;
}
.nf-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side at 80% 40%, color-mix(in srgb, var(--color-accent) 24%, transparent), transparent 70%);
}
.nf-hero .grain { opacity: .3; }
.nf-hero .hero-title { max-width: 20ch; margin-top: var(--space-2); }
.nf-hero .hero-answer { max-width: 36rem; margin-top: var(--space-sm); }
.nf-hero .hero-actions { margin-top: var(--space-md); }
.nf-hero .link-call { color: var(--color-white); }

.nf-find { background: var(--color-paper); }
.nf-find__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.4fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.nf-find__tip { margin: 0; font-size: var(--fs-small); color: var(--color-muted); }
.nf-list { display: grid; gap: var(--space-2); margin: 0; padding: 0; list-style: none; }
.nf-list a { text-decoration: none; display: flex; align-items: center; gap: var(--space-md); min-height: 56px; padding: var(--space-sm) var(--space-md); border-radius: var(--radius); border: 1px solid var(--color-line); background: var(--color-surface); font-weight: 600; transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition); }
.nf-list a:hover { transform: translateX(var(--space-1)); border-color: var(--color-accent); box-shadow: var(--shadow); }
.nf-list li:nth-child(3n+1) a { background: var(--color-card-tint-1); }
.nf-list li:nth-child(3n+2) a { background: var(--color-card-tint-2); }
.nf-list li:nth-child(3n) a { background: var(--color-card-tint-3); }
.nf-list svg { flex: 0 0 auto; color: var(--color-accent-dark); }
.nf-list .nf-arrow { margin-left: auto; color: var(--color-muted); }

.nf-pages { background: var(--color-surface); }
.nf-pages .badge-strip { gap: var(--space-sm); }
.nf-pages .badge-strip a { text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2); min-height: 44px; padding: var(--space-2) var(--space-md); border-radius: var(--radius-full); border: 1px solid var(--color-line); background: var(--color-paper); font-weight: 600; font-size: var(--fs-small); transition: border-color var(--transition), background-color var(--transition); }
.nf-pages .badge-strip a:hover { border-color: var(--color-accent); background: var(--color-card-tint-3); }
.nf-pages .badge-strip svg { color: var(--color-primary); }
@media (max-width: 900px) { .nf-find__grid { grid-template-columns: 1fr; } }
</style>

<div class="nf-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type nf-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <span class="eyebrow">Error 404</span>
    <h1 class="hero-title" id="hero-title">That page is not <span class="text-accent">here</span></h1>
    <p class="hero-answer">The page you asked for has moved or never existed. Ledco Plumbing's services, FAQ and contact details are one click away below, or call <?php echo esc($nfPhone); ?> and the office will help directly.</p>
    <div class="hero-actions">
      <a class="btn btn-accent btn-lg" href="/"><?php icon('house', 18); ?> Back to the homepage</a>
      <a class="link-call" href="<?php echo esc($nfPhoneHref); ?>"><?php icon('phone', 18); ?> or call <?php echo esc($nfPhone); ?></a>
    </div>
  </div>
</section>

<!-- ============================================================ FIND IT -->
<section class="section nf-find" aria-labelledby="find-title">
  <div class="container">
    <div class="nf-find__grid">
      <div class="section-title">
        <span class="eyebrow-label">What were you looking for?</span>
        <h2 id="find-title">Which plumbing problem brought you to <span class="text-accent">Ledco Plumbing</span>?</h2>
        <p class="answer-block">Pick the problem that matches what you are seeing and the link goes to the Ledco Plumbing page for it. Ledco Plumbing LLC repairs drains, water heaters, leaks, sewer lines and commercial plumbing in Seminole and Wewoka.</p>
        <p class="nf-find__tip">Typed the address by hand? Check it for typos, then try again.</p>
      </div>
      <ul class="nf-list">
<?php foreach ($nfFinder as $nfRow): if (!serviceLive($nfRow[1])) continue; ?>
        <li><a href="/services/<?php echo esc($nfRow[1]); ?>/"><?php icon($nfRow[2], 22); ?><span><?php echo esc($nfRow[0]); ?></span><?php icon('arrow-right', 18, 'nf-arrow'); ?></a></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============================================================ POPULAR PAGES -->
<section class="section edge-curve-top nf-pages" aria-labelledby="pages-title">
  <div class="container">
    <div class="section-title">
      <span class="eyebrow-label">Popular pages</span>
      <h2 id="pages-title">Where do most Seminole visitors go on this site?</h2>
    </div>
    <div class="badge-strip">
<?php foreach ($nfPages as $nfPage): ?>
      <a href="<?php echo esc($nfPage[1]); ?>"><?php icon($nfPage[2], 18); ?> <?php echo esc($nfPage[0]); ?></a>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ CTA -->
<section class="closing-cta texture-grain edge-wave-top" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Still stuck?</span>
      <h2 id="cta-title">Tell Ledco Plumbing what you need</h2>
      <p>Call <?php echo esc($nfPhone); ?> any day from 7 AM to 5 PM, or send a request and the office will call you back.</p>
    </div>
    <div class="actions">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($nfPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($nfPhone); ?></a>
<?php if (pageLive('/contact/')): ?>
      <a class="btn btn-outline-white btn-lg" href="/contact/">Contact Ledco Plumbing</a>
<?php else: ?>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Request an estimate'), "\n"; ?>
<?php endif; ?>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
