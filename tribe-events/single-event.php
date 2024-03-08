<?php

/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();

/**
 * Allows filtering of the single event template title classes.
 *
 * @param array $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 * @since 5.8.0
 *
 */
$title_classes = apply_filters('tribe_events_single_event_title_classes', ['tribe-events-single-event-title'], $event_id);
$title_classes = implode(' ', tribe_get_classes($title_classes));

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @param string $before HTML string to display before the title text.
 * @param string $event_id The ID of the displayed event.
 * @since 5.8.0
 *
 */
$before = apply_filters('tribe_events_single_event_title_html_before', '<h1 class="' . $title_classes . '">', $event_id);

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @param string $after HTML string to display after the title text.
 * @param string $event_id The ID of the displayed event.
 * @since 5.8.0
 *
 */
$after = apply_filters('tribe_events_single_event_title_html_after', '</h1>', $event_id);

/**
 * Allows filtering of the single event template title HTML.
 *
 * @param string $after HTML string to display. Return an empty string to not display the title.
 * @param string $event_id The ID of the displayed event.
 * @since 5.8.0
 *
 */
$title = apply_filters('tribe_events_single_event_title_html', the_title($before, $after, false), $event_id);

$tags = get_the_terms(null, 'post_tag');
$categories = get_the_terms(null, 'tribe_events_cat');

$slides_count = is_array(get_field('slides')) ? count(get_field('slides')) : null;

$statuses = get_field('status');
$statuses = !is_array($statuses) ? [$statuses] : $statuses;

$date = dot_get_formatted_event_date();

if (get_field('days') === false) {
    $date .= ' - ' . tribe_get_start_time() . ' à ' . tribe_get_end_time();
}
?>

<div class="t-events-single">

    <!-- Notices -->
    <?php tribe_the_notices() ?>

    <div class="t-events-single__background">
        <svg viewBox="0 0 219 340" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M95.1074 362H16.3201C10.9402 362 6.56488 357.667 6.46765 352.259V350.304C5.23608 274.134 -56.3743 212.918 -132.18 212.657C-137.592 212.657 -142 208.194 -142 202.753V123.684C-142 118.08 -137.365 113.552 -131.823 113.78C-3.61169 119.025 99.7096 222.92 104.928 351.77C105.154 357.374 100.649 362 95.075 362H95.1074Z"
                fill="#FFEC54"/>
            <path
                d="M31.1005 0H-132.135C-137.586 0 -142 4.42933 -142 9.90085V89.1077C-142 94.5792 -137.586 99.0085 -132.135 99.0085H110.187C115.639 99.0085 120.052 103.438 120.052 108.909V352.099C120.052 357.571 124.466 362 129.918 362H208.842C214.294 362 218.707 357.571 218.707 352.099V188.279C218.707 185.641 217.669 183.133 215.819 181.277L38.0777 2.89861C36.228 1.0422 33.7291 0 31.1005 0Z"
                fill="#FFEC54"/>
        </svg>
    </div>

    <section class="t-events-single-header">
        <div class="l-container">
            <div class="t-events-single-header__column">
                <section class="t-events-single-slider c-slider slide-ttb" id="<?= uniqid() ?>">
                    <?php if (get_field('carousel_images')) : ?>
                        <div class="t-events-single-slider__slider">
                            <?php foreach (get_field('carousel_images') as $image) : ?>
                                <div class="t-events-single-slider__slide">
                                    <div class="t-events-single-slider__slide-statuses">
                                        <?php foreach ($statuses as $s) :
                                            switch ($s) {
                                                case 'postponed':
                                                    $clr = 'red';
                                                    $label = 'Reporté';
                                                    break;
                                                case 'full':
                                                    $clr = 'red';
                                                    $label = 'Annulé';
                                                    break;
                                                case 'canceled':
                                                    $clr = 'red';
                                                    $label = 'Complet';
                                                    break;
                                            }
                                            ?>
                                            <div class="c-status-tag c-status-tag--<?= $clr ?>"><?= $label ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?= wp_get_attachment_image($image['ID'], 'full', false, ['class' => 't-events-single-slider__image']) ?>
                                    <div class="t-events-single-slider__slide-caption">
                                        <?= $image['description'] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count(get_field('carousel_images')) > 1) : ?>
                            <div class="t-events-single-slider__index c-slider__index">
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
                        <div class="t-events-single-slider__slide">
                            <?php the_post_thumbnail("full") ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
            <div class="t-events-single-header__column">
                <div class="f-card__tags">
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
                    <?php if ($categories): ?>
                        <?php foreach ($categories as $categorie): ?>
                            <span class="f-card__tag"><?= $categorie->name ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($tags): ?>
                        <?php foreach ($tags as $tag): ?>
                            <span class="f-card__tag"><?= $tag->name ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <h1 class="t-events-single-header__title">
                    <?php the_title() ?>
                </h1>

                <?php if (get_field('subtitle')) : ?>
                    <p class="t-events-single-header__subtitle">
                        <?php the_field('subtitle') ?>
                    </p>
                <?php endif; ?>

                <div class="t-events-single-header__descriptions">
                    <?php if (get_field('description')) : ?>
                        <div class="t-events-single-header__description body-lg">
                            <?php the_field('description') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (get_field('description_en')) : ?>
                        <div class="t-events-single-header__description-en body-lg">
                            <?php the_field('description_en') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (have_rows('button')) : ?>
                    <div class="t-events-single-header__button">
                        <?php while (have_rows('button')):
                            the_row() ?>
                            <?php dot_the_layout_part('button') ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php dot_the_layouts() ?>

</div>
