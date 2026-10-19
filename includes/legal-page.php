<?php
/**
 * includes/legal-page.php — shared pieces for the four legal pages (privacy-policy, terms, cookie-policy, accessibility).
 *
 *   p1_legal_style()                         the <style> block: 40vh solid hero + single-column .legal-prose, tokens only
 *   p1_legal_hero_open($title, $eyebrow) / p1_legal_hero_close($updated)   <section class="hero hero--legal"> + breadcrumb around the page's own <h1>
 *   p1_legal_contact()                       the standard contact block that closes every policy
 *   p1_legal_schema($title, $desc, $path)    WebPage + BreadcrumbList nodes for $pageSchema
 *
 * Legal pages are indexable, carry no reveal classes, and are linked only from the footer legal row.
 */
if (!function_exists('p1_legal_style')) {
    function p1_legal_style(): string {
        return <<<'CSS'
<style>
/* Legal pages — plain, readable, no fireworks. Tokens only. */
.legal-page h1, .legal-page h2, .legal-page h3 { text-wrap: balance; }
.legal-page .hero--legal { min-height: 40vh; display: flex; align-items: flex-end; position: relative; isolation: isolate; background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%); }
.legal-page .hero--legal::after { content: ""; position: absolute; inset: auto 0 0 0; height: var(--space-1); background: var(--color-accent); z-index: -1; }
.legal-page .hero--legal .container { width: min(var(--max-width), 100% - 2 * clamp(1rem, 4vw, 2.5rem)); margin-inline: auto; }
.legal-page .hero--legal h1 { margin: var(--space-2) 0 var(--space-sm); max-width: 24ch; }
.legal-page .hero--legal .legal-updated { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.legal-page .breadcrumb { margin: 0 0 var(--space-md); color: color-mix(in srgb, var(--color-white) 70%, transparent); align-items: center; }
.legal-page .breadcrumb [aria-current] { color: var(--color-white); }
.legal-page .breadcrumb a:hover { color: var(--color-white); }
.legal-body { background: var(--color-paper); padding-block: clamp(2.5rem, 5vw, 4rem); }
.legal-body .legal-prose { max-width: 65ch; margin-inline: auto; color: var(--color-ink-2); }
.legal-body .legal-prose > p:first-child { font-size: var(--fs-lead); color: var(--color-ink); }
.legal-body .legal-prose h2 { color: var(--color-ink); border-top: 1px solid var(--color-line); padding-top: var(--space-lg); }
.legal-body .legal-prose h2:first-of-type { border-top: 0; padding-top: 0; margin-top: var(--space-xl); }
.legal-body .legal-prose h3 { color: var(--color-ink); scroll-margin-top: calc(var(--nav-height) + var(--space-md)); }
.legal-body .legal-prose a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; overflow-wrap: anywhere; }
.legal-body .legal-prose li { margin-bottom: var(--space-2); }
.legal-body .legal-prose address { font-style: normal; padding: var(--space-md) var(--space-lg); background: var(--color-card-tint-1); border-left: 3px solid var(--color-accent); border-radius: 0 var(--radius) var(--radius) 0; }
.legal-body .legal-stamp { margin-top: var(--space-xl); padding-top: var(--space-md); border-top: 1px solid var(--color-line); font-size: var(--fs-small); color: var(--color-muted); }
.legal-body table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); margin: var(--space-md) 0; }
.legal-body th, .legal-body td { text-align: left; padding: var(--space-sm) var(--space-md); border-bottom: 1px solid var(--color-line); vertical-align: top; }
.legal-body thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); border-bottom: 2px solid var(--color-ink); }
.legal-body .legal-table-wrap { overflow-x: auto; }
@media (max-width: 600px) {
  .legal-page .hero--legal { min-height: 0; }
  .legal-body thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
  .legal-body table, .legal-body tbody, .legal-body tr, .legal-body th, .legal-body td { display: block; width: 100%; }
  .legal-body tbody tr { padding: var(--space-sm) 0; border-bottom: 1px solid var(--color-line); }
  .legal-body tbody th, .legal-body tbody td { padding: var(--space-1) 0; border: 0; }
}
</style>
CSS;
    }
}

if (!function_exists('p1_legal_hero_open')) {
    /** Hero up to the eyebrow. The page writes its own <h1 id="legal-title"> between open and close (one H1, visible in the page file). */
    function p1_legal_hero_open(string $title, string $eyebrow): string {
        $t = esc($title);
        return '<section class="hero hero--legal" aria-labelledby="legal-title">' . "\n"
             . '  <div class="container">' . "\n"
             . '    <nav class="breadcrumb" aria-label="Breadcrumb"><ol>'
             . '<li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li><li><span aria-current="page">' . $t . '</span></li>'
             . '</ol></nav>' . "\n"
             . '    <span class="eyebrow">' . esc($eyebrow) . '</span>' . "\n";
    }
}
if (!function_exists('p1_legal_hero_close')) {
    function p1_legal_hero_close(string $updated): string {
        return '    <p class="legal-updated">Last Updated: ' . esc($updated) . '</p>' . "\n"
             . '  </div>' . "\n"
             . '</section>' . "\n";
    }
}

if (!function_exists('p1_legal_contact')) {
    function p1_legal_contact(): string {
        global $companyName, $companyEmail, $companyPhone, $companyPhoneE164, $companyAddress;
        return '<address><strong>' . esc($companyName) . '</strong><br>'
             . 'Phone: <a href="tel:' . esc($companyPhoneE164) . '">' . esc($companyPhone) . '</a><br>'
             . 'Address: ' . esc($companyAddress) . '</address>';
    }
}

if (!function_exists('p1_legal_schema')) {
    /** WebPage + BreadcrumbList nodes; head.php prepends the Plumber node. */
    function p1_legal_schema(string $title, string $description, string $path): array {
        global $siteUrl;
        $base = rtrim((string) $siteUrl, '/');
        $url  = $base . $path;
        return [
            [
                '@type'       => 'WebPage',
                '@id'         => $url . '#webpage',
                'url'         => $url,
                'name'        => $title,
                'description' => $description,
                'inLanguage'  => 'en-US',
                'isPartOf'    => ['@id' => schemaId('website')],
                'about'       => ['@id' => schemaId('organization')],
                'breadcrumb'  => ['@id' => $url . '#breadcrumb'],
            ],
            ['@id' => $url . '#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], [preg_replace('/ \|.*$/', '', $title), $path]]),
        ];
    }
}
