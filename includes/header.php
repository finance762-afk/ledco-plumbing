<?php
/**
 * includes/header.php — skip link, fixed glass header, mobile overlay menu; opens <main id="main-content">.
 * Included after head.php (which opens <body>). Needs $currentPage on the page for aria-current.
 *
 * Link integrity: every link except Home points at a page that exists on disk (pageLive()/serviceLive()/areaHref()).
 * Entries appear automatically as their pages are built — the nav never links to a 404.
 * Loop variables are prefixed ($navSvc, $navArea, ...) so they can never overwrite a page's own $svc/$area/$c.
 */
$navPhone     = formatPhone($phone);
$navPhoneHref = phoneHref($phone);

// ---- Build the link model once; desktop bar and mobile overlay both render from it ----------------
$navServices = [];
foreach ((array) $services as $navSvc) {
    if (serviceLive($navSvc['slug'])) {
        $navServices[] = ['name' => $navSvc['name'], 'href' => '/services/' . $navSvc['slug'] . '/', 'page' => 'services/' . $navSvc['slug']];
    }
}
$navAreas = [];
if (($tier ?? 'premium') === 'premium') {
    foreach ((array) $serviceAreaDetails as $navArea) {
        $navAreaHref = areaHref($navArea['slug']);
        if ($navAreaHref !== null) {
            $navAreas[] = ['name' => $navArea['city'] . ', ' . $navArea['state'], 'href' => $navAreaHref, 'page' => 'areas/' . $navArea['slug']];
        }
    }
}

$navItems = [['label' => 'Home', 'href' => '/', 'page' => 'home', 'children' => []]];
if (pageLive('/services/') || $navServices) {
    $navItems[] = ['label' => 'Services', 'href' => pageLive('/services/') ? '/services/' : null, 'page' => 'services', 'children' => $navServices, 'all' => pageLive('/services/') ? ['label' => 'All Services', 'href' => '/services/'] : null];
}
if (($tier ?? 'premium') === 'premium' && (pageLive(P1_AREAS_HUB) || $navAreas)) {
    $navItems[] = ['label' => 'Service Areas', 'href' => pageLive(P1_AREAS_HUB) ? P1_AREAS_HUB : null, 'page' => 'service-areas', 'children' => $navAreas, 'all' => pageLive(P1_AREAS_HUB) ? ['label' => 'All Service Areas', 'href' => P1_AREAS_HUB] : null];
}
if (pageLive('/about/'))   $navItems[] = ['label' => 'About',   'href' => '/about/',   'page' => 'about',   'children' => []];
if (($tier ?? 'premium') === 'premium' && pageLive('/blog/')) $navItems[] = ['label' => 'Blog', 'href' => '/blog/', 'page' => 'blog', 'children' => []];
if (pageLive('/contact/')) $navItems[] = ['label' => 'Contact', 'href' => '/contact/', 'page' => 'contact', 'children' => []];

$navLogoLabel = $siteName . ' — home';
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="site-header" data-header>
  <nav class="navbar" aria-label="Main navigation">
    <div class="navbar-inner container">
      <a class="site-logo<?php echo $logoImage ? '' : ' site-logo--text'; ?>" href="/" aria-label="<?php echo esc($navLogoLabel); ?>">
<?php if ($logoImage): ?>
        <img src="<?php echo esc($logoImage); ?>" alt="<?php echo esc($siteName); ?>" width="<?php echo (int) $logoW; ?>" height="<?php echo (int) $logoH; ?>"<?php echo $logoClass ? ' class="' . esc($logoClass) . '"' : ''; ?> fetchpriority="low" decoding="async">
<?php else: ?>
        <svg class="logo-mark" viewBox="0 0 64 64" width="44" height="44" aria-hidden="true" focusable="false"><rect width="64" height="64" rx="14" fill="var(--color-primary)"/><path d="M20 14h11v29h15v9H20z" fill="var(--color-accent)"/></svg>
        <span class="logo-text"><span class="logo-name"><?php echo esc($brandName); ?></span><span class="brand-sub">Plumbing &middot; <?php echo esc($address['city'] . ', ' . $address['state']); ?></span></span>
