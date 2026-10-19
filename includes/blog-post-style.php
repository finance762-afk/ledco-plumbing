<?php
/** includes/blog-post-style.php — page composition for /blog/{slug}/ posts (layout, TOC, sidebar, related blocks). Tokens only. */
?>
<style>
/* ============================================================================
   blog post composition (minimal-tech). The .blog-post__* base classes live in framework.css.
   ============================================================================ */
.bp-page h1, .bp-page h2, .bp-page h3 { text-wrap: balance; }
.bp-page p, .bp-page li { text-wrap: pretty; }

.bp-hero { background: linear-gradient(155deg, var(--color-dark) 0%, var(--color-dark-alt) 58%, var(--color-primary-deep) 100%); }
.bp-hero::before { content: ""; position: absolute; inset: 0 0 0 60%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side at 70% 40%, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 75%); }
.bp-hero .grain { opacity: .3; }
.bp-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); align-items: center; }
.bp-hero .breadcrumb li { display: flex; align-items: center; min-height: var(--space-10); }
.bp-hero .breadcrumb a:hover, .bp-hero .breadcrumb [aria-current] { color: var(--color-white); }
.bp-hero .blog-post__header { display: grid; gap: var(--space-sm); max-width: 52rem; }
.bp-hero .hero-title { max-width: 26ch; }
.bp-hero .blog-post__meta { color: color-mix(in srgb, var(--color-white) 72%, transparent); font-size: var(--fs-small); }
.bp-hero .blog-post__meta a { color: var(--color-accent-bright); }
.bp-badge { justify-self: start; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-white); background: var(--color-accent-dark); padding: var(--space-1) var(--space-sm); border-radius: var(--radius-sm); }

.bp-body { background: var(--color-paper); padding-block: var(--space-2xl); }
.bp-layout { display: grid; grid-template-columns: minmax(0, 1fr) minmax(16rem, 20rem); gap: clamp(var(--space-xl), 5vw, var(--space-3xl)); align-items: start; }
.bp-layout > aside { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); display: grid; gap: var(--space-md); }
.bp-toc, .bp-side-cta { border-radius: var(--radius-lg); padding: var(--space-lg); border: 1px solid var(--color-line); }
.bp-toc { background: var(--color-surface); }
.bp-toc h2, .bp-side-cta h2 { font-size: var(--fs-h3); margin: 0 0 var(--space-sm); }
.bp-toc ol { margin: 0; padding-left: var(--space-lg); display: grid; gap: var(--space-2); font-size: var(--fs-small); }
.bp-toc a { color: var(--color-primary); }
.bp-toc a:hover { color: var(--color-accent-dark); text-decoration: underline; }
.bp-side-cta { background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-primary-deep) 130%); color: var(--color-white); border-color: transparent; box-shadow: var(--shadow); }
.bp-side-cta h2 { color: var(--color-white); }
.bp-side-cta p { margin: 0 0 var(--space-md); font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.bp-side-cta .btn { width: 100%; justify-content: center; margin-bottom: var(--space-2); }
.bp-side-cta__hours { margin: var(--space-sm) 0 0; font-size: var(--font-size-xs); color: color-mix(in srgb, var(--color-white) 72%, transparent); }

.bp-article { background: var(--color-surface); border-radius: var(--radius-lg); padding: clamp(var(--space-lg), 4vw, var(--space-2xl)); border: 1px solid var(--color-line); }
.bp-article .blog-post__featured-image { margin-top: 0; }
.bp-article .blog-post__featured-image img { width: 100%; height: auto; aspect-ratio: 960 / 504; object-fit: cover; }
.bp-article .blog-post__content { max-width: none; }
/* framework.css gives every <section> the page-level block padding; inside an article the sections are just text blocks */
.bp-article .blog-post__content > section { padding-block: 0; margin-top: var(--space-xl); scroll-margin-top: calc(var(--nav-height) + var(--space-lg)); }
.bp-article .blog-post__content > .answer-block + section, .bp-article .blog-post__content > section:first-child { margin-top: var(--space-lg); }
.bp-article .blog-post__content > section > h2:first-child { margin-top: 0; }
.bp-article .blog-post__content p, .bp-article .blog-post__content li { max-width: var(--measure); color: var(--color-ink-2); }
.bp-article .blog-post__content a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.bp-article .blog-post__content ul, .bp-article .blog-post__content ol { padding-left: var(--space-lg); display: grid; gap: var(--space-2); margin: var(--space-sm) 0; }
.bp-article .answer-block { max-width: var(--measure); }
.bp-figures { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm); margin: var(--space-lg) 0; padding: 0; list-style: none; }
.bp-figures li { display: grid; gap: var(--space-1); padding: var(--space-md); border-radius: var(--radius-lg); max-width: none; }
.bp-figures li:nth-child(1) { background: var(--color-card-tint-1); }
.bp-figures li:nth-child(2) { background: var(--color-card-tint-2); }
.bp-figures li:nth-child(3) { background: var(--color-card-tint-3); }
.bp-figures b { font-family: var(--font-heading); font-size: var(--fs-h2); color: var(--color-ink); line-height: 1.1; }
.bp-figures span { font-size: var(--fs-small); color: var(--color-ink-2); }
.bp-faq { margin-top: var(--space-2xl); }
.bp-faq .faq[open] { border-top-color: var(--color-accent); }
.bp-byline { margin-top: var(--space-xl); font-size: var(--fs-small); color: var(--color-muted); }

.bp-related { background: var(--color-paper-2); }
.bp-related .blog-post__related-services, .bp-related .blog-post__related-articles { margin-top: 0; }
.bp-related__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.4fr); gap: clamp(var(--space-xl), 5vw, var(--space-3xl)); align-items: start; }
.bp-related h2 { font-size: var(--fs-h3); margin: 0 0 var(--space-md); }
.bp-related__links { margin: 0; padding: 0; list-style: none; display: grid; gap: var(--space-2); }
.bp-related__links a { display: flex; justify-content: space-between; gap: var(--space-sm); padding: var(--space-sm) var(--space-md); border-radius: var(--radius); background: var(--color-surface); border: 1px solid var(--color-line); color: var(--color-ink); font-weight: 600; transition: border-color var(--transition), transform var(--transition); }
.bp-related__links a:hover { border-color: var(--color-accent); transform: translateX(var(--space-1)); }
.bp-related .blog-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }

@media (max-width: 1000px) {
  .bp-layout { grid-template-columns: 1fr; }
  .bp-layout > aside { position: static; order: -1; }
  .bp-related__grid { grid-template-columns: 1fr; }
}
@media (max-width: 560px) {
  .bp-figures { grid-template-columns: 1fr; }
  .bp-related .blog-grid { grid-template-columns: 1fr; }
}
</style>
