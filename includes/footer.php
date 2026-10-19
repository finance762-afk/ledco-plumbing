<?php
/**
 * includes/footer.php — closes <main>; site footer, estimate dialog, cookie bar, mobile CTA bar, scripts.
 * Link integrity: page/area links render only when the page exists on disk; the four legal pages and the
 * sitemap are the one exception — the compliance footer row is mandatory on every page (legal pages ship in Phase 4).
 * Loop variables are prefixed ($footSvc, $footArea, ...) — pages own $svc/$area/$c.
 */
$footPhone     = formatPhone($phone);
$footPhoneHref = phoneHref($phone);
$footCity      = $address['city'] . ', ' . $address['state'];
$footHours     = groupedHours((array) $hours);

$footServices = [];
foreach ((array) $services as $footSvc) {
    $footServices[] = ['name' => $footSvc['name'], 'href' => serviceLive($footSvc['slug']) ? '/services/' . $footSvc['slug'] . '/' : null];
}
$footAreas = [];
foreach ((array) $serviceAreaDetails as $footArea) {
    $footAreas[] = ['name' => $footArea['city'] . ', ' . $footArea['state'], 'href' => areaHref($footArea['slug'])];
}
$footHasCompany = pageLive('/about/') || pageLive('/faq/') || pageLive('/blog/') || pageLive('/contact/');

// Trust badges: only facts config.php actually holds
$footBadges = [];
if (!empty($licenseNumber))    $footBadges[] = 'License ' . $licenseNumber;
if (!empty($yearsInBusiness))  $footBadges[] = $yearsInBusiness . ' years in business';
if (!empty($insuranceSummary)) $footBadges[] = $insuranceSummary;
foreach ((array) $certifications as $footCert) $footBadges[] = is_array($footCert) ? ($footCert['name'] ?? '') : (string) $footCert;
$footBadges[] = 'Serving ' . $footCity;
if (count($footHours) === 1 && $footHours[0]['days'] === 'Mon–Sun') $footBadges[] = 'Open 7 days';
$footBadges = array_values(array_filter($footBadges));

$footServiceNames = array_map(fn($s) => strtolower($s['name']), (array) $services);
$footAreaNames    = array_map(fn($a) => $a['city'], (array) $serviceAreaDetails);
$footHoursParts   = array_map(fn($g) => $g['days'] === 'Mon–Sun' ? 'Monday through Sunday, ' . $g['label'] : $g['days'] . ', ' . $g['label'], $footHours);
$footHoursSentence = implode('; ', $footHoursParts);
$footAddrLine     = (!empty($addressPublic) && !empty($address['street']) ? $address['street'] . ', ' : '') . $address['city'] . ', ' . $address['state'] . (!empty($address['zip']) ? ' ' . $address['zip'] : '');
?>
</main>

<footer class="site-footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">

        <div class="footer-col footer-brand">
          <a class="footer-logo" href="/" aria-label="<?php echo esc($siteName); ?> — home">
<?php if ($logoImage): ?>
            <img src="<?php echo esc($logoImage); ?>" alt="<?php echo esc($siteName); ?>" width="<?php echo (int) $logoW; ?>" height="<?php echo (int) $logoH; ?>" loading="lazy" decoding="async">
<?php else: ?>
            <svg class="logo-mark" viewBox="0 0 64 64" width="44" height="44" aria-hidden="true" focusable="false"><rect width="64" height="64" rx="14" fill="var(--color-primary)"/><path d="M20 14h11v29h15v9H20z" fill="var(--color-accent)"/></svg>
            <span class="logo-text"><span class="logo-name"><?php echo esc($brandName); ?></span><span class="brand-sub">Plumbing &middot; <?php echo esc($footCity); ?></span></span>
<?php endif; ?>
          </a>
<?php if (!empty($tagline)): ?>
          <p><strong><?php echo esc($tagline); ?></strong></p>
<?php endif; ?>
          <p><?php echo esc($businessDescription); ?></p>
          <div class="footer-badges">
<?php foreach ($footBadges as $footBadge): ?>
            <span><?php echo esc($footBadge); ?></span>
