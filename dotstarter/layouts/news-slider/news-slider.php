<div class="f-news-slider l-layout" id="f-news-slider">
    <div class="l-container">
        <div class="f-news-slider__wrapper">
            <div
                class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
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
            <div class="f-news-slider__slider-wrapper">
                <ul class="f-news-slider__list f-news-slider__slider">
                    <?php while (have_rows('news')):
                        the_row() ?>
                        <li class="f-news-slider__item f-news-slider__slide f-news-slider-slide">
                            <div class="f-news-slider__card">
                                <div class="f-news-slider__card-image">
                                    <?php if (get_sub_field('image')): ?>
                                        <?= wp_get_attachment_image(get_sub_field('image'), 'medium') ?>
                                    <?php else: ?>
                                        <img src="<?= DOT_THEME_URI . '/assets/img/testimonial-default.png' ?>"
                                            alt="Vélo zoomé">
                                    <?php endif; ?>
                                </div>
                                <div class="f-news-slider__card-container">
                                    <?php if (get_sub_field('titre')): ?>
                                        <h3 class="f-news-slider__card-title heading6"><?= get_sub_field('titre') ?></h3>
                                    <?php endif; ?>
                                    <p class="f-news-slider__card-paragraph">
                                        <?= get_sub_field('message') ?>
                                    </p>
                                    <?php if (have_rows('button')): ?>
                                        <div class="f-news-slider__card-button">
                                            <?php while (have_rows('button')):
                                                the_row() ?>
                                                <?php dot_the_layout_part('button') ?>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="f-news-slider__index c-slider__index">
                <span class="c-slider__prev btn-prev"><img
                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg" /></span>
                <div class="c-slider__index-mid">
                    <span class="current-index">1</span> / <span class="total-slides">0</span>
                </div>
                <span class="c-slider__next btn-next"><img
                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg" /></span>
            </div>
            <div class="f-news-slider__button-container">
                <?php while (have_rows('button')):
                    the_row() ?>
                    <?php dot_the_layout_part('button') ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>