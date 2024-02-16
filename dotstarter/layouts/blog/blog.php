<?php

$posts_per_page = 8;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$query = new WP_Query(array(
    "post_type" => "post",
    "posts_per_page" => $posts_per_page,
    "paged" => $paged,
));

$categories = get_categories();
$tags = get_tags();
?>

<div class="c-blog-header layout">
    <div class="l-container">
        <div class="c-blog-header__content">
            <?php if (function_exists('yoast_breadcrumb')) :
                yoast_breadcrumb('<p class="c-breadcrumbs">', '</p>');
            endif; ?>
            <h1 class="c-blog-header__title heading1"><?php the_title() ?></h1>
            <?php if (get_field('introduction')) : ?>
                <p class="c-blog-header__introduction text-lg"><?php the_field('introduction') ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="f-blog" data-posts-per-page="<?= $posts_per_page ?>">
    <div class="l-container">
        <div class="c-filters-bar">
            <div class="c-filters-bar__header">
                <div class="c-filters-bar__title">Filtres</div>
                <div class="c-button c-button--sm c-button--sand reset-filters">Effacer les filtres</div>
            </div>
            <div class="c-filters-bar__filters">
                <div class="c-multi-filter c-multi-filter--green" data-taxonomy="categories">
                    <div class="c-multi-filter__toggle">
                        Catégories
                        <div class="c-multi-filter__toggle-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M5.91016 1L5.91016 10.85" stroke="#FFFFFF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
                                <path d="M10.8101 6.28906L5.91006 11.1891L1.00006 6.28906" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="c-multi-filter__options">
                        <?php foreach ($categories as $cat) : ?>
                            <div class="c-multi-filter__option" data-term-id="<?= $cat->term_id ?>" data-selected="false">
                                <?= $cat->name; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="c-multi-filter c-multi-filter--blue" data-taxonomy="tags">
                    <div class="c-multi-filter__toggle">
                        Thématiques
                        <div class="c-multi-filter__toggle-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M5.91016 1L5.91016 10.85" stroke="#FFFFFF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
                                <path d="M10.8101 6.28906L5.91006 11.1891L1.00006 6.28906" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="c-multi-filter__options">
                        <?php foreach ($tags as $tag) : ?>
                            <div class="c-multi-filter__option" data-term-id="<?= $tag->term_id ?>" data-selected="false">
                                <?= $tag->name; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="f-blog__posts">
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                    <?php dot_the_component('post-card') ?>
            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>
        </div>
        <div class="f-blog__pagination c-pagination" data-max-num-pages="<?= $query->max_num_pages ?>" data-paged="<?= $paged ?>">
            <div class="c-pagination__prev c-button c-button--sm c-button--sand" rel="prev">Page précédente</div>
            <div class="c-pagination__pages"></div>
            <div class="c-pagination__next c-button c-button--sm c-button--sand" rel="next">Page suivante</div>
        </div>
    </div>
</div>



<?php


$events = tribe_get_events(['posts_per_page' => 4, 'start_date' => 'now']);

?>

<div class="f-related-events">
    <div class="l-container">
        <div class="f-related-events__tb">
            <div class="f-related-events__title heading2">Découvrir les évènements</div>
            <div class="f-related-events__events" style="display: grid;grid-template-columns: repeat(4,1fr)">
                <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $event) : ?>
                        <?php setup_postdata($GLOBALS['post'] = $event); ?>
                        <?php dot_the_component('event-card') ?>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="f-related-events__cta">
                <a href="<?= get_post_type_archive_link('tribe_events') ?>" class="c-button c-button--lg c-button--black">Voir tous les évènements</a>
            </div>
        </div>
    </div>
</div>