<?php endforeach; ?>
          </div>
        </div>

        <div class="footer-col">
          <h3>Services</h3>
          <ul>
<?php foreach ($footServices as $footSvcLink): ?>
            <li><?php if ($footSvcLink['href']): ?><a href="<?php echo esc($footSvcLink['href']); ?>"><?php echo esc($footSvcLink['name']); ?></a><?php else: echo esc($footSvcLink['name']); endif; ?></li>
<?php endforeach; ?>
          </ul>
<?php if (pageLive('/services/')): ?>
          <a class="footer-viewall" href="/services/">View All Services &rarr;</a>
<?php endif; ?>
        </div>

        <div class="footer-col">
          <h3>Service Areas</h3>
          <ul>
<?php foreach ($footAreas as $footAreaLink): ?>
            <li><?php if ($footAreaLink['href']): ?><a href="<?php echo esc($footAreaLink['href']); ?>"><?php echo esc($footAreaLink['name']); ?></a><?php else: echo esc($footAreaLink['name']); endif; ?></li>
<?php endforeach; ?>
          </ul>
<?php if (pageLive(P1_AREAS_HUB)): ?>
          <a class="footer-viewall" href="<?php echo esc(P1_AREAS_HUB); ?>">View All Areas &rarr;</a>
<?php endif; ?>
<?php if ($footHasCompany): ?>
          <h3 style="margin-top:1.6rem">Company</h3>
          <ul>
<?php if (pageLive('/about/')): ?>
            <li><a href="/about/">About Us</a></li>
<?php endif; ?>
<?php if (pageLive('/faq/')): ?>
            <li><a href="/faq/">FAQ</a></li>
<?php endif; ?>
<?php if (pageLive('/blog/')): ?>
            <li><a href="/blog/">Blog</a></li>
<?php endif; ?>
<?php if (pageLive('/contact/')): ?>
            <li><a href="/contact/">Contact</a></li>
<?php endif; ?>
          </ul>
<?php endif; ?>
        </div>

        <div class="footer-col">
          <h3>Contact</h3>
          <div class="footer-nap">
            <div><?php icon('phone', 18); ?><a href="<?php echo esc($footPhoneHref); ?>"><?php echo esc($footPhone); ?></a></div>
            <div><?php icon('map-pin', 18); ?><span><?php echo esc($footAddrLine); ?></span></div>
          </div>
          <h3 style="margin-top:1.4rem">Hours</h3>
          <div class="footer-hours">
<?php foreach ($footHours as $footHourRow): ?>
            <div><span><?php echo esc($footHourRow['days']); ?></span><span><?php echo esc($footHourRow['label']); ?></span></div>
<?php endforeach; ?>
          </div>
<?php if (!empty($socialLinks)): ?>
          <div class="social-links">
<?php foreach ((array) $socialLinks as $footSocialName => $footSocialUrl): ?>
            <a href="<?php echo esc($footSocialUrl); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc($siteName . ' on ' . ucfirst((string) $footSocialName)); ?>"><?php echo esc(ucfirst((string) $footSocialName)); ?></a>
<?php endforeach; ?>
          </div>
<?php endif; ?>
          <div class="footer-cta"><?php echo estimateTrigger('btn btn-accent', 'Get a Free Estimate'), "\n"; ?></div>
        </div>

      </div>

<?php if (!empty($gbp['embed_src'])): ?>
      <div class="footer-map map-embed" style="margin-top:var(--space-xl,2rem);max-width:720px">
        <iframe src="<?php echo esc($gbp['embed_src']); ?>" title="Map of Ledco Plumbing at 316 E Oak Ave, Seminole, OK" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      </div>
<?php endif; ?>

      <!-- AEO entity block: NAP + who/what/where in plain sentences, on every page -->
      <div class="footer-entity" itemscope itemtype="https://schema.org/Plumber">
        <meta itemprop="name" content="<?php echo esc($siteName); ?>">
        <meta itemprop="url" content="<?php echo esc(rtrim($siteUrl, '/') . '/'); ?>">
        <meta itemprop="telephone" content="<?php echo esc($phoneE164); ?>">
        <meta itemprop="description" content="<?php echo esc($businessDescription); ?>">
        <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
