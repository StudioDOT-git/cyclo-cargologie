<div class="f-slider-full-width" id="f-slider-full-width">
    <div class="l-container">
        <div class="f-slider-full-width__tb">
            <div class="f-slider-full-width__wrapper">
                <div class="f-slider-full-width__slider">
                    <?php $i = 0; ?>
                    <?php while (have_rows('images')):
                        the_row() ?>
                        <?php $i++; ?>

                        <div class="f-slider-full-width__item f-slider-full-width__slide f-slider-full-width-slide">
                            <?= wp_get_attachment_image(get_sub_field('image'), 'full') ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php if ($i > 1): ?>
                <div class="f-slider-full-width__index c-slider__index">
                    <span class="c-slider__prev btn-prev"><img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg" /></span>
                    <div class="c-slider__index-mid">
                        <span class="current-index">1</span> / <span class="total-slides">0</span>
                    </div>
                    <span class="c-slider__next btn-next"><img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg" /></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
