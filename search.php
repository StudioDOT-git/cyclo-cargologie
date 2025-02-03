<?php
/*
Template Name: Page de recherche
*/

get_header();

$posts_per_page = 8;
$paged = $_GET['page'] ?? 1;
$args = $_GET;
$args['post_type'] = 'all';
$args['per_page'] = $posts_per_page;
$args['page'] = $paged;


$posts = AjaxPost::renderPosts($args);


?>
<div id="search" class="t-search" data-posts-per-page="<?= $posts_per_page ?>">
    <div class="t-search__header">
        <div class="l-container">
            <div class="t-search__header-deco">
                <div class="c-deco">
                    <img
                        src="<?= DOT_THEME_URI . '/assets/img/deco/recherche.svg' ?>"
                        alt="Décoration">
                </div>
            </div>
            <h2 class="t-search__header-title">Résultats de recherche pour :
                <span><?= htmlspecialchars($_GET['s']) ?></span></h2>
        </div>
    </div>
    <?php dot_the_layout_part('yellow-background') ?>
    <div class="t-search__content c-yellow-background-brother">
        <div class="l-container">
            <div class="t-search__results">
                <?= $posts['render'] ?>
            </div>
            <?php if (!$posts['total_posts']): ?>
                <div class="c-filters__no-results">
                    <div>Aucun article trouvé</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="t-search__pagination c-pagination" data-max-num-pages="<?= $posts["max_num_pages"] ?>"
         data-paged="<?= $paged ?>">
        <div class="c-pagination__prev" rel="prev">Précédent</div>
        <div class="c-pagination__pages"></div>
        <div class="c-pagination__next" rel="next">Suivant</div>
    </div>
</div>


<?php get_footer(); ?>
