<?php
/**
 * Single Bibliothèque Média Template
 * Displays a single media item.
 *
 * @package DotCore
 */

get_header();

if (have_posts()):
    while (have_posts()):
        the_post();

        // Get custom fields
        $media_type_terms = get_the_terms(get_the_ID(), 'media_category');
        $media_type_names = $media_type_terms ? wp_list_pluck($media_type_terms, 'name') : [];
        $subtitle = get_field('subtitle');
        $location = get_field('location');
        $date = get_field('date');
        $display_date = dot_format_time_string(is_string($date) ? $date : '');
        $description = get_field('description');
        $media_file = get_field('media_file');
        $media_url = $media_file ? $media_file['url'] : '';
        $media_caption = get_field('caption');
        $lien_suivant = get_field('lien_suivant');
        $lien_precedent = get_field('lien_precedent');
        ?>

        <div class="t-media-single">
            <div class="t-media-single-header__buttons-container">
                <div class="l-container">
                    <div class="t-media-single-header__nav-links">

                        <div class="t-media-single-header__back-container">
                            <a href="/bibliotheque-media/"
                                class="c-button c-button--m c-button--a c-button--green c-button-previous">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                    <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                                    <path class="c-button__arrow"
                                        d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                                </svg>
                                <span>Retour à la bibliothèque</span>
                            </a>
                        </div>
                        <div class="t-media-single-header__next-prev-container">
                            <?php if ($lien_precedent): ?>
                                <a href="<?= esc_url($lien_precedent) ?>"
                                    class="c-button c-button--m c-button--a c-button--white c-button-previous">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                                        <path class="c-button__arrow"
                                            d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                                    </svg>
                                    <span>Précédent</span>
                                </a>
                            <?php endif; ?>
                            <?php if ($lien_suivant): ?>
                                <a href="<?= esc_url($lien_suivant) ?>" class="c-button c-button--m c-button--a c-button--white">
                                    <span>Suivant</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121" />
                                        <path class="c-button__arrow"
                                            d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php dot_the_layout_part('yellow-background') ?>
        </div>

        <section class="t-media-single-header c-yellow-background-brother">
            <div class="l-container">
                <div class="t-media-single-header__column">
                    <div class="t-media-single-slider" id="t-media-single-slider">
                        <div class="t-media-single-slider__slider">
                            <?php
                            $i = 0;
                            $slides = [];

                            if (have_rows('slider')) {
                                while (have_rows('slider')) {
                                    the_row();
                                    $image = get_sub_field('image');
                                    if ($image) {
                                        $slides[] = [
                                            'type' => 'slider',
                                            'image_id' => $image['ID'],
                                            'image_html' => wp_get_attachment_image($image['ID'], 'full', false, [
                                                'class' => 'f-media-single-slider__img',
                                                'alt' => esc_attr($image['alt'] ?? ''),
                                            ]),
                                        ];
                                    }
                                }
                            } elseif (has_post_thumbnail()) {
                                $slides[] = [
                                    'type' => 'thumbnail',
                                    'image_id' => get_post_thumbnail_id(),
                                    'image_html' => get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'f-media-single-slider__img']),
                                ];
                            }
                            foreach ($slides as $slide) {
                                $i++;
                                ?>
                                <div class="t-media-single-slider__slide">
                                    <?= $slide['image_html'] ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if ($i > 1): ?>
                            <div class="t-media-single-slider__index c-slider__index">
                                <span class="c-slider__prev btn-prev"><img
                                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg" /></span>
                                <div class="c-slider__index-mid">
                                    <span class="current-index">1</span> / <span class="total-slides">0</span>
                                </div>
                                <span class="c-slider__next btn-next"><img
                                        src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg" /></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="t-media-single-header__column">

                    <div class="t-media-single-header__meta">
                        <?php if ($date || $location): ?>
                            <div class="f-card__date f-card__date--black">
                                <?php if ($date): ?>
                                    <span><?= esc_html($display_date ?: $date) ?></span>
                                <?php endif; ?>
                                <?php if ($location): ?>
                                    <div class="f-card__location">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13" fill="none">
                                            <path
                                                d="M9 5.13105C9 7.02445 6.5625 10.3594 5.47917 11.7579C5.22917 12.0807 4.75 12.0807 4.5 11.7579C3.41667 10.3594 1 7.02445 1 5.13105C1 2.85037 2.77083 1 5 1C7.20833 1 9 2.85037 9 5.13105Z"
                                                fill="white" fill-opacity="0.5" stroke="#181818" stroke-width="1.1" />
                                        </svg>
                                        <span class="f-card__location-name"><?= esc_html($location) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="f-card__tags f-card__tags--media">
                            <?php if (!empty($media_type_names)): ?>
                                <?php foreach ($media_type_names as $type_name): ?>
                                    <span class="f-card__tag"><?= esc_html($type_name) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h1 class="t-media-single-header__title">
                        <?php the_title(); ?>
                    </h1>
                    <?php if ($subtitle): ?>
                        <p class="t-media-single-header__subtitle"><?= esc_html($subtitle) ?></p>
                    <?php endif; ?>

                    <div class="t-media-single-header__descriptions">
                        <?php if ($description): ?>
                            <div class="t-media-single-header__description body-lg">
                                <?= wp_kses_post($description) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($media_url): ?>
                        <div class="t-media-single-header__media">
                            <a href="<?= esc_url($media_url) ?>" class="c-button c-button--lg c-button--black" target="_blank"
                                rel="noopener">
                                Télécharger le média
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ($media_caption): ?>
                        <div class="t-media-single-header__caption">
                            <?= esc_html($media_caption) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (have_rows('button')): ?>
                        <div class="t-media-single-header__button">
                            <?php while (have_rows('button')):
                                the_row(); ?>
                                <?php dot_the_layout_part('button'); ?>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php
        if (function_exists('dot_the_layouts')) {
            dot_the_layouts();
        }
        ?>
        </div>

        <?php
    endwhile;
endif;

get_footer();
