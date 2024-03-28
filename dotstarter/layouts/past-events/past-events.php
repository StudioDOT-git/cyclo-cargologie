<?php

$posts_per_page = 8;
$paged = $_GET['page'] ?? 1;
$args = $_GET;
$args['post_type'] = 'tribe_events';
$args['per_page'] = $posts_per_page;
$args['page'] = $paged;
$args['from_past'] = true;

$posts = AjaxPost::renderPosts($args);


?>
<div class="t-events-archive__header f-past-events__header">
    <div class="l-container l-container--md">
        <div class="t-events-archive__header-deco">
            <div class="c-deco">
                <img
                    src="<?= DOT_THEME_URI . '/assets/img/deco/evenement.svg' ?>"
                    alt="Décoration">
            </div>
        </div>
        <h2 class="t-events-archive__header-title">Évènements passés</h2>
    </div>
</div>
<?php dot_the_layout_part('yellow-background') ?>
<div id="past-events" class="f-past-events" data-posts-per-page="<?= $posts_per_page ?>">
    <div class="l-container l-container--md">
        <div class="f-past-events__content c-yellow-background-brother">
            <div class="l-container">
                <div class="f-past-events__results t-events-archive__events">
                    <?= $posts['render'] ?>
                </div>
                <?php if (!$posts['total_posts']): ?>
                    <div class="c-filters__no-results">
                        <div>Aucun article trouvé</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="f-past-events__pagination c-pagination" data-max-num-pages="<?= $posts["max_num_pages"] ?>"
             data-paged="<?= $paged ?>">
            <div class="c-pagination__prev" rel="prev">Précédent</div>
            <div class="c-pagination__pages"></div>
            <div class="c-pagination__next" rel="next">Suivant</div>
        </div>
    </div>
</div>


