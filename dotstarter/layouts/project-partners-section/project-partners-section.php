<?php
$images = get_sub_field('partners_logo');
?>

<div id="f-project-partners-section l-layout" class="f-project-partners-section">
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
        <div class="f-project-partners-section__content">
            <?php foreach ($images as $image): ?>
                <div class="f-project-partners-section__logo">
                    <?= wp_get_attachment_image($image['logo']['ID'], 'full'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
