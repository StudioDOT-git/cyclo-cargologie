<?php

$images = get_sub_field('partners_logo');
?>

<div id="f-project-partners-section" class="f-project-partners-section">
    <div class="l-container">
        <div class="f-project-partners-section__tb">
            <div class="f-project-partners-section__headings">
                <h2 class="f-project-partners-section__title"><?= get_sub_field('title') ?></h2>
            </div>
            <div class="f-project-partners-section__content">

                <div class="f-project-partners-section__slider-wrapper">
                    <div class="f-project-partners-section__slider">
                        <?php foreach ($images as $image) : ?>
                            <div class="generic-gallery__item f-project-partners-section__slide">
                                <?= wp_get_attachment_image($image['logo']['ID'], 'full'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="f-project-partners-section__index c-slider__index">
                                    <span class="c-slider__prev btn-prev">
                                        <img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg"/>
                                    </span>
                        <div class="c-slider__index-mid">
                            <span class="current-index">1</span> / <span class="total-slides">0</span>
                        </div>
                        <span class="c-slider__next btn-next">
                            <img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg"/>
                        </span>
                    </div>
                </div>

                <div class="f-project-partners-section__paragraph">
                    <p><?= get_sub_field('paragraph') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
