<?php
$images = get_sub_field('partners_logo');
?>

<div id="f-project-partners-section" class="f-project-partners-section">
    <div class="l-container">
        <div class="f-project-partners-section__headings">
            <?php if (have_rows('sticker')): ?>
                <?php while (have_rows('sticker')):
                    the_row() ?>
                    <?php dot_the_layout_part('deco') ?>
                <?php endwhile; ?>
            <?php endif; ?>
            <h2 class="f-project-partners-section__title heading2">
                <?= get_sub_field('title') ?>
            </h2>
        </div>
        <div class="f-project-partners-section__content">
            <?php foreach ($images as $image): ?>
                <div class="f-project-partners-section__logo">
                    <?= wp_get_attachment_image($image['logo']['ID'], 'full'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>