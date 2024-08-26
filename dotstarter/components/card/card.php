<?php
/**
 * Card component
 */
$post = get_post();

// Events
$tickets_url = tribe_get_event_website_url();
$statuses = get_field('status') ?? array();
$categories = get_the_terms(null, 'tribe_events_cat');
$event = $post->post_type === 'tribe_events';

$event_date = dot_get_formatted_event_date();
$show_ticket_button = $tickets_url && (!in_array('full', $statuses) && !in_array('canceled', $statuses) && !in_array('postponed', $statuses));
$formats = get_the_terms($post->ID, 'format');


// Posts
if (!$event) {
    if (have_rows('dot_layouts')) {
        while (have_rows('dot_layouts')) {
            the_row();
            $statuses = get_sub_field('status') ?? array();
        }
    }

}
$category = get_the_category($post->ID);
$date = ucwords(get_the_date('M Y', $post->ID));


?>

<div class="f-card__spotlight">
    <a href="<?= get_post_permalink($post->ID) ?>" class="f-card__image">
        <?php if (get_the_post_thumbnail($post->ID)): ?>
            <?= get_the_post_thumbnail($post->ID) ?>
        <?php else: ?>
            <img src="<?= DOT_THEME_URI . '/assets/img/page-thumbnail.png' ?>" alt="Illustration">
        <?php endif; ?>
        <div class="f-card__image-overlay">
            <div class="f-card__tags <?= $event ? 'f-card__tags--event' : '' ?>">
                <?php if ($event): ?>
                    <div class="f-card__date">
                        <span><?= $event_date ?></span>
                        <?php if (!empty(get_field('location'))): ?>

                            <div class="f-card__location">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13"
                                     fill="none">
                                    <path
                                        d="M9 5.13105C9 7.02445 6.5625 10.3594 5.47917 11.7579C5.22917 12.0807 4.75 12.0807 4.5 11.7579C3.41667 10.3594 1 7.02445 1 5.13105C1 2.85037 2.77083 1 5 1C7.20833 1 9 2.85037 9 5.13105Z"
                                        fill="white" fill-opacity="0.5" stroke="#181818" stroke-width="1.1"/>
                                </svg>
                                <span class="f-card__location-name"><?= the_field('location') ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($post->post_type === 'post'): ?>
                    <span class="f-card__tag f-card__tag--date"><?= $date ?></span>
                <?php endif; ?>

                <?php if (isset($category[0])): ?>
                    <span class="f-card__tag"><?= $category[0]->name ?></span>
                <?php elseif ($post->post_type == 'page'): ?>
                    <span class="f-card__tag">Page</span>
                <?php elseif (isset($categories[0])): ?>
                    <span class="f-card__tag"><?= $categories[0]->name ?></span>
                <?php endif; ?>
                <?php if ($formats): ?>
                    <?php foreach ($formats as $format): ?>
                        <span class="f-card__tag f-card__tag--format"><?= $format->name ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <p class="f-card__title"><?= $post->post_title ?></p>
            <div class="f-card__excerpt">
                <?php if ($post->post_type === 'tribe_events'): ?>
                    <p class="f-card__subtitle"><?= the_field('subtitle') ?></p>
                <?php elseif ($post->post_type === 'page' || $post->post_type === 'post'): ?>
                    <p class="f-card__subtitle"><?= the_field('excerpt') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <span class="f-card__statuses">
        <?php
        $event_start_date_for_comparison = tribe_get_start_date(null, false, 'Y-m-d');
        $event_start_timestamp = strtotime($event_start_date_for_comparison);

        $today_date = date('Y-m-d');
        $today_timestamp = strtotime($today_date);

        if ($event_start_timestamp < $today_timestamp): ?>
            <div class="c-status-tag c-status-tag--red">Évènement passé</div>
        <?php else : ?>
            <?php if (in_array('full', $statuses)) : ?>
                <div class="c-status-tag c-status-tag--red">Complet</div>
            <?php endif; ?>
                <?php if (in_array('canceled', $statuses)) : ?>
                <div class="c-status-tag c-status-tag--red">Annulé</div>
            <?php endif; ?>
                <?php if (in_array('postponed', $statuses)) : ?>
                <div class="c-status-tag c-status-tag--red">Reporté</div>
            <?php endif; ?>
                <?php if (in_array('shortly', $statuses)) : ?>
                <div class="c-status-tag c-status-tag--purple">Prochainement</div>
            <?php endif; ?>
        <?php endif; ?>
            <?php if ($post->post_type === 'post'): ?>
                <?php if (in_array('future', $statuses)) : ?>
                    <div class="c-status-tag c-status-tag--purple">A venir</div>
                <?php endif; ?>
            <?php endif; ?>
        </span>
    </a>
</div>
