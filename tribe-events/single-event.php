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

$disciplines = get_the_terms(null, 'discipline');
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

    <section class="t-events-single-header">
        <div class="l-container">
            <div class="t-events-single-header__column">
                <section class="t-events-single-slider c-slider slide-ttb" id="<?php echo uniqid() ?>">
                    <?php if (get_field('carousel_images')) : ?>
                        <div class="t-events-single-slider__slider">
                            <?php foreach (get_field('carousel_images') as $image) : ?>
                                <div class="t-events-single-slider__slide">
                                    <div class="t-events-single-slider__slide-statuses">
                                        <?php foreach ($statuses as $s) :
                                            switch ($s) {
                                                case 'postponed':
                                                    $clr = 'blue-light';
                                                    $label = 'Reporté';
                                                    break;
                                                case 'full':
                                                    $clr = 'yellow';
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
                                <span class="c-slider__prev btn-prev"><img src="<?php echo DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg" /></span>
                                <div class="c-slider__index-mid">
                                    <span class="current-index">1</span> / <span class="total-slides">0</span>
                                </div>
                                <span class="c-slider__next btn-next"><img src="<?php echo DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg" /></span>
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
                <h1 class="t-events-single-header__title heading1">
                    <?php the_title() ?>
                </h1>
                <?php if (get_field('performer')) : ?>
                    <p class="t-events-single-header__performer">
                        <?php the_field('performer') ?>
                    </p>
                <?php endif; ?>

                <div class="t-events-single-header__tags ">
                    <?php if (is_array($categories)) : ?>
                        <?php foreach ($categories as $term) : ?>
                            <?php
                            $color = 'red-light';

                            switch ($term->slug) {
                                case 'pirouette-cacahuete':
                                    $color = 'green';
                                    break;
                                case 'pirouette-circaouette':
                                    $color = 'green';
                                    break;
                                case 'saison':
                                    $color = 'red-light';
                                    break;
                                case 'sortie-de-residence':
                                    $color = 'blue-light';
                                    break;
                                case 'festival':
                                    $color = 'yellow';
                                    break;
                                case 'residence':
                                    $color = 'blue';
                                    break;
                                case 'rencontre':
                                case 'scolaire':
                                    $color = 'purple';
                                    break;
                                default:
                                    $color = 'red-light';
                            }


                            ?>
                            <li class="c-tag c-tag--<?= $color ?>">
                                <?= $term->name ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (is_array($disciplines)) : ?>
                        <?php foreach ($disciplines as $term) : ?>
                            <div class="c-tag c-tag--yellow-light">
                                <?= $term->name ?>
                            </div>
                        <?php endforeach ?>
                    <?php endif; ?>
                </div>

                <?php if (have_rows('prices')) : ?>
                    <div class="t-events-single-header__prices">
                        <?php while (have_rows('prices')) :
                            the_row() ?>
                            <div class="t-events-single-header__price">
                                <?php the_sub_field('price') ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('dates')) : ?>
                    <div class="t-events-single-header__dates">
                        <?php while (have_rows('dates')) :
                            the_row() ?>
                            <div class="t-events-single-header__date">
                                <?php the_sub_field('date') ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <div class="t-events-single-header__meta">
                    <?php if (get_field('duration')) : ?>
                        <div class="t-events-single-header__duration">
                            <?= dot_get_icon('clock-red') ?>
                            <?php the_field('duration') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (get_field('location')) : ?>
                        <div class="t-events-single-header__location">
                            <?= dot_get_icon('location-red') ?>
                            <?php if (get_field('location_url')) : ?>
                                <a href="<?php the_field('location_url') ?>" target="_blank"><?php the_field('location') ?></a>
                            <?php else : ?>
                                <?php the_field('location') ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (get_field('age')) : ?>
                        <div class="t-events-single-header__age">
                            <?= dot_get_icon('age') ?>
                            <?php the_field('age') ?>
                        </div>
                    <?php endif; ?>
                </div>

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

                <?php if (have_rows('buttons')) : ?>
                    <div class="t-events-single-header__buttons">
                        <?php while (have_rows('buttons')) :
                            the_row() ?>
                            <?php if (acf_maybe_get(get_sub_field('button'), 'link') && have_rows('button')) : ?>
                                <?php while (have_rows('button')) :
                                    the_row() ?>
                                    <?php dot_the_layout_part('button') ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php dot_the_layouts() ?>

</div>
