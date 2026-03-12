<div class="f-pdf-embed l-layout">
    <div class="l-container">
        <div class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
            <div class="l-layout__deco-container">
                <?php if (have_rows('sticker')): ?>
                    <?php while (have_rows('sticker')):
                        the_row() ?>
                        <?php dot_the_layout_part('deco') ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="l-layout__titles">
                <h6 class="l-layout__subtitle">
                    <?= get_sub_field('subtitle') ?>
                </h6>
                <h2 class="l-layout__title">
                    <?= get_sub_field('title') ?>
                </h2>
            </div>
            <div class="l-layout__description body-md">
                <?= get_sub_field('description') ?>
            </div>
        </div>

        <div class="f-pdf-embed__iframe-container">
            <?php
            $pdf_file = get_sub_field('pdf_file');
            $pdf_url = '';
            $pdf_title = '';
            $pdf_id = null;

            if (is_array($pdf_file)) {
                $pdf_id = $pdf_file['ID'] ?? null;
                $pdf_title = $pdf_file['title'] ?? '';
            } elseif (is_numeric($pdf_file)) {
                $pdf_id = (int) $pdf_file;
            } elseif (is_string($pdf_file)) {
                $pdf_url = $pdf_file;
            }

            if ($pdf_id) {
                $pdf_url = wp_get_attachment_url($pdf_id) ?: '';
            }

            if (!$pdf_url && is_array($pdf_file)) {
                $pdf_url = $pdf_file['url'] ?? '';
            }

            if ($pdf_url) {
                $site_host = wp_parse_url(home_url(), PHP_URL_HOST);
                $file_host = wp_parse_url($pdf_url, PHP_URL_HOST);

                if ($site_host && $file_host && $site_host === $file_host) {
                    $pdf_url = set_url_scheme($pdf_url);
                }
            }

            $layout_title = get_sub_field('title');
            $iframe_title = $pdf_title ?: ($layout_title ?: 'Document PDF');
            ?>

            <?php if ($pdf_url): ?>
                <iframe src="<?= esc_url($pdf_url) ?>" title="<?= esc_attr($iframe_title) ?>" loading="lazy"></iframe>
            <?php endif; ?>
        </div>
    </div>
</div>
