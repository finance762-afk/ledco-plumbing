<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * cookie-policy/index.php — Cookie Policy. Written from what this build actually stores:
 *   - p1_ft first-party cookie (includes/attribution.php: 30 days, HttpOnly, SameSite=Lax)
 *   - localStorage key cookieBannerDismissed_v1 (assets/js/main.js)
 *   - Google Maps embed (homepage + Contact)
 *   - Google Analytics 4 — only described as active once config.php holds a real measurement ID
 *   - Fonts are self-hosted, so no Google Fonts cookie is claimed.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Cookie Policy | Ledco Plumbing in Seminole, OK';
$pageDescription = 'The cookies and browser storage the Ledco Plumbing website in Seminole, OK uses, what each one is for, and how you can block or clear them.';
$canonicalUrl    = $siteUrl . '/cookie-policy/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: a date() here would claim the policy changed every day

$gaLive = !empty($googleAnalyticsId) && stripos($googleAnalyticsId, 'XXXX') === false;

$pageSchema   = p1_legal_schema($pageTitle, $pageDescription, '/cookie-policy/');
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo p1_legal_style(); ?>

<div class="legal-page">
<?php echo p1_legal_hero_open('Cookie Policy', 'Legal'); ?>
    <h1 id="legal-title">Cookie Policy</h1>
<?php echo p1_legal_hero_close($lastUpdated); ?>

<div class="legal-body">
  <div class="container">
    <article class="legal-prose">

      <p>This Cookie Policy explains which cookies and similar storage <?php echo esc($domain); ?> uses, what each one is for, and how you can control them. It sits alongside our <a href="/privacy-policy/">Privacy Policy</a>.</p>

      <h2>1. What Are Cookies?</h2>
      <p>Cookies are small text files a website saves on your device. Websites use them to work properly, to remember a choice, and to learn how visitors arrive and what they use. Browsers also offer "local storage", which saves a small value on your device in a similar way.</p>

      <h2>2. What This Site Uses</h2>
      <div class="legal-table-wrap">
        <table>
          <thead><tr><th scope="col">Name</th><th scope="col">Type</th><th scope="col">What it does</th><th scope="col">How long</th></tr></thead>
          <tbody>
            <tr><th scope="row"><code>p1_ft</code></th><td>First-party cookie</td><td>On your first page view it records the page you landed on, the page that referred you, any campaign tags in the link, a random visit ID and whether you are on a phone, tablet or computer. If you send us a form, those details travel with it so we know which page led to your request.</td><td>30 days</td></tr>
            <tr><th scope="row"><code>cookieBannerDismissed_v1</code></th><td>Browser local storage</td><td>Remembers that you closed the cookie notice so it does not appear again.</td><td>Until you clear site data</td></tr>
<?php if ($gaLive): ?>
            <tr><th scope="row"><code>_ga</code>, <code>_ga_*</code></th><td>Google Analytics 4 cookies</td><td>Tell us how many people visit, which pages they view and how they arrived, so we can improve the site.</td><td>Up to 2 years</td></tr>
<?php endif; ?>
          </tbody>
        </table>
      </div>

      <h3>Strictly necessary</h3>
      <p>The site does not need an account or a login, so no cookie is required just to read it. The <code>p1_ft</code> cookie is used for lead tracking, not for the page to display.</p>

      <h3>Analytics</h3>
<?php if ($gaLive): ?>
      <p>We use Google Analytics 4 to see traffic and which pages are used. Google sets the <code>_ga</code> cookies named above and receives page-view data. You can opt out of Google Analytics on every site with Google's <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Analytics Opt-out Browser Add-on</a>.</p>
<?php else: ?>
      <p>This site is prepared to use Google Analytics 4 to see traffic and which pages are used. It is not switched on yet. When it is, Google will set cookies beginning with <code>_ga</code>, this table will list them, and you will be able to opt out with Google's <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Analytics Opt-out Browser Add-on</a>.</p>
<?php endif; ?>

      <h3>Third-party embeds</h3>
      <p>The homepage and Contact page show a Google Map of our office. When that map loads, Google can set its own cookies and receives your IP address and browser details under <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google's Privacy Policy</a>. The site's fonts are stored on our own server, so loading them does not contact Google or set a cookie.</p>

      <h2>3. How to Control Cookies</h2>
      <p>Every major browser lets you see, delete and block cookies, either for all sites or for specific ones. Blocking <code>p1_ft</code> does not stop you from using the site or sending a form. Blocking the map's cookies means the embedded map may not load, and the "Get directions" link still works. Instructions are in the help pages for Chrome, Safari, Firefox and Edge.</p>

      <h2>4. Our Cookie Notice</h2>
      <p>A short notice at the bottom of the screen tells you the site uses cookies for analytics and maps. When you press "Got it", your browser stores <code>cookieBannerDismissed_v1</code> and the notice stays away on later visits. Clearing your browser's site data brings it back.</p>

      <h2>5. Changes to This Policy</h2>
      <p>If the cookies this site uses change, for example when analytics is switched on, we update this page and its "Last Updated" date.</p>

      <h2>6. Contact Us</h2>
      <?php echo p1_legal_contact(), "\n"; ?>

      <p class="legal-stamp">Last Updated: <?php echo esc($lastUpdated); ?></p>
    </article>
  </div>
</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
