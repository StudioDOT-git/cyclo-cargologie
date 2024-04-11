<div class="f-cards-slide f-cards-slider l-layoutr" id="f-cards-slider">

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
            <?php the_sub_field('description') ?>
            </div>
        </div>
        <div class="f-cards-slider__wrapper f-cards-slider__slider">
            <?php $i = 0; ?>
            <?php while (have_rows('sections')):
                the_row() ?>
                <?php $i++; ?>
                <div class="f-cards-slider__section">
                    <div class="f-cards-slider__section-container">
                        <div class="f-cards-slider__section-image" data-id="#<?= $i ?>">
                            <div class="f-cards-slider__image">
                                <?= wp_get_attachment_image(get_sub_field('image'), 'large') ?>
                            </div>
                            <?php if (have_rows('sticker')): ?>
                                <?php while (have_rows('sticker')):
                                    the_row() ?>
                                    <?php dot_the_layout_part('deco') ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="f-cards-slider__section-text">
                            <h3 class="f-cards-slider__section-title heading5">
                                <?php the_sub_field('title') ?>
                            </h3>
                            <ul class="f-cards-slider__list">
                                <?php $j = 0; ?>
                                <?php while (have_rows('list')):
                                    the_row() ?>
                                    <?php $j++; ?>
                                    <li class="f-cards-slider__list-element">
                                        <?= get_sub_field('element') ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="f-cards-slider__index c-slider__index">
            <span class="c-slider__prev btn-prev">
                <img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left--white.svg" />
            </span>
            <div class="c-slider__index-mid">
                <span class="current-index">1</span> / <span class="total-slides">0</span>
            </div>
            <span class="c-slider__next btn-next">
                <img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right--white.svg" />
            </span>
        </div>
    </div>
</div>