<?php endif; ?>
      </a>

      <ul class="navbar-links">
<?php foreach ($navItems as $navItem): ?>
<?php if ($navItem['children']): ?>
        <li class="has-dropdown">
<?php if ($navItem['href']): ?>
          <a href="<?php echo esc($navItem['href']); ?>"<?php echo navCurrent($navItem['page']); ?> aria-haspopup="true"><?php echo esc($navItem['label']); ?> <?php icon('chevron-down', 14); ?></a>
<?php else: ?>
          <button type="button" class="dropdown-toggle" aria-haspopup="true"><?php echo esc($navItem['label']); ?> <?php icon('chevron-down', 14); ?></button>
<?php endif; ?>
          <ul class="dropdown" role="menu" style="display:none">
<?php foreach ($navItem['children'] as $navChild): ?>
            <li role="none"><a role="menuitem" href="<?php echo esc($navChild['href']); ?>"<?php echo isActivePage($navChild['page']) ? ' aria-current="page"' : ''; ?>><?php echo esc($navChild['name']); ?></a></li>
<?php endforeach; ?>
<?php if (!empty($navItem['all'])): ?>
            <li role="none" class="dropdown-all"><a role="menuitem" href="<?php echo esc($navItem['all']['href']); ?>"><?php echo esc($navItem['all']['label']); ?> &rarr;</a></li>
<?php endif; ?>
          </ul>
        </li>
<?php else: ?>
        <li><a href="<?php echo esc($navItem['href']); ?>"<?php echo navCurrent($navItem['page']); ?>><?php echo esc($navItem['label']); ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
      </ul>

      <div class="navbar-cta">
        <a class="btn btn-secondary navbar-phone" href="<?php echo esc($navPhoneHref); ?>" aria-label="Call <?php echo esc($siteName); ?> at <?php echo esc($navPhone); ?>"><?php icon('phone', 18); ?><span><?php echo esc($navPhone); ?></span></a>
        <?php echo estimateTrigger('btn btn-primary btn-nav-cta', 'Free Estimate'), "\n"; ?>
      </div>

      <button class="hamburger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>
    </div>
  </nav>
</header>

<!-- Mobile overlay lives OUTSIDE <header>: the header's backdrop-filter would become the containing block and shrink position:fixed to the bar height -->
<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
  <div class="mobile-menu-inner">
    <nav aria-label="Mobile navigation">
      <ul class="mobile-menu-links">
<?php foreach ($navItems as $navItem): ?>
        <li>
<?php if ($navItem['href']): ?>
          <a href="<?php echo esc($navItem['href']); ?>"<?php echo navCurrent($navItem['page']); ?>><?php echo esc($navItem['label']); ?></a>
<?php else: ?>
          <span class="mobile-menu-heading"><?php echo esc($navItem['label']); ?></span>
<?php endif; ?>
<?php if ($navItem['children']): ?>
          <ul class="sub">
<?php foreach ($navItem['children'] as $navChild): ?>
            <li><a href="<?php echo esc($navChild['href']); ?>"<?php echo isActivePage($navChild['page']) ? ' aria-current="page"' : ''; ?>><?php echo esc($navChild['name']); ?></a></li>
<?php endforeach; ?>
          </ul>
<?php endif; ?>
        </li>
<?php endforeach; ?>
      </ul>
    </nav>
    <div class="mobile-menu-cta">
      <a class="btn btn-accent btn-lg" href="<?php echo esc($navPhoneHref); ?>"><?php icon('phone', 20); ?> Call <?php echo esc($navPhone); ?></a>
      <?php echo estimateTrigger('btn btn-outline-white btn-lg', 'Get a Free Estimate'), "\n"; ?>
    </div>
    <p class="mobile-menu-meta"><?php echo esc($businessHours); ?> &middot; <?php echo esc($address['city'] . ', ' . $address['state']); ?></p>
  </div>
</div>

<main id="main-content">
