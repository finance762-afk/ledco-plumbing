<?php
/**
 * includes/logo.php — logo analysis for head.php / header.php / footer.php (require_once; defines $logo* vars).
 *
 * No client logo has been supplied yet (build-plan assets.logo is null), so the site falls back to the text
 * logo (inline-SVG monogram + name). The moment a file named logo-mark*.{png,svg,webp} or logo.{svg,png,webp}
 * lands in /assets/images/, this picks it up (newest logo-mark version first), measures it, and sizes it by
 * aspect ratio per the LARGE-LOGO STANDARD: wordmark >3:1 = 120px, combination 1.5-3:1 = 96px, square = 88px
 * tall desktop (72px mobile). The header bar grows to fit via --nav-height (emitted by head.php).
 * Per CLAUDE.md: knock a JPEG's opaque field out to transparency first, never overwrite an image in place
 * (derived assets carry a version suffix: logo-mark-v1.png).
 */
if (!isset($logoImage)) {
    $logoImage = '';
    $logoW = $logoH = 0;
    $logoClass = '';
    $logoRenderH = 0;
    $logoNavHeight = 84;
    $logoNavHeightMobile = 84;

    $logoDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/assets/images/';
    $logoFiles = glob($logoDir . 'logo-mark*.{png,svg,webp}', GLOB_BRACE) ?: [];
    natsort($logoFiles);
    $logoFiles = array_reverse(array_values($logoFiles));
    foreach ((glob($logoDir . 'logo.{svg,png,webp}', GLOB_BRACE) ?: []) as $logoFallback) $logoFiles[] = $logoFallback;

    foreach ($logoFiles as $logoFile) {
        $logoDims = null;
        if (substr($logoFile, -4) === '.svg') {
            $logoSvg = (string) @file_get_contents($logoFile);
            if (preg_match('/viewBox="[\d.\-]+[ ,]+[\d.\-]+[ ,]+([\d.]+)[ ,]+([\d.]+)"/', $logoSvg, $logoM)) {
                $logoDims = [(float) $logoM[1], (float) $logoM[2]];
            } elseif (preg_match('/\bwidth="([\d.]+)"/', $logoSvg, $logoMw) && preg_match('/\bheight="([\d.]+)"/', $logoSvg, $logoMh)) {
                $logoDims = [(float) $logoMw[1], (float) $logoMh[1]];
            }
        } else {
            $logoInfo = @getimagesize($logoFile);
            if ($logoInfo) $logoDims = [(float) $logoInfo[0], (float) $logoInfo[1]];
        }
        if (!$logoDims || $logoDims[0] <= 0 || $logoDims[1] <= 0) continue;

        $logoRatio = $logoDims[0] / $logoDims[1];
        if ($logoRatio > 3)        { $logoClass = 'logo--wordmark'; $logoRenderH = 120; }
        elseif ($logoRatio >= 1.5) { $logoClass = '';               $logoRenderH = 96; }
        else                       { $logoClass = 'logo--square';   $logoRenderH = 88; }
        $logoH = $logoRenderH;
        $logoW = (int) round($logoRenderH * $logoRatio);
        $logoImage = '/assets/images/' . basename($logoFile);
        $logoNavHeight = $logoRenderH + 24;      // 144 / 120 / 112 desktop
        $logoNavHeightMobile = 88;               // 72px logo + 16
        break;
    }
}