<?php if (!empty($addressPublic) && !empty($address['street'])): ?>
          <meta itemprop="streetAddress" content="<?php echo esc($address['street']); ?>">
<?php endif; ?>
          <meta itemprop="addressLocality" content="<?php echo esc($address['city']); ?>">
          <meta itemprop="addressRegion" content="<?php echo esc($address['state']); ?>">
<?php if (!empty($address['zip'])): ?>
          <meta itemprop="postalCode" content="<?php echo esc($address['zip']); ?>">
<?php endif; ?>
          <meta itemprop="addressCountry" content="US">
        </span>
<?php if (!empty($geo['lat']) && !empty($geo['lng'])): ?>
        <span itemprop="geo" itemscope itemtype="https://schema.org/GeoCoordinates">
          <meta itemprop="latitude" content="<?php echo esc($geo['lat']); ?>">
          <meta itemprop="longitude" content="<?php echo esc($geo['lng']); ?>">
        </span>
<?php endif; ?>
<?php foreach ((array) $serviceAreaDetails as $footAreaMeta): ?>
        <meta itemprop="areaServed" content="<?php echo esc($footAreaMeta['city'] . ', ' . $footAreaMeta['state']); ?>">
<?php endforeach; ?>
<?php
// openingHours microdata ("Mo-Su 07:00-17:00") from the same $hours rows the visible hours and JSON-LD use
$footDayCodes = ['Mon' => 'Mo', 'Tue' => 'Tu', 'Wed' => 'We', 'Thu' => 'Th', 'Fri' => 'Fr', 'Sat' => 'Sa', 'Sun' => 'Su'];
foreach ($footHours as $footHourGroup):
    $footHourRow0 = null;
    foreach ((array) $hours as $footHourRaw) { if ($footHourRaw['short'] === $footHourGroup['first']) { $footHourRow0 = $footHourRaw; break; } }
    if (!$footHourRow0) continue;
    $footDaysCode = $footDayCodes[$footHourGroup['first']] . ($footHourGroup['first'] === $footHourGroup['last'] ? '' : '-' . $footDayCodes[$footHourGroup['last']]);
?>
        <meta itemprop="openingHours" content="<?php echo esc($footDaysCode . ' ' . $footHourRow0['opens'] . '-' . $footHourRow0['closes']); ?>">
<?php endforeach; ?>
        <p><?php echo esc($siteName); ?> is a plumber based in <?php echo esc($address['city']); ?>, Oklahoma, serving <?php echo esc(implode(' and ', $footAreaNames)); ?> with <?php echo esc(implode(', ', array_slice($footServiceNames, 0, -1)) . ', and ' . end($footServiceNames)); ?>. Call <a href="<?php echo esc($footPhoneHref); ?>"><?php echo esc($footPhone); ?></a> or visit <?php echo esc($footAddrLine); ?>. Open <?php echo esc($footHoursSentence); ?>.</p>
      </div>
    </div>
  </div>

  <div class="footer-bottom-bar">
    <div class="container">
      <div class="footer-legal-row">
        <a href="/privacy-policy/">Privacy Policy</a>
        <span class="divider">|</span>
        <a href="/terms/">Terms of Service</a>
        <span class="divider">|</span>
        <a href="/cookie-policy/">Cookie Policy</a>
        <span class="divider">|</span>
        <a href="/accessibility/">Accessibility</a>
        <span class="divider">|</span>
        <a href="/privacy-policy/#ccpa-rights">Do Not Sell or Share My Personal Information</a>
        <span class="divider">|</span>
        <a href="/sitemap.xml">Sitemap</a>
      </div>
    </div>
    <div class="container footer-copyright-row">
      <span>&copy; <?php echo date('Y'); ?> <?php echo esc($siteName); ?>. All rights reserved.</span>
      <span class="footer-credit"><a href="https://pageoneinsights.com" rel="dofollow" target="_blank">Web Design &amp; Hosting by Page One Insights, LLC</a></span>
    </div>
  </div>
  <?php include __DIR__ . '/partner-badge.php'; ?>
</footer>

