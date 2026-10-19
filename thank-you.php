<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * thank-you.php — form confirmation. Every form's _next is {siteUrl}/thank-you (the extensionless URL is rewritten
 * to this file). noindex, not in the sitemap, not linked from navigation.
 * Promises only what the site already states: the office calls the number given, hours are 7 AM-5 PM daily, the price
 * comes before the work. No response-time promise (not in intake). The Google review link is from build-plan
 * integrations.review_request_url.
 */
$pageTitle       = 'Thank You | Ledco Plumbing LLC, Seminole, OK';
$pageDescription = 'Your request reached Ledco Plumbing LLC in Seminole, OK. The office will call the number you gave. For a leak or backup right now, call ' . $phone . '.';
$canonicalUrl    = $siteUrl . '/thank-you';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'thank-you';
$pageType        = 'other';
$noindex         = true;

$tyPhone     = formatPhone($phone);
$tyPhoneHref = phoneHref($phone);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ============================================================================
   thank-you — page composition (minimal-tech). Tokens only.
   ============================================================================ */
.ty-page h1, .ty-page h2, .ty-page h3 { text-wrap: balance; }
.ty-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 100%); }
.ty-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(closest-side at 78% 45%, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 72%);
}
.ty-hero .grain { opacity: .3; }
.ty-hero__check { display: inline-grid; place-items: center; width: var(--space-16); height: var(--space-16); border-radius: var(--radius-full); background: color-mix(in srgb, var(--color-accent) 22%, transparent); border: 2px solid var(--color-accent-bright); color: var(--color-accent-bright); margin-bottom: var(--space-md); }
.ty-hero .hero-title { max-width: 22ch; margin-top: var(--space-2); }
.ty-hero .hero-answer { max-width: 38rem; margin-top: var(--space-sm); }
.ty-hero .hero-actions { margin-top: var(--space-md); }
.ty-hero .link-call { color: var(--color-white); }

.ty-next { background: var(--color-paper); }
.ty-next__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr); gap: clamp(var(--space-xl), 5vw, var(--space-4xl)); align-items: start; }
.ty-next .next-steps li { padding-left: var(--space-8); }
.ty-urgent { display: grid; gap: var(--space-2); padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-card-tint-3); border: 1px solid var(--color-line); border-left: 3px solid var(--color-accent); }
.ty-urgent h3 { margin: 0; }
.ty-urgent p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.ty-urgent a { color: var(--color-primary); font-weight: 600; }

.ty-more { background: var(--color-surface); }
.ty-more__list { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ty-more__list a { text-decoration: none; display: grid; gap: var(--space-2); align-content: start; height: 100%; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); transition: transform var(--transition), box-shadow var(--transition); }
.ty-more__list a:hover { transform: translateY(calc(-1 * var(--space-1))); box-shadow: var(--shadow); }
.ty-more__list li:nth-child(3n+1) a { background: var(--color-card-tint-1); }
.ty-more__list li:nth-child(3n+2) a { background: var(--color-card-tint-2); }
.ty-more__list li:nth-child(3n) a { background: var(--color-card-tint-3); }
.ty-more__list svg { color: var(--color-accent-dark); }
.ty-more__list b { font-family: var(--font-heading); font-size: var(--fs-h3); color: var(--color-ink); }
.ty-more__list span { font-size: var(--fs-small); color: var(--color-ink-2); }
.ty-more__foot { margin: var(--space-xl) 0 0; font-size: var(--fs-small); }
.ty-more__foot a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 900px) { .ty-next__grid { grid-template-columns: 1fr; } .ty-more__list { grid-template-columns: 1fr; } }

.ty-review { background: var(--color-dark); }
.ty-review .container { align-items: center; }
</style>

