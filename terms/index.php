<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * terms/index.php — Terms of Service (legal-compliance.md terms template, adapted for a plumber).
 * Left out on purpose: the "licensed and insured" and "workers' compensation" sentences (license, insurance and
 * workers' comp are not in intake — see /content-confirmations.json) and the insurance-claim-work clause
 * (roofing/restoration only). Governing law uses $companyState / $companyCounty from config.php.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Terms of Service | Ledco Plumbing in Seminole, OK';
$pageDescription = 'Terms of Service for the Ledco Plumbing website and plumbing services in Seminole, OK: estimates, work, payment, liability and governing law.';
$canonicalUrl    = $siteUrl . '/terms/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: a date() here would claim the terms changed every day

$pageSchema   = p1_legal_schema($pageTitle, $pageDescription, '/terms/');
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo p1_legal_style(); ?>

<div class="legal-page">
<?php echo p1_legal_hero_open('Terms of Service', 'Legal'); ?>
    <h1 id="legal-title">Terms of Service</h1>
<?php echo p1_legal_hero_close($lastUpdated); ?>

<div class="legal-body">
  <div class="container">
    <article class="legal-prose">

      <p>These Terms of Service apply to your use of <?php echo esc($domain); ?> and to plumbing services you request from <?php echo esc($companyName); ?> ("we", "us", "our").</p>

      <h2>1. Agreement to Terms</h2>
      <p>By using this website or asking <?php echo esc($companyName); ?> to do work, you agree to these Terms. If you do not agree, please do not use the site or request our services. Our <a href="/privacy-policy/">Privacy Policy</a> explains how we handle your information.</p>

      <h2>2. Use of This Website</h2>
      <ul>
        <li>You may use this site for personal or business purposes to learn about our services and to contact us.</li>
        <li>You may not use it for anything unlawful, try to reach non-public systems, copy or scrape its content without written permission, send false information through a form, or use automated tools to pull data from it.</li>
      </ul>

      <h2>3. Estimates and Quotes</h2>
      <p>An estimate is based on what we are told and what we can see when the problem is looked at. The price can change if the scope changes, if something hidden turns up behind a wall, under a slab or in a line, if material prices change between the estimate and the start of work, or if code requirements differ from what was first assumed. We tell you about a change before the extra work is done. A price given by phone is a guide, and only a written agreement for a specific job is final.</p>

      <h2>4. Work We Perform</h2>
      <ul>
        <li>Each job is described in the estimate or agreement you approve for it.</li>
        <li>We follow the plumbing codes that apply to the job at its location.</li>
        <li>Work is done by <?php echo esc($companyName); ?> or by people we arrange to do it.</li>
        <li>You agree to give our plumber safe access to the work area, including to shutoff valves, cleanouts and the water heater, and to tell us about hazards you know of.</li>
      </ul>

      <h2>5. Warranties</h2>
      <p>Any warranty on our workmanship is the one stated in the estimate or agreement for your job. Manufacturer warranties on parts and equipment, such as a water heater, come from the manufacturer and its terms. Warranties do not cover damage from misuse, freezing, neglect, changes made by others, or conditions that existed before our work and were disclosed to you.</p>

      <h2>6. Payment</h2>
      <p>Payment terms are stated in your estimate or agreement. Balances are due when the work is finished unless the agreement says otherwise. Overdue balances can accrue interest to the extent <?php echo esc($companyState); ?> law allows.</p>

      <h2>7. Cancellation and Rescheduling</h2>
      <p>You can cancel or reschedule by calling <?php echo esc($companyPhone); ?>. If parts or equipment have already been ordered specifically for your job, or work has begun, you are responsible for the cost of the parts ordered and the work completed up to that point.</p>

      <h2>8. Limitation of Liability</h2>
      <p>To the fullest extent <?php echo esc($companyState); ?> law allows, the total liability of <?php echo esc($companyName); ?> for any claim connected with this site or our services is limited to the amount you paid for the specific service that caused the claim. We are not liable for indirect, incidental, special or consequential damages. Nothing in these Terms limits liability that the law does not allow to be limited.</p>

      <h2>9. Website Content</h2>
      <p>The text, graphics and logos on this site belong to <?php echo esc($companyName); ?> or are used with permission, and are protected by copyright. You may not copy, distribute or adapt them without written permission. The information on this site is general and is not a substitute for a plumber looking at your actual pipes, fixtures and equipment.</p>

      <h2>10. Text Messages and Calls</h2>
      <p>If you agree to text messages on a form, the terms in section 6 of our <a href="/privacy-policy/">Privacy Policy</a> apply. Message frequency varies, message and data rates may apply, reply STOP to unsubscribe or HELP for help, and consent is not a condition of purchase.</p>

      <h2>11. Governing Law and Disputes</h2>
      <p>These Terms are governed by the laws of the State of <?php echo esc($companyState); ?>, without regard to its conflict-of-laws rules. Disputes will be handled in the state or federal courts located in <?php echo esc($companyCounty); ?> County, <?php echo esc($companyState); ?>.</p>

      <h2>12. Changes to These Terms</h2>
      <p>We may update these Terms. The "Last Updated" date at the top of this page shows the latest version, and continuing to use the site after an update means you accept the revised Terms.</p>

      <h2>13. Contact Us</h2>
      <?php echo p1_legal_contact(), "\n"; ?>

      <p class="legal-stamp">Last Updated: <?php echo esc($lastUpdated); ?></p>
    </article>
  </div>
</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
