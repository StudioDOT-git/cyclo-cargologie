<?php
$date = dot_get_formatted_event_date();
$tickets_url = tribe_get_event_website_url();
$statuses = get_field('status') ? get_field('status') : array();
$categories = get_the_terms(null, 'tribe_events_cat');
$post = get_post();

$event = get_the_terms($post->ID, 'tribe_events_cat');
$event_date = tribe_get_start_date($post->ID, false, 'd F Y');


$category = get_the_category($post->ID);
$tags = get_the_tags($post->ID);

$show_ticket_button = $tickets_url && (!in_array('full', $statuses) && !in_array('canceled', $statuses) && !in_array('postponed', $statuses));
?>

<div class="f-actu-x-event__spotlight">
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
</div>

