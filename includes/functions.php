<?php
/**
 * includes/functions.php — shared helpers for head.php / header.php / footer.php and every page.
 * Loaded once via require_once from head.php. Everything is function_exists-guarded so a page can
 * include it again without a redeclare error. Helpers read config.php globals ($siteName, $phone, ...).
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

/** Public hub path for the service-area overview (individual area pages live at /areas/{slug}/). */
if (!defined('P1_AREAS_HUB')) define('P1_AREAS_HUB', '/service-areas/');

// ---- Escaping / small utilities ---------------------------------------------------------------

if (!function_exists('esc')) {
    function esc($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string {
        $text = strtolower(trim($text));
        $text = str_replace('&', ' and ', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim((string) $text, '-');
    }
}

// ---- Inline SVG icons (Lucide, copied at build time — never runtime injection) ----------------

if (!function_exists('iconSvg')) {
    /** Returns the raw <svg> from references/lucide-icons/<name>.svg with aria-hidden + width/height. */
    function iconSvg(string $name, int $size = 20, string $class = ''): string {
        static $cache = [];
        $name = preg_replace('/[^a-z0-9-]/', '', strtolower($name));
        if (!isset($cache[$name])) {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/references/lucide-icons/' . $name . '.svg';
            $raw = is_file($file) ? (string) file_get_contents($file) : '';
            $raw = preg_replace('/<!--.*?-->/s', '', $raw);
            $cache[$name] = trim((string) $raw);
        }
        if ($cache[$name] === '') return '';
        $svg = preg_replace('/\swidth="[^"]*"/', '', $cache[$name], 1);
        $svg = preg_replace('/\sheight="[^"]*"/', '', $svg, 1);
        $svg = preg_replace('/\sclass="[^"]*"/', '', $svg, 1);
        $attrs = ' class="icon' . ($class !== '' ? ' ' . esc($class) : '') . '" width="' . $size . '" height="' . $size . '" aria-hidden="true" focusable="false"';
        $svg = preg_replace('/<svg\b/', '<svg' . $attrs, $svg, 1);
        return preg_replace('/\s+/', ' ', $svg);
    }
}
if (!function_exists('icon')) {
    function icon(string $name, int $size = 20, string $class = ''): void {
        echo iconSvg($name, $size, $class);
    }
}

// ---- Page state / link integrity --------------------------------------------------------------

if (!function_exists('isActivePage')) {
    /** Exact match against the page's $currentPage ('home', 'services', 'services/drain-cleaning', 'about', ...). */
    function isActivePage(string $page): bool {
        global $currentPage;
        return isset($currentPage) && $currentPage === $page;
    }
}
if (!function_exists('isActiveSection')) {
    /** True for the page itself and anything beneath it ('services' is a section of 'services/drain-cleaning'). */
    function isActiveSection(string $section): bool {
        global $currentPage;
        if (!isset($currentPage)) return false;
        return $currentPage === $section || strpos((string) $currentPage, $section . '/') === 0;
    }
}
if (!function_exists('navCurrent')) {
    /** aria-current attribute string for a nav link: "page" on the exact page, "true" on a parent section. */
    function navCurrent(string $page): string {
        if (isActivePage($page)) return ' aria-current="page"';
        if (isActiveSection($page)) return ' aria-current="true"';
        return '';
    }
}
if (!function_exists('pageLive')) {
    /** Link integrity: true only when the page exists on disk ('/about/' -> /about/index.php, '/thank-you' -> /thank-you.php). */
    function pageLive(string $path): bool {
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        $path = '/' . trim($path, '/');
        if ($path === '/') return true;
        return is_file($root . $path . '/index.php') || is_file($root . $path . '.php');
    }
}
if (!function_exists('serviceLive')) {
    function serviceLive(string $slug): bool {
        return pageLive('/services/' . $slug . '/');
    }
}
if (!function_exists('areaLive')) {
    function areaLive(string $slug): bool {
        return is_dir($_SERVER['DOCUMENT_ROOT'] . '/areas/' . $slug) && pageLive('/areas/' . $slug . '/');
    }
}
if (!function_exists('areaHref')) {
    /** /areas/{slug}/ once built; the hub anchor while only the hub exists; null when neither exists yet. */
    function areaHref(string $slug): ?string {
        if (areaLive($slug)) return '/areas/' . $slug . '/';
        if (pageLive(P1_AREAS_HUB)) return P1_AREAS_HUB . '#' . $slug;
        return null;
    }
}
if (!function_exists('estimateTrigger')) {
    /** "Free Estimate" trigger: a real link to /contact/ when it exists (works without JS), else a button. Both open #estimate-dialog via main.js. */
    function estimateTrigger(string $class, string $label, string $extra = ''): string {
        if (pageLive('/contact/')) {
            return '<a class="' . esc($class) . '" href="/contact/" data-open-estimate' . ($extra !== '' ? ' ' . $extra : '') . '>' . $label . '</a>';
        }
        return '<button type="button" class="' . esc($class) . '" data-open-estimate' . ($extra !== '' ? ' ' . $extra : '') . '>' . $label . '</button>';
    }
}

// ---- Names, phone, slugs ----------------------------------------------------------------------

if (!function_exists('formatPhone')) {
    /** Any US phone string -> "(405) 257-3096". Returns the input untouched if it is not 10/11 digits. */
    function formatPhone(string $phone): string {
        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 11 && $digits[0] === '1') $digits = substr($digits, 1);
        if (strlen($digits) !== 10) return $phone;
        return '(' . substr($digits, 0, 3) . ') ' . substr($digits, 3, 3) . '-' . substr($digits, 6);
    }
}
if (!function_exists('phoneHref')) {
    function phoneHref(string $phone): string {
        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 10) $digits = '1' . $digits;
        return 'tel:+' . $digits;
    }
}
if (!function_exists('getServiceSlug')) {
    /** Service name -> slug, using the config.php $services registry first so slugs always match build-plan pages[].slug. */
    function getServiceSlug(string $name): string {
        global $services;
        foreach ((array) $services as $svc) {
            if (isset($svc['name'], $svc['slug']) && strcasecmp($svc['name'], $name) === 0) return $svc['slug'];
        }
        return slugify($name);
    }
}
if (!function_exists('getAreaSlug')) {
    /** City (+ optional state) -> area slug ('Seminole' -> 'seminole-ok'), registry first. */
    function getAreaSlug(string $city, string $state = ''): string {
        global $serviceAreaDetails;
        foreach ((array) $serviceAreaDetails as $area) {
            if (isset($area['city'], $area['slug']) && strcasecmp($area['city'], $city) === 0) return $area['slug'];
        }
        return slugify($city . ($state !== '' ? '-' . $state : ''));
    }
}

