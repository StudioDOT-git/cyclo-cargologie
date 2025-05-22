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
        $statuses = get_field('status');
        $location = get_field('location');
        $description = get_field('description');
        $media_file = get_field('media_file'); // Example ACF field for file
        $media_url = $media_file ? $media_file['url'] : '';
        $media_caption = get_field('caption');

        // Status tag mapping
        $status_labels = [
            'postponed' => ['label' => 'Reporté', 'class' => 'red'],
            'canceled' => ['label' => 'Annulé', 'class' => 'red'],
            'full' => ['label' => 'Complet', 'class' => 'red'],
            'shortly' => ['label' => 'Prochainement', 'class' => 'purple'],
        ];
        ?>

        <div class="t-media-single">
            <?php dot_the_layout_part('yellow-background') ?>

            <section class="t-media-single-header c-yellow-background-brother">
                <div class="l-container">
                    <div class="t-media-single-header__column">
                        <span class="t-media-single__slide-statuses">
                            <?php if (!empty($statuses) && is_array($statuses)): ?>
                                <?php foreach ($statuses as $status): ?>
                                    <?php if (isset($status_labels[$status])): ?>
                                        <div class="c-status-tag c-status-tag--<?= esc_attr($status_labels[$status]['class']) ?>">
                                            <?= esc_html($status_labels[$status]['label']) ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </span>
                        <div class="t-media-single-slider__slide">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail("full") ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="t-media-single-header__column">
                        <div class="f-card__tags f-card__tags--media">
                            <?php if (!empty($media_type_names)): ?>
                                <?php foreach ($media_type_names as $type_name): ?>
                                    <span class="f-card__tag"><?= esc_html($type_name) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <h1 class="t-media-single-header__title">
                            <?php the_title(); ?>
                        </h1>
                        <?php if ($subtitle): ?>
                            <p class="t-media-single-header__subtitle"><?= esc_html($subtitle) ?></p>
                        <?php endif; ?>
                        <div class="t-media-single-header__meta">
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
