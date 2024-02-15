<?php
$date = dot_get_formatted_event_date();
$tickets_url = tribe_get_event_website_url();
$statuses = get_field('status') ? get_field('status') : array();
$categories = get_the_terms(null, 'tribe_events_cat');

$disciplines = get_the_terms(null, 'discipline') ;

$show_ticket_button = $tickets_url && (!in_array('full', $statuses) && !in_array('canceled', $statuses) && !in_array('postponed', $statuses));
?>

<div class="c-event-card">
    <div class="c-event-card__status">
        <?php if ($show_ticket_button) : ?>
            <a href="<?= $tickets_url ?>" class="c-event-card__ticket" target="_blank">
                <svg aria-describedby="tickets-btn-title" width="19" height="20" viewBox="0 0 19 20" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <title id="ticket-btn-title">Billetterie</title>
                    <path d="M12.2445 12.7446L16.7375 8.26758L14.9371 6.46721C14.6425 6.74044 14.2556 6.89226 13.8537 6.89226C13.4519 6.89226 13.065 6.74044 12.7703 6.46721C12.4971 6.17259 12.3453 5.78561 12.3453 5.38379C12.3453 4.98198 12.4971 4.595 12.7703 4.30038L10.97 2.5L6.49292 6.99297"
                          stroke="white" stroke-miterlimit="10"/>
                    <path d="M6.49298 6.99316L2 11.4702L3.80038 13.2706C4.095 12.9973 4.48197 12.8455 4.88378 12.8455C5.2856 12.8455 5.67257 12.9973 5.96718 13.2706C6.24042 13.5652 6.39224 13.9522 6.39224 14.354C6.39224 14.7558 6.24042 15.1428 5.96718 15.4374L7.76756 17.2378L12.2446 12.7448"
                          stroke="white" stroke-miterlimit="10"/>
                    <path d="M7.89502 5.59082L13.6466 11.3425" stroke="white" stroke-miterlimit="10"/>
                </svg>
            </a>
        <?php endif; ?>
        <?php if (in_array('full', $statuses)) : ?>
            <div class="c-status-tag c-status-tag--red">Complet</div>
        <?php endif; ?>
        <?php if (in_array('canceled', $statuses)) : ?>
            <div class="c-status-tag c-status-tag--yellow">Annulé</div>
        <?php endif; ?>
        <?php if (in_array('postponed', $statuses)) : ?>
            <div class="c-status-tag c-status-tag--blue-light">Reporté</div>
        <?php endif; ?>
    </div>

    <a href="<?php the_permalink() ?>" class="c-event-card__thumbnail">
        <?php the_post_thumbnail('large') ?>
    </a>
    <div class="c-event-card__meta">
        <div class="c-event-card__date">
            <?= $date ?>
        </div>
        <ul class="c-event-card__tags">
            <?php if (is_array($categories)) : ?>
                <?php foreach ($categories as $term) : ?>
                    <?php
                    $color = 'red-light';

                switch ($term->slug) {
                    case 'pirouette-cacahuete':
                        $color = 'green';
                        break;
                    case 'pirouette-circaouette':
                        $color = 'green';
                        break;
                    case 'saison':
                        $color = 'red-light';
                        break;
                    case 'sortie-de-residence':
                        $color = 'blue-light';
                        break;
                    case 'festival':
                        $color = 'yellow';
                        break;
                    case 'residence':
                        $color = 'blue';
                        break;
                    case 'rencontre':
                    case 'scolaire':
                        $color = 'purple';
                        break;
                    default:
                        $color = 'red-light';
                }


                    ?>
                    <li class="c-tag c-tag--<?= $color ?>">
                        <?= $term->name ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (is_array($disciplines)) : ?>
                <?php foreach ($disciplines as $term) : ?>
                    <li class="c-tag c-tag--yellow-light">
                        <?= $term->name ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <a href="<?php the_permalink() ?>" class="c-event-card__title">
        <?php the_title() ?>
    </a>
    <?php if (get_field('performer')) : ?>
        <div class="c-event-card__performer">
            <?php the_field('performer'); ?>
        </div>
    <?php endif; ?>
    <?php if (get_field('description')) : ?>
        <div class="c-event-card__description wysiwyg">
            <?php the_field('description') ?>
        </div>
    <?php endif; ?>
</div>
