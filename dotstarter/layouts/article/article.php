<?php
$post = get_post();

$enable_slider = false;
$is_excerpt = !empty(get_the_excerpt());


$slides_count = is_array(get_field('slides')) ? count(get_field('slides')) : null;

$categories = get_the_category($post->ID);
$date = ucwords(get_the_date('M Y', $post->ID));


?>

<div class="f-article">

    <!-- Notices -->

    <?php dot_the_layout_part('yellow-background') ?>
    <section class="f-article-header c-yellow-background-brother">
        <div class="l-container">
            <div class="f-article-header__column">
                <section class="f-article-slider c-slider slide-ttb" id="<?= uniqid() ?>">
                    <?php if ($enable_slider) : ?>
                        <div class="f-article-slider__slider">
                            <?php foreach (get_field('carousel_images') as $image) : ?>
                                <div class="f-article-slider__slide">
                                    <?= wp_get_attachment_image($image['ID'], 'full', false, ['class' => 'f-article-slider__image']) ?>
                                    <div class="f-article-slider__slide-caption">
                                        <?= $image['description'] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count(get_field('carousel_images')) > 1) : ?>
                            <div class="f-article-slider__index c-slider__index">
                                <span class="c-slider__prev btn-prev"><img
                                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg"/></span>
                                <div class="c-slider__index-mid">
                                    <span class="current-index">1</span> / <span class="total-slides">0</span>
                                </div>
                                <span class="c-slider__next btn-next"><img
                                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg"/></span>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="f-article-slider__slide">
                            <?php the_post_thumbnail("full") ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
            <div class="f-article-header__column">
                <div class="f-card__tags f-card__tags--post">
                    <div class="f-card__date f-card__date--black">
                        <span><?= $date ?></span>
                        <?php if (!empty(get_field('location'))): ?>
                            <div class="f-card__location">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13"
                                     fill="none">
                                    <path
                                        d="M9 5.13105C9 7.02445 6.5625 10.3594 5.47917 11.7579C5.22917 12.0807 4.75 12.0807 4.5 11.7579C3.41667 10.3594 1 7.02445 1 5.13105C1 2.85037 2.77083 1 5 1C7.20833 1 9 2.85037 9 5.13105Z"
                                        fill="white" fill-opacity="0.5" stroke="#181818" stroke-width="1.1"/>
                                </svg>
                                <span class="f-card__location-name"><?= the_field('location') ?></span>
                            </div>
                        <?php endif; ?>

                    </div>
                    <?php if ($categories[0]): ?>
                            <span class="f-card__tag"><?= $categories[0]->name ?></span>
                    <?php endif; ?>

                </div>

                <h1 class="f-article-header__title">
                    <?php the_title() ?>
                </h1>
                <?php if ($is_excerpt) : ?>
                    <div class="f-article-header__subtitle">
                        <?= the_excerpt() ?>
                    </div>
                <?php endif; ?>

                <div class="f-article-header__descriptions">
                    <?php if (get_field('content')) : ?>
                        <div class="f-article-header__description body-lg">
                            <?= get_sub_field('content') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (have_rows('button')) : ?>
                    <div class="f-article-header__button">
                        <?php while (have_rows('button')):
                            the_row() ?>
                            <?php dot_the_layout_part('button') ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>



</div>
