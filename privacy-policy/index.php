<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * privacy-policy/index.php — Privacy Policy (legal-compliance.md privacy template, adapted to this site).
 * Adapted, not pasted: Formsubmit.co is retired (forms post to the Page One leads endpoint), photo uploads and
 * insurance-carrier sharing do not apply to this site, and the first-party attribution cookie (p1_ft) is disclosed.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Privacy Policy | Ledco Plumbing LLC in Seminole, OK';
$pageDescription = 'How Ledco Plumbing LLC in Seminole, OK collects, uses and protects your information from the website, contact forms, phone calls and text messages.';
$canonicalUrl    = $siteUrl . '/privacy-policy/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: a date() here would claim the policy changed every day

$pageSchema   = p1_legal_schema($pageTitle, $pageDescription, '/privacy-policy/');
$schemaMarkup = $pageSchema;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo p1_legal_style(); ?>

<div class="legal-page">
<?php echo p1_legal_hero_open('Privacy Policy', 'Legal'); ?>
    <h1 id="legal-title">Privacy Policy</h1>
<?php echo p1_legal_hero_close($lastUpdated); ?>

<div class="legal-body">
  <div class="container">
    <article class="legal-prose">

      <p>This Privacy Policy explains how <?php echo esc($companyName); ?>, a <?php echo esc($companyEntityType === 'LLC' ? 'limited liability company' : $companyEntityType); ?> based in <?php echo esc($address['city'] . ', ' . $companyState); ?> ("we", "us", "our"), collects, uses and protects personal information when you visit <?php echo esc($domain); ?>, fill out a form on it, or call or text us.</p>

      <h2>1. Information We Collect</h2>
      <ul>
        <li><strong>Information you give us:</strong> your name, phone number, email address, the service you need, and anything you write in the message box, whether you send it through a form, by phone or by email.</li>
        <li><strong>Collected automatically:</strong> your browser and device type, the pages you view, the page that sent you here, and the date and time of your visit. If you arrived through an ad or a tagged link, we also record the campaign details in that link.</li>
        <li><strong>Cookies and similar technologies:</strong> a short list is in our <a href="/cookie-policy/">Cookie Policy</a>.</li>
      </ul>

      <h2>2. How We Use Your Information</h2>
      <ul>
        <li>To answer your request, call you back and give you an estimate.</li>
        <li>To schedule and carry out plumbing work you ask for.</li>
        <li>To send calls, texts or emails you have agreed to receive (see section 6).</li>
        <li>To understand which pages and ads lead people to contact us, so we can improve the website.</li>
        <li>To meet legal, tax and recordkeeping obligations.</li>
      </ul>

      <h2>3. How We Share Your Information</h2>
      <ul>
        <li><strong>We do not sell personal information</strong>, and we do not share it for cross-context behavioral advertising.</li>
        <li><strong>Website and form processor:</strong> Page One Insights, LLC designs and hosts this website. Form submissions are received by its lead system, stored there, and forwarded to us by email. Page One Insights, LLC also receives a copy for lead tracking and customer service.</li>
        <li><strong>Maps:</strong> if you load the map on our Contact page, Google receives the request under Google's own privacy policy.</li>
        <li><strong>Analytics:</strong> if Google Analytics is switched on for this site, Google receives page-view data as described in our <a href="/cookie-policy/">Cookie Policy</a>.</li>
        <li><strong>Suppliers and subcontractors:</strong> only what is needed to finish a job you have asked for.</li>
        <li><strong>Legal compliance:</strong> where Oklahoma or federal law, or a valid legal request, requires it.</li>
        <li><strong>Business transfers:</strong> if the business is sold or merged, customer records may transfer with it.</li>
      </ul>

      <h2>4. Your Privacy Rights</h2>

      <h3 id="state-rights">Oklahoma and Other State Residents</h3>
      <p>You may ask us what personal information we hold about you, ask us to correct it, or ask us to delete it. Contact us using the details in section 11. Residents of states with consumer privacy laws, including Colorado, Connecticut, Texas, Utah and Virginia, have similar rights, and we will honor a request from any resident whether or not a specific state law applies to a business of our size.</p>

      <h3 id="ccpa-rights">California Residents (CCPA / CPRA)</h3>
      <p>If you are a California resident, you have these rights under the California Consumer Privacy Act as amended by the California Privacy Rights Act:</p>
      <ul>
        <li><strong>Right to know</strong> what personal information we collect, use and disclose.</li>
        <li><strong>Right to delete</strong> personal information we collected from you, with legal exceptions.</li>
        <li><strong>Right to correct</strong> inaccurate personal information.</li>
        <li><strong>Right to opt out of sale or sharing.</strong> We do not sell or share personal information, but you can still send an opt-out request and we will confirm in writing that it was honored.</li>
        <li><strong>Right to limit use</strong> of sensitive personal information. We do not collect sensitive personal information on this site.</li>
        <li><strong>Right to non-discrimination</strong> for using these rights.</li>
      </ul>
      <p><strong>How to use these rights:</strong> email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a> or call <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a>. We respond within 45 days of receiving your request.</p>

      <h2>5. Do Not Sell or Share My Personal Information</h2>
      <p><?php echo esc($companyName); ?> does not sell or share personal information. If you want that on record for your contact details, send a request using the details in section 11.</p>

      <h2>6. Phone Calls and Text Messages (TCPA)</h2>
      <p>When you check the text-message box on a form, you agree to receive text messages from <?php echo esc($companyName); ?> at the number you gave us. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe at any time, or HELP for help. Consent is not a condition of purchase. Email and text consent are separate from agreeing to these terms, are never pre-checked, and you can say yes to one and no to the other. To stop calls, tell the person who calls you or email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a>. We record the date, page and wording version of the consent you give on a form.</p>

      <h2>7. Data Retention</h2>
      <p>We keep form submissions and job records for as long as needed to serve you, answer follow-up questions and meet tax and legal recordkeeping rules, which can be several years. You can ask us to delete your information sooner, and we will do so unless the law requires us to keep it.</p>

      <h2>8. Data Security</h2>
      <p>This site is served over HTTPS and form submissions are sent over an encrypted connection to a hosted lead system. No method of transmitting or storing data is completely secure, so we cannot promise absolute security.</p>

      <h2>9. Children's Privacy</h2>
      <p>This site is not directed to children under 13 and we do not knowingly collect information from them. If you believe a child sent us information, contact us and we will delete it.</p>

      <h2>10. Third-Party Links and Changes to This Policy</h2>
      <p>This site links to third-party pages such as our Google Business Profile and Google Maps. Those sites have their own privacy practices, and we are not responsible for them. When we change this policy we update the "Last Updated" date at the top of this page.</p>

      <h2>11. Contact Us</h2>
      <p>For privacy questions or to use any right described above:</p>
      <?php echo p1_legal_contact(), "\n"; ?>

      <p class="legal-stamp">Last Updated: <?php echo esc($lastUpdated); ?></p>
    </article>
  </div>
</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
