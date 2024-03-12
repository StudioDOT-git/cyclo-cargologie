<?php
/*
Template Name: Évènements
*/

get_header();

dot_the_layouts();

$posts_per_page = 8;
$paged = $_GET['paged'] ?? 1;
$args = $_GET;
$args['post_type'] = 'tribe_events';
$args['per_page'] = $posts_per_page;
$args['post_status'] = 'publish';

$posts = AjaxPost::renderPosts($args);

?>
<div class="t-events-archive__background">
    <svg viewBox="0 0 219 340" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M95.1074 362H16.3201C10.9402 362 6.56488 357.667 6.46765 352.259V350.304C5.23608 274.134 -56.3743 212.918 -132.18 212.657C-137.592 212.657 -142 208.194 -142 202.753V123.684C-142 118.08 -137.365 113.552 -131.823 113.78C-3.61169 119.025 99.7096 222.92 104.928 351.77C105.154 357.374 100.649 362 95.075 362H95.1074Z"
            fill="#FFEC54"/>
        <path
            d="M31.1005 0H-132.135C-137.586 0 -142 4.42933 -142 9.90085V89.1077C-142 94.5792 -137.586 99.0085 -132.135 99.0085H110.187C115.639 99.0085 120.052 103.438 120.052 108.909V352.099C120.052 357.571 124.466 362 129.918 362H208.842C214.294 362 218.707 357.571 218.707 352.099V188.279C218.707 185.641 217.669 183.133 215.819 181.277L38.0777 2.89861C36.228 1.0422 33.7291 0 31.1005 0Z"
            fill="#FFEC54"/>
    </svg>
</div>

<div id="events-archive" class="t-events-archive" data-posts-per-page="<?= $posts_per_page ?>">
    <div class="l-container l-container--md">
        <div class="t-events-archive__filters-bar">
            <?php dot_the_component('events-filters-bar') ?>
        </div>

        <div class="t-events-archive__events">
            <?= $posts['render'] ?>
            <?php if (!$posts['total_posts']): ?>
                <div class="f-blog__no-results">
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
    <div class="l-container">
        <div class="f-related-posts__tb">
            <div class="f-related-posts__title">
                <h2 class="heading2">Nos ressources</h2>
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
</div>

<?php get_footer(); ?>
