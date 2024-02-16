<?php
/*
Template Name: Évènements
*/

get_header();

dot_the_layouts();

?>
<div id="events-archive" class="t-events-archive">
    <div class="f-layout f-layout--has-border-top t-events-archive__header">
        <div class="l-container">
            <h2 class="t-events-archive__title heading2">
                Évènements
            </h2>
        </div>
    </div>
    <div class="t-events-archive__filters-bar">
        <?php dot_the_component('events-filters-bar') ?>
    </div>
    <div class="t-events-archive__months-navbar">
        <?php dot_the_component('months-navbar') ?>
    </div>
    <div class="t-events-archive__months">
    </div>
    <div id="events-end" class="t-events-archive__after">
        <div id="loader" class="t-events-archive__loader lds-dual-ring"></div>
    </div>
</div>


<?php


$posts = get_posts(['numberposts' => 2]);

?>
<div class="f-related-posts">
    <div class="l-container">
        <div class="f-related-posts__tb">
            <div class="f-related-posts__title">
                <h2 class="heading2">En attendant les prochains évènements, un peu de lecture</h2>
                <div class="f-related-posts__posts" style="display: grid;grid-template-columns: repeat(2,1fr)">
                    <?php if (!empty($posts)) : ?>
                        <?php foreach ($posts as $post) : ?>
                            <?php setup_postdata($GLOBALS['post'] = $post); ?>
                            <?php dot_the_component('post-card') ?>
                        <?php endforeach; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
                <div class="f-related-posts__cta">
                    <a href="<?= get_post_type_archive_link('post') ?>" class="c-button c-button--lg c-button--black">voir tous les contenus & Ressources</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
