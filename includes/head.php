<?php
/**
 * includes/head.php — doctype, <head>, meta, OG, fonts, critical CSS, schema; opens <body>.
 *
 * Page variables (set BEFORE including this file; all optional except as noted):
 *   $pageTitle        full <title>; default = "{primary keyword} & Plumbing in {city}, {state} | {site name}"
 *   $pageDescription  meta description (140-160 chars); default built from config
 *   $canonicalUrl     override; default computed from the request URI (never hand-set per page)
 *   $currentPage      nav state: 'home' | 'services' | 'services/{slug}' | 'service-areas' | 'areas/{slug}' | 'about' | 'blog' | 'faq' | 'contact' | 'legal'
 *   $pageType         'home|service|city|blog|about|faq|contact|other'  (+ $serviceSlug / $citySlug) — read by attribution.php
 *   $ogImage          absolute URL or /path; default /assets/images/og-default-v1.jpg
 *   $ogType           default 'website' ('article' on blog posts)
 *   $heroPreload      ['srcset' => '...-480.avif 480w, ...', 'sizes' => '100vw'] for a photo hero
 *   $pageSchema       one schema node, or a list of nodes, merged into the @graph after the Plumber node
 *   $noindex          true => <meta name="robots" content="noindex,nofollow"> (thank-you, 404)
 *   $bodyClass        extra classes for <body>
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$siteBase = rtrim($siteUrl, '/');

// --- Title / description / canonical -----------------------------------------------------------
$hdTitle = $pageTitle ?? ($primaryKeyword . ' & Plumbing in ' . $address['city'] . ', ' . $address['state'] . ' | ' . $siteName);
$hdDesc  = $pageDescription ?? ($siteName . ' provides ' . strtolower($primaryKeyword) . ', water heater repair and installation, leak detection, and sewer line repair in '
         . $address['city'] . ', ' . $address['state'] . '. Call ' . $phone . '.');
$hdCanon = $canonicalUrl ?? ($siteBase . requestCanonicalPath());

// --- Open Graph image: absolute URL ------------------------------------------------------------
$hdOg = $ogImage ?? '/assets/images/og-default-v1.jpg';
if (strpos($hdOg, 'http') !== 0) $hdOg = $siteBase . '/' . ltrim($hdOg, '/');
$hdOgIsDefault = strpos($hdOg, 'og-default-v1.jpg') !== false;
$hdOgType = $ogType ?? 'website';

// --- Robots ------------------------------------------------------------------------------------
$hdNoindex = !empty($noindex) || empty($allowIndexing);

// --- Schema graph: the Plumber node on every page + whatever the page adds ----------------------
$hdGraph = [localBusinessSchema($hdOg)];
if (!empty($pageSchema) && is_array($pageSchema)) {
    $hdNodes = isset($pageSchema['@type']) ? [$pageSchema] : $pageSchema;
    foreach ($hdNodes as $hdNode) $hdGraph[] = $hdNode;
}

// --- Logo analysis (shared with header.php / footer.php) ---------------------------------------
// Uses the client's logo file once one exists in /assets/images/ (logo-mark*, logo*), else the text logo.
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/logo.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo generateMetaTags($hdTitle, $hdDesc, $hdCanon), "\n"; ?>
<?php if ($hdNoindex): ?>
<meta name="robots" content="noindex,nofollow">
<?php endif; ?>
<meta name="theme-color" content="<?php echo esc($colors['primary']); ?>">

<!-- Open Graph -->
<meta property="og:type" content="<?php echo esc($hdOgType); ?>">
<meta property="og:title" content="<?php echo esc($hdTitle); ?>">
<meta property="og:description" content="<?php echo esc($hdDesc); ?>">
<meta property="og:url" content="<?php echo esc($hdCanon); ?>">
<meta property="og:image" content="<?php echo esc($hdOg); ?>">
<?php if ($hdOgIsDefault): ?>
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<?php endif; ?>
<meta property="og:site_name" content="<?php echo esc($siteName); ?>">
<meta property="og:locale" content="en_US">

<!-- Icons -->
<link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">

<!-- Fonts: self-hosted variable woff2 (@font-face lives in framework.css); preload the above-the-fold heading face only -->
<link rel="preload" href="/assets/fonts/space-grotesk.woff2" as="font" type="font/woff2" crossorigin>
<?php if (!empty($heroPreload['srcset'])): ?>
<link rel="preload" as="image" type="image/avif" imagesrcset="<?php echo esc($heroPreload['srcset']); ?>" imagesizes="<?php echo esc($heroPreload['sizes'] ?? '100vw'); ?>" fetchpriority="high">
<?php endif; ?>

<!-- Critical CSS inlined; framework.css loads without blocking render -->
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/critical.css'; ?></style>
<link rel="preload" href="/assets/css/framework.css?v=<?php echo esc($cssVersion); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/assets/css/framework.css?v=<?php echo esc($cssVersion); ?>"></noscript>
<?php if ($logoImage): /* after framework.css in DOM order so it wins the :root cascade — the bar grows to fit the logo */ ?>
<style>:root{--nav-height:<?php echo (int) $logoNavHeight; ?>px}@media(max-width:1000px){:root{--nav-height:<?php echo (int) $logoNavHeightMobile; ?>px}}</style>
<?php endif; ?>

<?php if (!empty($googleAnalyticsId)): ?>
<!-- Google Analytics (GA4) — placeholder, commented out until the client's measurement ID replaces G-XXXXXXXXXX in config.php.
<script defer src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc($googleAnalyticsId); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo esc($googleAnalyticsId); ?>');</script>
-->
<?php endif; ?>

<?php echo schemaScript($hdGraph), "\n"; ?>
</head>
<body class="page-<?php echo esc(preg_replace('/[^a-z0-9]+/', '-', strtolower($currentPage ?? 'page'))); ?><?php echo !empty($bodyClass) ? ' ' . esc($bodyClass) : ''; ?>">
