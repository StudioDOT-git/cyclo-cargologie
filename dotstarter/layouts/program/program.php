<?php

$stiker = get_row('sticker');
$isStickerActive = $stiker['sticker']['is_deco_active'];
?>

<div class="f-program l-layout" id="f-program">
    <div class="l-container">
        <div class="l-layout__headings <?php if ($isStickerActive): ?>l-layout__headings--with-deco<?php endif; ?>">
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
    </div>
    <div class="f-program__wrapper">
        <?php $i = 0; ?>
        <?php while (have_rows('sections')):
            the_row() ?>
            <?php $i++; ?>
            <div class="f-program__section">
                <div class="l-container">
                    <div class="f-program__section-container">
                        <div class="f-program__section-image" data-id="#<?= $i ?>">
                            <div class="f-program__image">
                                <?= wp_get_attachment_image(get_sub_field('image'), 'large') ?>
                            </div>
                            <?php if (have_rows('sticker')): ?>
                                <?php while (have_rows('sticker')):
                                    the_row() ?>
                                    <?php dot_the_layout_part('deco') ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="f-program__section-text">
                            <h3 class="f-program__section-title heading3">
                                <?php the_sub_field('title') ?>
                            </h3>
                            <p class="f-program__section-description body-md">
                                <?= get_sub_field('description') ?>
                            </p>
                            <?php if (have_rows('button')): ?>
                                <div class="f-program__cta-wrapper">
                                    <?php while (have_rows('button')):
                                        the_row() ?>
                                        <?php dot_the_layout_part('button') ?>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
