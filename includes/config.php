<?php
/**
 * includes/config.php — single source of site-wide variables (Ledco Plumbing LLC).
 * Every value below traces to build-plan.json. Nothing here is invented; unknowns stay empty and the
 * templates omit anything empty.
 * UNKNOWN: tagline, social links, GA4 ID, founding year / years in business, license number, insurance,
 * certifications, logo + brand colors (design.colors holds only extracted_from_logo: true), production domain.
 */

// ---- Identity ---------------------------------------------------------------------------------
$slug      = 'ledco-plumbing';                           // exact build directory name
$siteName  = 'Ledco Plumbing LLC';                       // build-plan company_name
$brandName = 'Ledco Plumbing';                           // short form for headings/copy
$tagline   = '';                                         // none in build-plan
$industry  = 'Plumber';
$tier      = 'premium';                                  // build-plan tier
$ownerName = 'Mickey Ledbetter';

// ---- Contact (public NAP — GBP is the source of truth) ------------------------------------------
$phone          = '(405) 257-3096';
$phoneRaw       = '4052573096';
$phoneE164      = '+14052573096';
$phoneSecondary = '';
$email          = 'mickey.ledbetter@yahoo.com';
$contactEmail   = $email;
// Lead routing only (server-side, never rendered)
$leadNotificationEmail = 'mickey.ledbetter@yahoo.com';
$leadNotificationPhone = '(405) 257-3096';

// build-plan address_public: true — street address is published in the footer NAP and schema
$addressPublic = true;
$address = ['street' => '316 E Oak Ave', 'city' => 'Seminole', 'state' => 'OK', 'zip' => '74868'];

// ---- Domain / URLs ----------------------------------------------------------------------------
// build-plan has no production_domain (its "domain" field is just the slug), so the site runs on the
// pageone.cloud host until a launch domain is set. Swap $domain here once the client's domain is known.
$domain  = 'ledco-plumbing.pageone.cloud';
$siteUrl = 'https://' . $domain;
// $canonicalUrl is NOT set here — each page sets its own from $siteUrl + path before head.php.

// ---- SEO --------------------------------------------------------------------------------------
$primaryKeyword    = 'Drain Cleaning';                   // build-plan seo.primary_keyword
$secondaryKeywords = [
    'water heater repair',
    'water heater installation',
    'leak detection',
    'sewer line repair',
    'commercial plumber',
    'plumber seminole ok',
];
$targetRadiusMiles = 25;                                 // build-plan seo.target_radius
$tradeNoun         = 'plumber';

// ---- Services (5 — one page each under /services/{slug}/, slugs = build-plan pages[].slug) ------
$services = [
    ['name' => 'Drain Cleaning', 'slug' => 'drain-cleaning',
     'description' => 'Clearing clogged and slow drains for Seminole-area homes and businesses.',
     'keywords' => ['drain cleaning Seminole OK', 'drain cleaning', 'clogged drain plumber Seminole']],
    ['name' => 'Water Heater Repair & Installation', 'slug' => 'water-heater-repair-installation',
     'description' => 'Water heater repair and new water heater installation for Seminole-area homes and businesses.',
     'keywords' => ['water heater repair & installation Seminole OK', 'water heater repair', 'water heater installation']],
    ['name' => 'Leak Detection & Repair', 'slug' => 'leak-detection-repair',
     'description' => 'Finding and repairing hidden water leaks.',
     'keywords' => ['leak detection & repair Seminole OK', 'leak detection', 'water leak repair Seminole']],
    ['name' => 'Sewer Line Repair', 'slug' => 'sewer-line-repair',
     'description' => 'Repair of backed-up and damaged sewer lines.',
     'keywords' => ['sewer line repair Seminole OK', 'sewer line repair', 'sewer backup Seminole']],
    ['name' => 'Commercial Plumbing', 'slug' => 'commercial-plumbing',
     'description' => 'Plumbing service for Seminole-area commercial properties.',
     'keywords' => ['commercial plumbing Seminole OK', 'commercial plumber', 'commercial plumber Seminole']],
];

// ---- Service areas ----------------------------------------------------------------------------
$serviceAreas = ['Wewoka, OK', 'Seminole, OK'];          // build-plan service_areas
$serviceAreaDetails = [
    ['city' => 'Seminole', 'state' => 'OK', 'zip' => '74868', 'primary' => true,  'slug' => 'seminole-ok'],
    ['city' => 'Wewoka',   'state' => 'OK', 'zip' => '',      'primary' => false, 'slug' => 'wewoka-ok'],
];

// ---- Business facts (build-plan content — the ONLY source for these claims) ----------------------
$businessDescription = 'Ledco Plumbing is a local plumber in Seminole, OK offering drain cleaning, water heater repair and installation, leak detection, sewer line repair, and commercial plumbing.';
$usps             = [];       // build-plan content.usps is empty
$certifications   = [];       // none provided — never claim one
$licenseNumber    = '';       // UNKNOWN — the research brief asks for the verified OK license number before it is printed
$insuranceSummary = '';       // build-plan content.insurance is empty — do not claim "insured"

