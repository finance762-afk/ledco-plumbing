<?php
/**
 * includes/blog-data.php — single source of truth for all blog post metadata.
 * Newest post FIRST. The blog index, the homepage "From the Blog" card, each post's related-articles block and
 * sitemap.php all read $blogPosts. Never hardcode a post list anywhere else.
 *
 * Adding a post = one entry here + one /blog/{slug}/index.php. Titles are <= 60 characters with no brand suffix.
 *
 * IMAGES: the client has uploaded no job photos yet (build-plan assets.images is empty), so both launch posts use the
 * branded card /assets/images/og-default-v1-960.webp (file verified on disk). Swap in real photos from /assets/images/
 * (use the -960.webp variants) once they exist, and update 'alt' to describe the new photo.
 */
$blogPosts = [
    [
        'slug'     => 'frozen-pipes-seminole-oklahoma',
        'title'    => 'How to Keep Pipes From Freezing in Seminole, OK',
        'excerpt'  => 'Seminole\'s January lows average about 26°F. Here is which pipes split first, what to do before a hard freeze, and what to do when one bursts.',
        'image'    => '/assets/images/og-default-v1-960.webp',
        'alt'      => 'Ledco Plumbing card for Seminole, OK listing drain cleaning, water heaters, leak detection, sewer line repair and commercial plumbing',
        'date'     => 'October 19, 2026',
        'dateISO'  => '2026-10-19',
        'category' => 'Seasonal Plumbing',
        'readtime' => '5 min read',
    ],
    [
        'slug'     => 'plumbing-repair-cost-seminole-ok',
        'title'    => 'What Decides Plumbing Repair Cost in Seminole, OK?',
        'excerpt'  => 'Four things set the price of a plumbing repair: the cause, where the pipe is, the parts and the kind of building. What each means in a Seminole house or shop.',
        'image'    => '/assets/images/og-default-v1-960.webp',
        'alt'      => 'Ledco Plumbing card for Seminole, OK listing drain cleaning, water heaters, leak detection, sewer line repair and commercial plumbing',
        'date'     => 'October 19, 2026',
        'dateISO'  => '2026-10-19',
        'category' => 'Plumbing Costs',
        'readtime' => '5 min read',
    ],
];

if (!function_exists('p1_blog_post')) {
    /** One registry entry by slug, or null. */
    function p1_blog_post(string $slug): ?array {
        global $blogPosts;
        foreach ((array) $blogPosts as $post) { if ($post['slug'] === $slug) return $post; }
        return null;
    }
}
if (!function_exists('p1_blog_related')) {
    /** Up to $count other posts: same category first, then the most recent. */
    function p1_blog_related(string $slug, int $count = 3): array {
        global $blogPosts;
        $self = p1_blog_post($slug);
        $same = $rest = [];
        foreach ((array) $blogPosts as $post) {
            if ($post['slug'] === $slug) continue;
            if ($self && $post['category'] === $self['category']) $same[] = $post; else $rest[] = $post;
        }
        return array_slice(array_merge($same, $rest), 0, $count);
    }
}
if (!function_exists('p1_blog_card')) {
    /** One .blog-card (an <a>): image, category badge, date + read time, title, excerpt, CTA. */
    function p1_blog_card(array $post, string $extraClass = '', bool $eager = false): void {
        $img = $post['image'] ?? '';
        ?>
      <a class="blog-card <?php echo esc($extraClass); ?>" href="/blog/<?php echo esc($post['slug']); ?>/">
<?php if ($img !== ''): ?>
        <div class="blog-card__image"><img src="<?php echo esc($img); ?>" alt="<?php echo esc($post['alt']); ?>" width="960" height="504" loading="<?php echo $eager ? 'eager' : 'lazy'; ?>" decoding="async"></div>
<?php endif; ?>
        <div class="blog-card__body">
          <span class="blog-card__category"><?php echo esc($post['category']); ?></span>
          <h3 class="blog-card__title"><?php echo esc($post['title']); ?></h3>
          <p class="blog-card__excerpt"><?php echo esc($post['excerpt']); ?></p>
          <span class="blog-card__meta"><time datetime="<?php echo esc($post['dateISO']); ?>"><?php echo esc($post['date']); ?></time> &middot; <?php echo esc($post['readtime']); ?></span>
          <span class="blog-card__cta">Read Article <span aria-hidden="true">&rarr;</span><span class="sr-only">: <?php echo esc($post['title']); ?></span></span>
        </div>
      </a>
<?php
    }
}
