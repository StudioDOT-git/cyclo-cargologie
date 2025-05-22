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
        $description = get_field('description');
        $description_en = get_field('description_en');
        $media_file = get_field('media_file'); // Example ACF field for file
        $media_url = $media_file ? $media_file['url'] : '';
        $media_caption = get_field('caption');
        ?>

        <div class="t-media-single">
            <section class="t-media-single-header">
                <div class="l-container">
                    <div class="t-media-single-header__column">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="t-media-single-header__thumbnail">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="t-media-single-header__column">
                        <div class="f-card__tags f-card__tags--media">
                            <?php if (!empty($media_type_names)): ?>
                                <?php foreach ($media_type_names as $type_name): ?>
                                    <span class="f-card__tag"><?= esc_html($type_name) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <h1 class="t-media-single-header__title">TESTMEDIASINGLE<?php the_title(); ?></h1>
                        <?php if ($subtitle): ?>
                            <p class="t-media-single-header__subtitle"><?= esc_html($subtitle) ?></p>
                        <?php endif; ?>
                        <div class="t-media-single-header__descriptions">
                            <?php if ($description): ?>
                                <div class="t-media-single-header__description body-lg">
                                    <?= wp_kses_post($description) ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($description_en): ?>
                                <div class="t-media-single-header__description-en body-lg">
                                    <?= wp_kses_post($description_en) ?>
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
                    </div>
                </div>
            </section>
            <section class="t-media-single-cta">
                <a href="<?= esc_url(get_post_type_archive_link('bibliotheque-media')) ?>"
                    title="Voir toute la bibliothèque média" class="c-button c-button--lg c-button--black">
                    <span>Voir toute la bibliothèque média</span>
                </a>
            </section>
        </div>

        <?php
    endwhile;
endif;

if (function_exists('dot_the_layouts')) {
    dot_the_layouts();
}

get_footer();