<div class="ty-page">
<!-- ============================================================ HERO -->
<section class="hero hero--interior hero--type ty-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <span class="ty-hero__check" aria-hidden="true"><?php icon('check-circle', 32); ?></span>
    <span class="eyebrow">Request received</span>
    <h1 class="hero-title" id="hero-title">Thank you. <span class="text-accent">Ledco Plumbing</span> has your request</h1>
    <p class="hero-answer">The Ledco Plumbing office will call the phone number you gave. It is open Monday through Sunday, 7 AM to 5 PM.</p>
    <div class="hero-actions">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($tyPhoneHref); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($tyPhone); ?></a>
      <a class="link-call" href="/"><?php icon('house', 18); ?> or back to the homepage</a>
    </div>
  </div>
</section>

<!-- ============================================================ WHAT HAPPENS NEXT -->
<section class="section ty-next" aria-labelledby="next-title">
  <div class="container">
    <div class="ty-next__grid">
      <div class="section-title">
        <span class="eyebrow-label">What happens next</span>
        <h2 id="next-title">What should I expect after sending my <span class="text-accent">request</span>?</h2>
        <p class="answer-block">After you send a request, <?php echo esc($siteName); ?> reads it and calls you to set up a visit. A plumber looks at the problem, and you see the price before any work starts.</p>
        <aside class="ty-urgent" aria-labelledby="urgent-title">
          <h3 id="urgent-title">Water leaking or backing up right now?</h3>
          <p>Close the main shutoff valve, usually where the water line enters the house or in the meter box near the street, then call <a href="<?php echo esc($tyPhoneHref); ?>"><?php echo esc($tyPhone); ?></a>. A call reaches the office faster than a form.</p>
        </aside>
      </div>
      <ol class="next-steps">
        <li><strong>The office reads your request</strong>Your problem, the service you picked and your phone number arrive together.</li>
        <li><strong>You get a call</strong>The office phones you to ask anything it needs and to set up a visit. Keep your phone nearby.</li>
        <li><strong>A plumber looks at it</strong>The drain, line, leak or water heater is checked at your home or business.</li>
        <li><strong>You approve the price</strong>The estimate comes before the work, and going ahead is your decision.</li>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================ SERVICES -->
<section class="section edge-curve-top ty-more" aria-labelledby="more-title">
  <div class="container">
    <div class="section-title">
      <span class="eyebrow-label">While you wait</span>
      <h2 id="more-title">Want to read about the <span class="text-accent">work</span> before the plumber calls?</h2>
    </div>
    <ul class="ty-more__list">
<?php
$tyCards = [
    ['/services/drain-cleaning/', 'droplets', 'Drain cleaning', 'What clogs each drain and how a visit works.', 'drain-cleaning'],
    ['/services/leak-detection-repair/', 'search', 'Leak detection & repair', 'Spotting a hidden leak from the water meter.', 'leak-detection-repair'],
    ['/faq/', 'info', 'Plumbing FAQ', 'Costs, hours, emergencies and what to do first.', null],
];
foreach ($tyCards as $tyCard):
    $tyOk = $tyCard[4] !== null ? serviceLive($tyCard[4]) : pageLive($tyCard[0]);
    if (!$tyOk) continue; ?>
      <li><a href="<?php echo esc($tyCard[0]); ?>"><?php icon($tyCard[1], 26); ?><b><?php echo esc($tyCard[2]); ?></b><span><?php echo esc($tyCard[3]); ?></span></a></li>
<?php endforeach; ?>
    </ul>
<?php if (pageLive('/services/')): ?>
    <p class="ty-more__foot"><a href="/services/">See all five Ledco Plumbing services &rarr;</a></p>
<?php endif; ?>
  </div>
</section>

<!-- ============================================================ REVIEW REQUEST -->
<section class="closing-cta texture-grain edge-wave-top ty-review" aria-labelledby="review-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Worked with Ledco Plumbing before?</span>
      <h2 id="review-title">Tell your neighbors how it went</h2>
      <p>If Ledco Plumbing has fixed something for you, a Google review helps other Seminole homeowners find a plumber.</p>
    </div>
    <div class="actions">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($gbp['review_url']); ?>" target="_blank" rel="noopener"><?php icon('star', 18); ?> Leave us a Google review</a>
    </div>
  </div>
</section>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
