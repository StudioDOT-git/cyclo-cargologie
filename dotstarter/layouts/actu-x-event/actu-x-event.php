<div class="f-actu-x-event">
    <div class="l-container">
        <div class="f-actu-x-event__tb">
            <div class="f-actu-x-event__wrapper">
                <?php $i = 0; ?>
                <?php while (have_rows('spotlight')):
                    the_row() ?>

                    <?php
                    $post = get_sub_field('post');
                    $last_post = get_posts(['numberposts' => 1]);
                    $next_event = tribe_get_events(['posts_per_page' => 1, 'start_date' => 'now']);

                    $spotlight = get_sub_field('spotlight');

                    if (!$spotlight) {
                        if ($i == 0) {
                            $post = $last_post[0];

                        } else {
                            $post = $next_event[0];
                        }
                    }

                    $category = get_the_category($post->ID);
                    $tags = get_the_tags($post->ID);
                    $event = get_the_terms($post->ID, 'tribe_events_cat');
                    $event_date = tribe_get_start_date($post->ID, false, 'd F Y');

                    ?>
                    <div class="f-actu-x-event__spotlight">
                        <h6 class="f-actu-x-event__subtitle"><?= get_sub_field('subtitle') ?></h6>
                        <h3 class="f-actu-x-event__title heading2"><?= get_sub_field('title') ?></h3>
                        <?php setup_postdata($GLOBALS['post'] = $post); ?>
                        <?php dot_the_component('card') ?>
                        <?php while (have_rows('button')):
                            the_row() ?>
                            <?php dot_the_layout_part('button') ?>
                        <?php endwhile; ?>
                    </div>
                    <?php $i++; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endwhile; ?>

            </div>
        </div>
    </div>
</div>

