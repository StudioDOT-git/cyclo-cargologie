<div class="f-testimonials l-layout" id="f-testimonials">
    <div class="l-container">
        <div class="f-testimonials__wrapper">
            <div class="l-layout__headings">
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
            <div class="f-testimonials__slider-wrapper">
                <ul class="f-testimonials__list f-testimonials__slider">

                    <?php while (have_rows('testimonials')):
                        the_row() ?>
                        <li class="f-testimonials__item f-testimonials__slide f-testimonials-slide">
                            <div class="f-testimonials__card">
                                <p class="f-testimonials__card-paragraph">
                                    <?= get_sub_field('message') ?>
                                </p>

                                <div class="f-testimonials__author-wrapper">
                                    <div class="f-testimonials__card-image">
                                        <?php if (get_sub_field('image')): ?>
                                            <?= wp_get_attachment_image(get_sub_field('image'), 'medium') ?>
                                        <?php else: ?>
                                            <img src="<?= DOT_THEME_URI . '/assets/img/testimonial-default.png' ?>"
                                                alt="Vélo zoomé">
                                        <?php endif; ?>
                                    </div>
                                    <div class="f-testimonials__card-author-info">
                                        <p class="f-testimonials__card-author-name">
                                            <?= get_sub_field('author') ?>
                                        </p>
                                        <p class="f-testimonials__card-author-role">
                                            <?= get_sub_field('role') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="f-testimonials__index c-slider__index">
                <span class="c-slider__prev btn-prev"><img
                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg" /></span>
                <div class="c-slider__index-mid">
                    <span class="current-index">1</span> / <span class="total-slides">0</span>
                </div>
                <span class="c-slider__next btn-next"><img
                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg" /></span>
            </div>
            <div class="f-testimonials__button-container">
                <?php while (have_rows('button')):
                    the_row() ?>
                    <?php dot_the_layout_part('button') ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
