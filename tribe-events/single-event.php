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
$formats = get_the_terms($event_id, 'format');
$categories = get_the_terms(null, 'tribe_events_cat');

$enable_slider = false;


$slides_count = is_array(get_field('slides')) ? count(get_field('slides')) : null;

$statuses = get_field('status');
//better_var_dump($statuses,true);

// $statuses = !is_array($statuses) ? [$statuses] : $statuses;

$date = dot_get_formatted_event_date();

if (get_field('days') === false) {
    $date .= ' - ' . tribe_get_start_time() . ' à ' . tribe_get_end_time();
}
?>

<div class="t-events-single">
    <!-- Notices -->
    <?php tribe_the_notices() ?>

    <?php dot_the_layout_part('yellow-background') ?>

    <section class="t-events-single-header c-yellow-background-brother">
        <div class="l-container">
            <div class="t-events-single-header__column">
                <section class="t-events-single-slider c-slider slide-ttb" id="<?= uniqid() ?>">
                    <?php if ($enable_slider): ?>
                        <div class="t-events-single-slider__slider">
                            <?php foreach (get_field('carousel_images') as $image): ?>
                                <div class="t-events-single-slider__slide">
                                    <div class="t-events-single-slider__slide-statuses">
                                        <?php foreach ($statuses as $s):
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
                                                case 'shortly':
                                                    $clr = 'purple';
                                                    $label = 'Prochainement';
                                                    break;
                                                default:
                                                    $clr = '';
                                                    $label = '';
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
                        <?php if (count(get_field('carousel_images')) > 1): ?>
                            <div class="t-events-single-slider__index c-slider__index">
                                <span class="c-slider__prev btn-prev">
                                    <img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg" /></span>
                                <div class="c-slider__index-mid">
                                    <span class="current-index">1</span> / <span class="total-slides">0</span>
                                </div>
                                <span class="c-slider__next btn-next">
                                    <img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg" /></span>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="t-events-single__slide-statuses">
                            <?php
                            $event_start_date_for_comparison = tribe_get_start_date(null, false, 'Y-m-d');
                            $event_start_timestamp = strtotime($event_start_date_for_comparison);

                            $today_date = date('Y-m-d');
                            $today_timestamp = strtotime($today_date);

                            if ($event_start_timestamp < $today_timestamp): ?>
                                <div class="c-status-tag c-status-tag--red">Évènement passé</div>
                            <?php else: ?>
                                <?php if (in_array('full', $statuses)): ?>
                                    <div class="c-status-tag c-status-tag--red">Complet</div>
                                <?php endif; ?>
                                <?php if (in_array('canceled', $statuses)): ?>
                                    <div class="c-status-tag c-status-tag--red">Annulé</div>
                                <?php endif; ?>
                                <?php if (in_array('postponed', $statuses)): ?>
                                    <div class="c-status-tag c-status-tag--red">Reporté</div>
                                <?php endif; ?>
                                <?php if (in_array('shortly', $statuses)): ?>
                                    <div class="c-status-tag c-status-tag--purple">Prochainement</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </span>
                        <div class="t-events-single-slider__slide">
                            <?php the_post_thumbnail("full") ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
            <div class="t-events-single-header__column">
                <div class="f-card__tags f-card__tags--event">
                    <div class="f-card__date f-card__date--black">
                        <span><?= $date ?></span>
                        <?php if (!empty(get_field('location'))): ?>
                            <div class="f-card__location">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13"
                                    fill="none">
                                    <path
                                        d="M9 5.13105C9 7.02445 6.5625 10.3594 5.47917 11.7579C5.22917 12.0807 4.75 12.0807 4.5 11.7579C3.41667 10.3594 1 7.02445 1 5.13105C1 2.85037 2.77083 1 5 1C7.20833 1 9 2.85037 9 5.13105Z"
                                        fill="white" fill-opacity="0.5" stroke="#181818" stroke-width="1.1" />
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
                    <?php if ($formats): ?>
                        <?php foreach ($formats as $format): ?>
                            <span class="f-card__tag"><?= $format->name ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <h1 class="t-events-single-header__title">
                    <?php the_title() ?>
                </h1>
                <?php if (get_field('subtitle')): ?>
                    <p class="t-events-single-header__subtitle">
                        <?php the_field('subtitle') ?>
                    </p>
                <?php endif; ?>
                <div class="t-events-single-header__descriptions">
                    <?php if (get_field('description')): ?>
                        <div class="t-events-single-header__description body-lg">
                            <?php the_field('description') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (get_field('description_en')): ?>
                        <div class="t-events-single-header__description-en body-lg">
                            <?php the_field('description_en') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (have_rows('button')): ?>
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

    <section class="t-events-single-cta">
        <a href="<?php the_field('events_page', 'option') ?>" title="Découvrir les évènements"
            class="c-button c-button--lg c-button--black">
            <span>Voir tous les événements</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                <path class="c-button__arrow"
                    d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
            </svg>
        </a>
    </section>
    <?php dot_the_layouts() ?>
</div>
