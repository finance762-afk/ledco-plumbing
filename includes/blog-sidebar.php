<?php
/**
 * includes/blog-sidebar.php — TOC + estimate/phone CTA for a blog post. Set $bpToc = [['id' => 'anchor', 'label' => 'H2 text'], ...]
 * before including. The CTA opens #estimate-dialog (the post's one inline form is the mid-page .cta-band).
 * Posts are laid out in two halves around that band: the first half includes the full sidebar ($bpSidebarMode = 'full'),
 * the second half only the CTA ($bpSidebarMode = 'cta') so the TOC is not duplicated.
 */
$bpSidePhone = formatPhone($phone);
$bpSidebarMode = $bpSidebarMode ?? 'full';
?>
      <aside aria-label="<?php echo $bpSidebarMode === 'full' ? 'Article tools' : 'Contact Ledco Plumbing'; ?>">
<?php if ($bpSidebarMode === 'full'): ?>
        <nav class="bp-toc" aria-label="Table of contents">
          <h2>In this article</h2>
          <ol>
<?php foreach ((array) $bpToc as $bpTocItem): ?>
            <li><a href="#<?php echo esc($bpTocItem['id']); ?>"><?php echo esc($bpTocItem['label']); ?></a></li>
<?php endforeach; ?>
          </ol>
        </nav>
<?php endif; ?>
        <div class="bp-side-cta">
          <h2>Talk to Ledco Plumbing</h2>
          <p>Describe the problem and the office will tell you what the visit involves and the price before any work starts.</p>
          <a class="btn btn-accent" href="<?php echo esc(phoneHref($phone)); ?>"><?php icon('phone', 18); ?> Call <?php echo esc($bpSidePhone); ?></a>
          <?php echo estimateTrigger('btn btn-outline-white', 'Request an estimate'), "\n"; ?>
          <p class="bp-side-cta__hours">Open <?php echo esc($businessHours); ?> &middot; 316 E Oak Ave, Seminole</p>
        </div>
      </aside>