// ---- Hours ------------------------------------------------------------------------------------

if (!function_exists('groupedHours')) {
    /** Collapses consecutive days that share hours: [['days' => 'Mon–Sun', 'label' => '7:00 AM – 5:00 PM'], ...]. */
    function groupedHours(array $hours): array {
        $groups = [];
        foreach ($hours as $row) {
            $last = count($groups) - 1;
            if ($last >= 0 && $groups[$last]['label'] === $row['label']) {
                $groups[$last]['last'] = $row['short'];
            } else {
                $groups[] = ['first' => $row['short'], 'last' => $row['short'], 'label' => $row['label']];
            }
        }
        foreach ($groups as &$g) {
            $g['days'] = $g['first'] === $g['last'] ? $g['first'] : $g['first'] . '–' . $g['last'];
        }
        unset($g);
        return $groups;
    }
}

// ---- Schema helpers (arrays; head.php / pages serialise them into one @graph) ------------------

if (!function_exists('schemaId')) {
    function schemaId(string $fragment): string {
        global $siteUrl;
        return rtrim((string) $siteUrl, '/') . '/#' . $fragment;
    }
}
if (!function_exists('localBusinessSchema')) {
    /** Full Plumber node from config.php. Address privacy, hours, geo, services and areas all come from config; empty values are omitted. Never emits a rating node (self-serving ratings are forbidden). */
    function localBusinessSchema(string $image = ''): array {
        global $siteName, $siteUrl, $phoneE164, $email, $businessDescription, $address, $addressPublic, $geo, $gbp,
               $hours, $services, $serviceAreaDetails, $schemaSameAs, $socialLinks, $licenseNumber;
        $addr = ['@type' => 'PostalAddress'];
        if (!empty($addressPublic) && !empty($address['street'])) $addr['streetAddress'] = $address['street'];
        $addr['addressLocality'] = $address['city'];
        $addr['addressRegion']   = $address['state'];
        if (!empty($address['zip'])) $addr['postalCode'] = $address['zip'];
        $addr['addressCountry'] = 'US';

        $node = [
            '@type'       => 'Plumber',
            '@id'         => schemaId('organization'),
            'name'        => $siteName,
            'url'         => rtrim((string) $siteUrl, '/') . '/',
            'telephone'   => $phoneE164,
            'email'       => $email,
            'description' => $businessDescription,
            'address'     => $addr,
        ];
        if ($image !== '') $node['image'] = $image;
        if (!empty($geo['lat']) && !empty($geo['lng'])) {
            $node['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => $geo['lat'], 'longitude' => $geo['lng']];
        }
        if (!empty($gbp['url'])) $node['hasMap'] = $gbp['url'];

        $specs = [];
        foreach (groupedHours((array) $hours) as $g) {
            // collect full day names for this group
            $days = [];
            $on = false;
            foreach ((array) $hours as $row) {
                if ($row['short'] === $g['first']) $on = true;
                if ($on) $days[] = $row['day'];
                if ($row['short'] === $g['last']) break;
            }
            $first = null;
            foreach ((array) $hours as $row) { if ($row['short'] === $g['first']) { $first = $row; break; } }
            if ($first) $specs[] = ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $days, 'opens' => $first['opens'], 'closes' => $first['closes']];
        }
        if ($specs) $node['openingHoursSpecification'] = $specs;

        $areas = [];
        foreach ((array) $serviceAreaDetails as $a) {
            $areas[] = ['@type' => 'City', 'name' => $a['city'], 'containedInPlace' => ['@type' => 'State', 'name' => 'Oklahoma']];
        }
        if ($areas) $node['areaServed'] = $areas;

        $offers = [];
        foreach ((array) $services as $svc) {
            $offers[] = ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $svc['name']]];
        }
        if ($offers) $node['hasOfferCatalog'] = ['@type' => 'OfferCatalog', 'name' => $siteName . ' services', 'itemListElement' => $offers];

        $same = array_values(array_filter(array_merge((array) $schemaSameAs, array_values((array) $socialLinks))));
        if ($same) $node['sameAs'] = array_values(array_unique($same));
        if (!empty($licenseNumber)) $node['identifier'] = $licenseNumber;
        return $node;
    }
}
if (!function_exists('generateServiceSchema')) {
    /** $service = a $services entry from config.php (name, slug, description). Provider points at the #organization node. */
    function generateServiceSchema(array $service): array {
        global $siteUrl, $address;
        $url = rtrim((string) $siteUrl, '/') . '/services/' . $service['slug'] . '/';
        return [
            '@type'       => 'Service',
            '@id'         => $url . '#service',
            'name'        => $service['name'],
            'serviceType' => $service['name'],
            'description' => $service['description'] ?? '',
            'url'         => $url,
            'provider'    => ['@id' => schemaId('organization')],
            'areaServed'  => ['@type' => 'City', 'name' => $address['city'], 'containedInPlace' => ['@type' => 'State', 'name' => 'Oklahoma']],
        ];
    }
}
if (!function_exists('generateServicePageSchema')) {
    /**
     * Service page @graph nodes: Service (#service-{slug}, provider -> #organization), WebPage with
     * Speakable (.hero-answer, .answer-block), BreadcrumbList, and FAQPage only when $faqs is non-empty.
     */
    function generateServicePageSchema(array $service, string $title, string $description, array $faqs = []): array {
        global $siteUrl, $serviceAreaDetails;
        $url = rtrim((string) $siteUrl, '/') . '/services/' . $service['slug'] . '/';
        $areas = [];
        foreach ((array) $serviceAreaDetails as $a) {
            $areas[] = ['@type' => 'City', 'name' => $a['city'], 'containedInPlace' => ['@type' => 'State', 'name' => 'Oklahoma']];
        }
        $nodes = [
            [
                '@type'       => 'Service',
                '@id'         => $url . '#service-' . $service['slug'],
                'name'        => $service['name'],
                'serviceType' => $service['name'],
                'description' => $description,
                'url'         => $url,
                'provider'    => ['@id' => schemaId('organization')],
                'areaServed'  => $areas,
            ],
            [
                '@type'       => 'WebPage',
                '@id'         => $url . '#webpage',
                'url'         => $url,
                'name'        => $title,
                'description' => $description,
                'isPartOf'    => ['@id' => schemaId('website')],
                'about'       => ['@id' => $url . '#service-' . $service['slug']],
                'breadcrumb'  => ['@id' => $url . '#breadcrumb'],
                'speakable'   => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['.hero-answer', '.answer-block']],
            ],
            ['@id' => $url . '#breadcrumb'] + generateBreadcrumbSchema([['Home', '/'], ['Services', '/services/'], [$service['name'], '/services/' . $service['slug'] . '/']]),
        ];
        if ($faqs) $nodes[] = generateFAQSchema($faqs);
        return $nodes;
    }
}
if (!function_exists('generateFAQSchema')) {
    /** $faqs = [['q' => '...', 'a' => '...'], ...] — must mirror the visible FAQ exactly. AI-comprehension aid only (rich results retired). */
    function generateFAQSchema(array $faqs): array {
        $items = [];
        foreach ($faqs as $faq) {
            $items[] = ['@type' => 'Question', 'name' => $faq['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']]];
        }
        return ['@type' => 'FAQPage', 'mainEntity' => $items];
    }
}
if (!function_exists('generateBreadcrumbSchema')) {
    /** $crumbs = [['Home', '/'], ['Services', '/services/'], ['Drain Cleaning', '/services/drain-cleaning/']] */
    function generateBreadcrumbSchema(array $crumbs): array {
        global $siteUrl;
        $items = [];
        foreach (array_values($crumbs) as $i => $crumb) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb[0], 'item' => rtrim((string) $siteUrl, '/') . $crumb[1]];
        }
        return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }
}
if (!function_exists('schemaScript')) {
    /** Serialises nodes into a single @graph JSON-LD <script>. */
    function schemaScript(array $nodes): string {
        $json = json_encode(['@context' => 'https://schema.org', '@graph' => array_values($nodes)],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT);
        return '<script type="application/ld+json">' . "\n" . $json . "\n" . '</script>';
    }
}

// ---- SEO helper -------------------------------------------------------------------------------

if (!function_exists('generateMetaTags')) {
    /** <title>, meta description and self-referencing canonical, escaped. */
    function generateMetaTags(string $title, string $description, string $canonical): string {
        return '<title>' . esc($title) . "</title>\n"
             . '<meta name="description" content="' . esc($description) . "\">\n"
             . '<link rel="canonical" href="' . esc($canonical) . '">';
    }
}
if (!function_exists('requestCanonicalPath')) {
    /** Canonical path from the request URI: no query, no index.php / .php, trailing slash for real directories. */
    function requestCanonicalPath(): string {
        $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $path = preg_replace('#/index\.php$#', '/', $path);
        $path = preg_replace('#\.php$#', '', $path);
        $path = '/' . ltrim($path, '/');
        if ($path !== '/' && substr($path, -1) !== '/' && is_dir(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $path)) $path .= '/';
        return $path;
    }
}
