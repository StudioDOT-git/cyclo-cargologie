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

<?php get_footer(); ?>
