<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * accessibility/index.php — Accessibility Statement (WCAG 2.1 AA). The feature list is limited to what
 * header.php / footer.php / framework.css actually ship: skip link, landmarks, aria-current, aria-expanded on the
 * menu toggle, :focus-visible ring, prefers-reduced-motion, labelled form fields, alt text.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Accessibility Statement | Ledco Plumbing LLC';
$pageDescription = 'Ledco Plumbing LLC in Seminole, OK aims to meet WCAG 2.1 Level AA. See the accessibility features on this website and how to report a barrier.';
$canonicalUrl    = $siteUrl . '/accessibility/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: a date() here would claim the statement changed every day

$pageSchema   = p1_legal_schema($pageTitle, $pageDescription, '/accessibility/');
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo p1_legal_style(); ?>

<div class="legal-page">
<?php echo p1_legal_hero('Accessibility Statement', 'Legal', $lastUpdated); ?>

<div class="legal-body">
  <div class="container">
    <article class="legal-prose">

      <p><?php echo esc($companyName); ?> wants everyone in <?php echo esc($address['city']); ?> and the surrounding area to be able to read this website, find our phone number and ask for a plumber, whatever device or assistive technology they use.</p>

      <h2>1. Our Commitment</h2>
      <p><?php echo esc($companyName); ?> works to make <?php echo esc($domain); ?> usable by people with disabilities, and we apply the Web Content Accessibility Guidelines (WCAG) 2.1 at Level AA as the standard we build to.</p>

      <h2>2. Conformance Status</h2>
      <p>This site is designed to conform with WCAG 2.1 Level AA. We believe it partially conforms today, meaning a few parts may not yet fully meet the standard. We have not had the site audited by an outside accessibility firm, and we fix problems as we find them or as you report them.</p>

      <h2>3. Accessibility Features</h2>
      <ul>
        <li>A "Skip to main content" link at the top of every page, visible when you tab to it</li>
        <li>Page landmarks: header, navigation, main content and footer</li>
        <li>A visible focus outline on links, buttons and form fields for keyboard users</li>
        <li>A menu button that tells screen readers whether the mobile menu is open or closed, and a marker for the page you are on</li>
        <li>Labels attached to every form field, and separate, unchecked-by-default consent boxes</li>
        <li>Text alternatives on meaningful images, and decorative icons hidden from screen readers</li>
        <li>Layouts that adapt to phone, tablet and desktop screens and to browser zoom</li>
        <li>Animations that switch off when your device is set to reduce motion</li>
        <li>A tap-to-call phone number on every page, as an alternative to any form</li>
      </ul>

      <h2>4. Known Limitations</h2>
      <ul>
        <li>The Google Map on the homepage and Contact page is provided by Google and may not fully meet WCAG. The office address, a "Get directions" link and our phone number are printed next to it.</li>
        <li>The cookie notice and some page effects appear after you start scrolling, which can be less convenient with some assistive technology.</li>
      </ul>

      <h2>5. Feedback and Reporting Barriers</h2>
      <p>If something on this site is hard to use, tell us what page you were on and what happened. We aim to reply within 5 business days and to fix the problem or give you the information another way.</p>

      <h2>6. Other Ways to Reach Us</h2>
      <p>You can skip the website entirely. Call <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a> during business hours (<?php echo esc($businessHours); ?>), email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a>, or visit the office. We will give you service information in another format on request.</p>

      <h2>7. Changes to This Statement</h2>
      <p>When we make accessibility changes to the site we update this statement and its "Last Updated" date.</p>

      <h2>8. Contact Us</h2>
      <?php echo p1_legal_contact(), "\n"; ?>

      <p class="legal-stamp">Last Updated: <?php echo esc($lastUpdated); ?></p>
    </article>
  </div>
</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
