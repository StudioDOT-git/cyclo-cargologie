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
                        <a href="<?= get_post_permalink($post->ID) ?>" class="f-actu-x-event__image">
                            <?= get_the_post_thumbnail($post->ID) ?>
                            <div class="f-actu-x-event__image-overlay">
                                <?php if ($event): ?>
                                    <div class="f-actu-x-event__date"><?= $event_date ?></div>
                                <?php endif; ?>
                                <div class="f-actu-x-event__tags">
                                    <?php if (isset($category[0])): ?>
                                        <span class="f-actu-x-event__tag"><?= $category[0]->name ?></span>
                                    <?php else: ?>
                                        <span class="f-actu-x-event__tag">Evènement</span>
                                    <?php endif; ?>
                                    <?php if ($tags): ?>
                                        <?php foreach ($tags as $tag): ?>
                                            <span class="f-actu-x-event__tag"><?= $tag->name ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <p class="f-actu-x-event__resume"><?= $post->post_title ?></p>
                            </div>
                        </a>

                        <?php while (have_rows('button')):
                            the_row() ?>
                            <?php dot_the_layout_part('button') ?>
                        <?php endwhile; ?>
                    </div>
                    <?php $i++; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

