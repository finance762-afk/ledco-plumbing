<?php
/**
 * sitemap.php — served at /sitemap.xml (see the .htaccess rewrite). Pages are discovered from config.php + what exists on disk
 * (pageLive()), posts come from $blogPosts in includes/blog-data.php. Never hand-edit a URL in here: add the page or the post and it appears.
 * URLs are the trailing-slash directory form and match each page's canonical exactly. Image entries are embedded per URL
 * (this replaces a separate sitemap-images.xml).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';

header('Content-Type: application/xml; charset=utf-8');

$baseUrl = rtrim($siteUrl, '/');
$root    = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

/** Last-modified date of a page's file, Y-m-d. */
$lastmod = function (string $path) use ($root): string {
    $file = $path === '/' ? $root . '/index.php' : $root . rtrim($path, '/') . '/index.php';
    return is_file($file) ? date('Y-m-d', (int) filemtime($file)) : date('Y-m-d');
};

$pages = [['path' => '/', 'priority' => '1.0', 'changefreq' => 'weekly']];
if (pageLive('/services/')) $pages[] = ['path' => '/services/', 'priority' => '0.8', 'changefreq' => 'monthly'];
foreach ((array) $services as $svc) {
    if (serviceLive($svc['slug'])) $pages[] = ['path' => '/services/' . $svc['slug'] . '/', 'priority' => '0.8', 'changefreq' => 'monthly'];
}
if (pageLive(P1_AREAS_HUB)) $pages[] = ['path' => P1_AREAS_HUB, 'priority' => '0.6', 'changefreq' => 'monthly'];
foreach ((array) $serviceAreaDetails as $area) {
    if (areaLive($area['slug'])) $pages[] = ['path' => '/service-areas/' . $area['slug'] . '/', 'priority' => '0.6', 'changefreq' => 'monthly'];
}
foreach (['/about/', '/contact/', '/faq/'] as $path) {
    if (pageLive($path)) $pages[] = ['path' => $path, 'priority' => '0.6', 'changefreq' => 'monthly'];
}
if (pageLive('/blog/')) $pages[] = ['path' => '/blog/', 'priority' => '0.6', 'changefreq' => 'weekly'];
foreach (['/privacy-policy/', '/terms/', '/cookie-policy/', '/accessibility/'] as $path) {
    if (pageLive($path)) $pages[] = ['path' => $path, 'priority' => '0.3', 'changefreq' => 'yearly'];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($pages as $page): ?>
  <url>
    <loc><?php echo htmlspecialchars($baseUrl . $page['path'], ENT_XML1); ?></loc>
    <lastmod><?php echo $lastmod($page['path']); ?></lastmod>
    <changefreq><?php echo $page['changefreq']; ?></changefreq>
    <priority><?php echo $page['priority']; ?></priority>
  </url>
<?php endforeach; ?>
<?php foreach ((array) $blogPosts as $post): ?>
  <url>
    <loc><?php echo htmlspecialchars($baseUrl . '/blog/' . $post['slug'] . '/', ENT_XML1); ?></loc>
    <lastmod><?php echo htmlspecialchars($post['dateISO'], ENT_XML1); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
<?php if (!empty($post['image']) && is_file($root . $post['image'])): ?>
    <image:image>
      <image:loc><?php echo htmlspecialchars($baseUrl . $post['image'], ENT_XML1); ?></image:loc>
      <image:caption><?php echo htmlspecialchars($post['alt'], ENT_XML1); ?></image:caption>
      <image:title><?php echo htmlspecialchars($post['title'], ENT_XML1); ?></image:title>
    </image:image>
<?php endif; ?>
  </url>
<?php endforeach; ?>
</urlset>
