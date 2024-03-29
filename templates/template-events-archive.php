<?php
/*
Template Name: Évènements
*/

get_header();


$posts_per_page = 4;
$paged = $_GET['page'] ?? 1;
$args = $_GET;
$args['post_type'] = 'tribe_events';
$args['per_page'] = $posts_per_page;
$args['page'] = $paged;

$posts = AjaxPost::renderPosts($args);

?>

<div class="t-events-archive__header">
    <div class="l-container l-container--md">
        <div class="t-events-archive__header-deco">
            <div class="c-deco">
                <img
                    src="<?= DOT_THEME_URI . '/assets/img/deco/evenement.svg' ?>"
                    alt="Décoration">
            </div>
        </div>
        <h2 class="t-events-archive__header-title">Évènements</h2>
    </div>
</div>

<?php dot_the_layout_part('yellow-background') ?>
<div id="events-archive" class="t-events-archive c-yellow-background-brother"
     data-posts-per-page="<?= $posts_per_page ?>">
    <div class="l-container l-container--md">
        <div class="t-events-archive__filters-bar">
            <?php dot_the_component('events-filters-bar') ?>
        </div>

        <div class="t-events-archive__events">
            <?= $posts['render'] ?>
            <?php if (!$posts['total_posts']): ?>
                <div class="c-filters_no-results">
                    <div>Aucun article trouvé</div>
                </div>
            <?php endif; ?>
        </div>

        <div class="t-events-archive__pagination c-pagination" data-max-num-pages="<?= $posts['max_num_pages'] ?>"
             data-paged="<?= $paged ?>">
            <div class="c-pagination__prev" rel="prev">Précédent</div>
            <div class="c-pagination__pages"></div>
            <div class="c-pagination__next" rel="next">Suivant</div>
        </div>
    </div>
</div>


<?php dot_the_layouts(); ?>

<?php get_footer(); ?>
