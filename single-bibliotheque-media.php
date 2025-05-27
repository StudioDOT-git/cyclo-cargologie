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
        $date = get_field('date'); // NEW: get the date field
        $description = get_field('description');
        $media_file = get_field('media_file'); // Example ACF field for file
        $media_url = $media_file ? $media_file['url'] : '';
        $media_caption = get_field('caption');
        $lien_suivant = get_field('lien_suivant'); // NEW: get next link
        $lien_precedent = get_field('lien_precedent'); // NEW: get prev link
        ?>

        <div class="t-media-single">
            <?php dot_the_layout_part('yellow-background') ?>

            <section class="t-media-single-header c-yellow-background-brother">
                <div class="l-container">
                    <div class="t-media-single-header__column">
                        <div class="t-media-single-slider__slide">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail("full") ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="t-media-single-header__column">

                        <div class="t-media-single-header__meta">
                            <?php if ($date || $location): ?>
                                <div class="f-card__date f-card__date--black">
                                    <?php if ($date): ?>
                                        <span><?= esc_html($date) ?></span>
                                    <?php endif; ?>
                                    <?php if ($location): ?>
                                        <div class="f-card__location">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13"
                                                fill="none">
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

                        <!-- NEW: lien_precedent and lien_suivant -->
                        <div class="t-media-single-header__nav-links">
                            <?php if ($lien_precedent): ?>
                                <a href="<?= esc_url($lien_precedent) ?>" class="c-button c-button--sm c-button--gray">
                                    ← Précédent
                                </a>
                            <?php endif; ?>
                            <?php if ($lien_suivant): ?>
                                <a href="<?= esc_url($lien_suivant) ?>" class="c-button c-button--sm c-button--gray">
                                    Suivant →
                                </a>
                            <?php endif; ?>
                        </div>
                        <!-- END NEW -->
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