<!-- Estimate dialog: opened by any [data-open-estimate] (nav CTA, mobile bar, hero button on small screens) -->
<dialog class="estimate-dialog" id="estimate-dialog" aria-labelledby="estimate-dialog-title">
  <div class="dialog-head">
    <h2 id="estimate-dialog-title">Get Your Free Estimate</h2>
    <button type="button" class="dialog-close" data-close-estimate aria-label="Close estimate form"><?php icon('x', 20); ?></button>
  </div>
  <div class="dialog-body">
    <p class="hero-form-tagline">Tell <?php echo esc($brandName); ?> what you need and we will call you back, or call <a href="<?php echo esc($footPhoneHref); ?>"><?php echo esc($footPhone); ?></a>.</p>
    <form class="estimate-form" action="<?php echo esc($formAction); ?>" method="POST" id="estimate-form-dialog">
      <?php echo p1_lead_hidden_fields('dialog'); ?>
      <div class="field">
        <label for="dialog-name">Your name *</label>
        <input id="dialog-name" type="text" name="name" required autocomplete="name">
      </div>
      <div class="field">
        <label for="dialog-phone">Phone *</label>
        <input id="dialog-phone" type="tel" name="phone" required autocomplete="tel" inputmode="tel">
      </div>
      <div class="field">
        <label for="dialog-email">Email *</label>
        <input id="dialog-email" type="email" name="email" required autocomplete="email">
      </div>
      <div class="field">
        <label for="dialog-service">Service needed</label>
        <select id="dialog-service" name="service"><?php echo p1_service_options(); ?></select>
      </div>
      <div class="field">
        <label for="dialog-message">Tell us about the problem (optional)</label>
        <textarea id="dialog-message" name="message" rows="3"></textarea>
      </div>

      <fieldset class="form-consent-fieldset">
        <legend class="form-consent-legend sr-only">Communication consent</legend>
        <label class="consent" for="dialog-email-optin">
          <input id="dialog-email-optin" type="checkbox" name="email_opt_in" value="yes">
          <span><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry and services. I can unsubscribe at any time.</span>
        </label>
        <label class="consent" for="dialog-sms-optin">
          <input id="dialog-sms-optin" type="checkbox" name="sms_opt_in" value="yes">
          <span><strong>Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the number I provided. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. Consent is not a condition of purchase.</span>
        </label>
        <?php echo p1_consent_row('dialog'), "\n"; ?>
      </fieldset>

      <button class="btn btn-primary btn-lg btn-block" type="submit">Send My Request</button>
    </form>
  </div>
</dialog>

<!-- Cookie notice: one line, appears after the first scroll, dismissal remembered in localStorage (main.js) -->
<div class="cookie-bar" id="cookie-bar" role="region" aria-label="Cookie notice">
  <p>This site uses cookies for analytics and maps. <a href="/cookie-policy/">Cookie Policy</a></p>
  <button type="button">Got it</button>
</div>

<!-- Mobile sticky CTA bar: appears once the hero has scrolled away (main.js) -->
<div class="mobile-cta-bar<?php echo !empty($textUsNumber) ? ' mobile-cta-bar--3' : ''; ?>" role="navigation" aria-label="Quick contact">
  <a class="mobile-cta-bar__call" href="<?php echo esc($footPhoneHref); ?>"><?php icon('phone', 18); ?> Call Now</a>
<?php if (!empty($textUsNumber)): ?>
  <a class="mobile-cta-bar__text" href="sms:<?php echo esc($textUsNumber); ?>">Text Us</a>
<?php endif; ?>
  <?php echo estimateTrigger('mobile-cta-bar__estimate', 'Free Estimate'), "\n"; ?>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/text-us.php'; echo p1_text_us(); ?>

<button type="button" class="back-to-top" aria-label="Back to top"><?php icon('chevron-down', 20); ?></button>

<script src="/assets/js/main.js?v=<?php echo esc($cssVersion); ?>" defer></script>
<script src="/assets/js/animations.js?v=<?php echo esc($cssVersion); ?>" defer></script>
<script src="/assets/js/effects.js?v=<?php echo esc($cssVersion); ?>" defer></script>
</body>
</html>
