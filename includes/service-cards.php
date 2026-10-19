<?php
/**
 * includes/service-cards.php — card copy for the services grid on /services/ and the
 * "other services" grid at the foot of each /services/{slug}/ page (required-components.md).
 * Keyed by the config.php $services slugs. Exactly 3 bullets per card, 3-6 words each.
 * No client job photos exist yet (build-plan assets.images is empty), so cards are icon-led like
 * the homepage grid; add a .service-card__image block per card once real photos are uploaded.
 *
 * p1_render_service_card($svc, $tint, $extraClass, $attrs) echoes one card.
 */
$serviceCardCopy = [
    'drain-cleaning' => [
        'icon'    => 'droplets',
        'desc'    => 'Clearing clogged and slow drains, from one sink to the main line.',
        'bullets' => ['Kitchen, bath and laundry drains', 'Main line backups cleared', 'Each fixture tested after'],
    ],
    'water-heater-repair-installation' => [
        'icon'    => 'flame',
        'desc'    => 'Repair for heaters that run cold or leak, and new installs.',
        'bullets' => ['Failed parts found first', 'Leaking tanks replaced', 'New heater filled and checked'],
    ],
    'leak-detection-repair' => [
        'icon'    => 'search',
        'desc'    => 'Finding hidden leaks in walls, slabs and yard lines, then fixing them.',
        'bullets' => ['High water bills traced', 'Slab and wall leaks located', 'Yard service lines repaired'],
    ],
    'sewer-line-repair' => [
        'icon'    => 'waves',
        'desc'    => 'Repair of backed-up, cracked or root-filled sewer lines.',
        'bullets' => ['Whole-house backups stopped', 'Broken sections replaced', 'Root-damaged joints repaired'],
    ],
    'commercial-plumbing' => [
        'icon'    => 'building-2',
        'desc'    => 'Plumbing repair for Seminole-area shops, offices and rentals.',
        'bullets' => ['Restrooms back in service', 'Kitchen and floor drains', 'Weekend calls taken'],
    ],
];

if (!function_exists('p1_render_service_card')) {
    /** One service-card-with-image article (icon-led until job photos exist). Links only when the page is live. */
    function p1_render_service_card(array $svc, int $tint, string $extraClass = '', string $attrs = ''): void {
        global $serviceCardCopy;
        $copy = $serviceCardCopy[$svc['slug']] ?? ['icon' => 'wrench', 'desc' => $svc['description'], 'bullets' => []];
        $live = serviceLive($svc['slug']);
        ?>
      <article class="service-card-with-image card-tint-<?php echo $tint; ?> <?php echo esc($extraClass); ?> reveal-delay-<?php echo $tint; ?>"<?php echo $attrs !== '' ? ' ' . $attrs : ''; ?>>
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($copy['icon'], 24); ?></div>
          <h3><?php echo esc($svc['name']); ?></h3>
          <p class="service-card__desc"><?php echo esc($copy['desc']); ?></p>
          <ul>
<?php foreach ($copy['bullets'] as $cardBullet): ?>
            <li><?php echo esc($cardBullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($live): ?>
          <a href="/services/<?php echo esc($svc['slug']); ?>/" class="service-card__cta">Learn more<span class="sr-only"> about <?php echo esc(strtolower($svc['name'])); ?></span></a>
<?php else: ?>
          <button type="button" class="service-card__cta" data-open-estimate>Get an estimate<span class="sr-only"> for <?php echo esc(strtolower($svc['name'])); ?></span></button>
<?php endif; ?>
        </div>
      </article>
<?php
    }
}

if (!function_exists('p1_other_services')) {
    /** The three services that follow $slug in the registry (wrapping), so each service appears on exactly three sibling pages. */
    function p1_other_services(string $slug, int $count = 3): array {
        global $services;
        $list = array_values((array) $services);
        $n = count($list);
        $at = 0;
        foreach ($list as $i => $s) { if ($s['slug'] === $slug) { $at = $i; break; } }
        $out = [];
        for ($k = 1; $k <= min($count, $n - 1); $k++) $out[] = $list[($at + $k) % $n];
        return $out;
    }
}
