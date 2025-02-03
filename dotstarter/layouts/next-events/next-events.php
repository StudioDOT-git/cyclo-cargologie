<?php


$events = AjaxPost::renderPosts([
    'post_type' => 'tribe_events',
    'per_page' => 2,
]);

$events = $events['query']->posts;


?>

<div class="f-next-events">
    <div class="l-container l-container--md">
        <div class="f-next-events__tb">
            <div class="f-next-events__title heading2">Nos prochains RDV</div>
            <div class="f-next-events__events">
                <?php $i = 0; ?>
                <?php while (have_rows('spotlight')): the_row() ?>
                    <?php

                    $spotlight = get_sub_field('spotlight');
                    $event = get_post(get_sub_field('event'));

                    if (!$spotlight) {
                        $event = $events[$i] ?? null;
                        $i++;

                    }


                    if ($event) {
                        setup_postdata($GLOBALS['post'] = $event);
                        dot_the_component('card');

                    }

                    wp_reset_postdata();

                    ?>
                <?php endwhile; ?>
            </div>
            <div class="f-next-events__cta">
                <a href="<?php the_field('events_page', 'option') ?>"
                   title="Découvrir les évènements"
                   class="c-button c-button--lg c-button--black">
                    <span>Découvrir les évènements</span>
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
