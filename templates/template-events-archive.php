<?php
/*
Template Name: Évènements
*/

get_header();

dot_the_layouts();

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


<?php
$posts = get_posts(['numberposts' => 2]);

?>
<div class="f-related-posts">
    <div class="l-container l-container--md">
        <div class="f-related-posts__tb">
            <div class="f-related-posts__header">
                <div class="f-related-posts__header-deco">
                    <div class="c-deco">
                        <img
                            src="<?= DOT_THEME_URI . '/assets/img/deco/document-et-guide.svg' ?>"
                            alt="Décoration">
                    </div>
                </div>
                <h2 class="f-related-posts__header-title">Nos ressources</h2>
            </div>
            <div class="f-related-posts__posts">
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $post) : ?>
                        <?php setup_postdata($GLOBALS['post'] = $post); ?>
                        <?php dot_the_component('card') ?>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="f-related-posts__cta">
                <a href="<?= get_post_type_archive_link('post') ?>" class="c-button c-button--lg c-button--black">
                    <span>voir tous les contenus & Ressources</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61 61" fill="none">
                        <circle class="c-button__circle" cx="30.2121" cy="30.2121" r="30.2121"/>
                        <path class="c-button__arrow"
                              d="M38.5789 30.5168L38.1689 30.1068L35.0589 26.9968L32.5689 24.5068H30.0789V24.8468L35.1989 29.9668H23.1089C22.9789 29.9668 22.8789 30.0668 22.8789 30.1968V31.7368C22.8789 31.8668 22.9789 31.9668 23.1089 31.9668H35.1889L30.0789 37.0768V37.4168H32.5689L37.6089 32.3768L38.5789 31.4068V30.5168Z"/>
                    </svg>
                </a>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
