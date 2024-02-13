<div class="f-testimonials" id="f-testimonials">
    <div class="l-container">
        <div class="f-testimonials__tb">
            <div class="f-testimonials__wrapper">
                <div class="f-testimonials__headings">
                    <h6 class="f-testimonials__subtitle"> <?= get_sub_field('subtitle') ?> </h6>
                    <h2 class="f-testimonials__title"><?= get_sub_field('title') ?></h2>
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
                                    <?php if (get_sub_field('image')) : ?>
                                    <?= wp_get_attachment_image(get_sub_field('image'), 'medium') ?>
                                    <?php else: ?>
                                        <img src="<?= DOT_THEME_URI . '/assets/img/testimonial-default.png'?>" alt="Vélo zoomé">
                                    <?php endif; ?>
                                </div>
                                <div class="f-testimonials__card-author-info">
                                    <p class="f-testimonials__card-author-name"><?= get_sub_field('author') ?></p>
                                    <p class="f-testimonials__card-author-role"><?= get_sub_field('role') ?></p>
                                </div>
                            </div>

                        </div>

                    </li>

                    <?php endwhile; ?>
                    </ul>
                </div>
                <div class="f-testimonial__index c-slider__index">
                    <span class="c-slider__prev btn-prev"><img src="<?php echo DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg" /></span>
                    <div class="c-slider__index-mid">
                        <span class="current-index">1</span> / <span class="total-slides">0</span>
                    </div>
                    <span class="c-slider__next btn-next"><img src="<?php echo DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg" /></span>
                </div>
            </div>
        </div>
    </div>
</div>