// ---- Hours (build-plan business_hours: Mon–Sun 7:00 AM–5:00 PM) ---------------------------------
$hours = [
    ['day' => 'Monday',    'short' => 'Mon', 'opens' => '07:00', 'closes' => '17:00', 'label' => '7:00 AM – 5:00 PM'],
    ['day' => 'Tuesday',   'short' => 'Tue', 'opens' => '07:00', 'closes' => '17:00', 'label' => '7:00 AM – 5:00 PM'],
    ['day' => 'Wednesday', 'short' => 'Wed', 'opens' => '07:00', 'closes' => '17:00', 'label' => '7:00 AM – 5:00 PM'],
    ['day' => 'Thursday',  'short' => 'Thu', 'opens' => '07:00', 'closes' => '17:00', 'label' => '7:00 AM – 5:00 PM'],
    ['day' => 'Friday',    'short' => 'Fri', 'opens' => '07:00', 'closes' => '17:00', 'label' => '7:00 AM – 5:00 PM'],
    ['day' => 'Saturday',  'short' => 'Sat', 'opens' => '07:00', 'closes' => '17:00', 'label' => '7:00 AM – 5:00 PM'],
    ['day' => 'Sunday',    'short' => 'Sun', 'opens' => '07:00', 'closes' => '17:00', 'label' => '7:00 AM – 5:00 PM'],
];
// Compact one-line form for the v8 components that expect a string
$businessHours = 'Mon–Sun 7:00 AM–5:00 PM';

// ---- Brand ------------------------------------------------------------------------------------
// build-plan design.colors carries no values and assets.logo is null — these mirror the scaffold
// framework.css :root until Phase 0/2 logo analysis supplies the real palette. Style: modern.
$colors = ['primary' => '#1f2428', 'secondary' => '#5a6570', 'accent' => '#c8461a'];
$designStyle = 'modern';
// build-plan content.years is null — never print an "Est. YYYY" line or a years-in-business figure.
$yearEstablished = null;
$yearsInBusiness = null;

// ---- Google Business Profile ------------------------------------------------------------------
$gbp = [
    'place_id'    => 'ChIJy6bf-8yIs4cRrZy4tEnApos',
    'cid'         => '10062941840203095213',
    'url'         => 'https://maps.google.com/maps?cid=10062941840203095213',   // schema hasMap
    'profile_url' => 'https://maps.google.com/maps?cid=10062941840203095213',
    'directions'  => 'https://www.google.com/maps/dir/?api=1&destination=place_id:ChIJy6bf-8yIs4cRrZy4tEnApos',
    'review_url'  => 'https://search.google.com/local/writereview?placeid=ChIJy6bf-8yIs4cRrZy4tEnApos',
    'embed_src'   => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d-96.667593!3d35.225596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87b388ccfbdfa6cb%3A0x8ba6c049b4b89cad!2sLedco%20Plumbing!5e0!3m2!1sen!2sus!4v1',
    // build-plan reviews is empty — no rating/count is shown anywhere, and NEVER AggregateRating
];
// integrations.geo (matches the GBP embed: !2d = longitude, !3d = latitude)
$geo = ['lat' => 35.225596, 'lng' => -96.667593];

// ---- Social / analytics -----------------------------------------------------------------------
$schemaSameAs = ['https://maps.google.com/maps?cid=10062941840203095213'];
// true = no site-level noindex; preview hosts are kept out of the index by the nginx X-Robots-Tag header.
$allowIndexing = true;

$socialLinks       = [];                                  // none provided — footer renders icons only for platforms the client uses
$googleAnalyticsId = 'G-XXXXXXXXXX';                      // placeholder until the client's GA4 measurement ID is set

// ---- Forms ------------------------------------------------------------------------------------
$formAction      = 'https://db.pageone.cloud/functions/v1/leads/ledco-plumbing';   // build-plan form_action, verbatim
// HMAC secret for the spam-shield `_ft` field. Blank in the repo: injected by ~/crm/scripts/patch-leads-spamshield.py
// at promote time. p1-form-helpers.php skips the shield when empty.
$leadsFormSecret = '';

// ---- v8 components (written exactly as build-plan integrations holds them) ---------------------
$estimateTool   = [];   // integrations.estimate_tool.authorized is false
$bookingWindows = [];   // integrations.booking.authorized is false
$textUsNumber   = '';   // integrations.text_us_number is null (accepts_sms false) -> two-button sticky bar
$financing      = [];   // integrations.financing is null
$serviceZips    = [];   // integrations.service_zips not provided

$cssVersion = '2';   // the SINGLE framework.css cache-bust; bump here on every framework.css / critical.css change

// ---- Legal pages ------------------------------------------------------------------------------
// Entity type comes from the registered name "Ledco Plumbing LLC". State of formation was not collected;
// governing law uses the state the business operates in (Seminole, Seminole County, OK) until confirmed.
$companyEntityType = 'LLC';
$companyState      = 'Oklahoma';
$companyCounty     = 'Seminole';

// ---- Lead attribution (first-touch cookie + p1_attribution_fields()) — must stay last, before any output ----
require_once __DIR__ . '/attribution.php';
