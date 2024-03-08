<?php
/*
Template Name: Page de recherche
*/

get_header();

$args = [
    's' => $_GET['s'],
    'orderby' => 'post_type',
];

$query = new WP_Query($args);
$posts = $query->posts;

$posts_by_category = [];

$current_post_type = null;

foreach ($posts as $post) {
    if ($current_post_type !== $post->post_type) {
        $current_post_type = $post->post_type;
        $posts_by_category[$current_post_type]['posts'] = [];
        $posts_by_category[$current_post_type]['title'] = get_post_type_object($current_post_type)->label;
    }

    $posts_by_category[$current_post_type]['posts'][] = $post;
}
?>
<div id="search" class="t-search">
    <div class="t-search__header">
        <div class="l-container">
            <div class="t-search__header-title">
                <h2>Résultats de recherche pour : <span><?= htmlspecialchars($_GET['s']) ?></span></h2>
            </div>
            <div class="t-search__header-deco">
                <div class="c-deco">
                    <img
                        src="<?= DOT_THEME_URI . '/assets/img/deco/loupe.png' ?>"
                        alt="Décoration">
                </div>
            </div>
        </div>
    </div>
    <div class="t-search__background">
        <svg viewBox="0 0 219 340" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M95.1074 362H16.3201C10.9402 362 6.56488 357.667 6.46765 352.259V350.304C5.23608 274.134 -56.3743 212.918 -132.18 212.657C-137.592 212.657 -142 208.194 -142 202.753V123.684C-142 118.08 -137.365 113.552 -131.823 113.78C-3.61169 119.025 99.7096 222.92 104.928 351.77C105.154 357.374 100.649 362 95.075 362H95.1074Z" fill="#FFEC54"/>
            <path d="M31.1005 0H-132.135C-137.586 0 -142 4.42933 -142 9.90085V89.1077C-142 94.5792 -137.586 99.0085 -132.135 99.0085H110.187C115.639 99.0085 120.052 103.438 120.052 108.909V352.099C120.052 357.571 124.466 362 129.918 362H208.842C214.294 362 218.707 357.571 218.707 352.099V188.279C218.707 185.641 217.669 183.133 215.819 181.277L38.0777 2.89861C36.228 1.0422 33.7291 0 31.1005 0Z" fill="#FFEC54"/>
        </svg>
    </div>
    <div class="t-search__content">
        <div class="l-container">
            <div class="t-search__results">
                <?php if (!empty($posts_by_category)) : ?>
                    <?php foreach ($posts_by_category as $category) : ?>
                        <div class="t-search__category">
                            <h3><?= $category['title'] ?></h3>
                            <div class="t-search__posts">
                                <?php foreach ($category['posts'] as $post) : ?>
                                    <?php setup_postdata($GLOBALS['post'] = $post); ?>
                                    <?php dot_the_component('card') ?>
                                <?php endforeach; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
