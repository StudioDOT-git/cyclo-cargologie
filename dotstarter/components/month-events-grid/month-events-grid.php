<?php

setLocale(LC_TIME, 'fr_FR');

global $events_archive_query;
$str_date = $events_archive_query->meta_query->queries[1][0][0]['value'];
$datetime = (DateTime::createFromFormat('Y-m-d', $str_date))->setTime(0, 0);
$date_ts = $datetime->getTimestamp();
$current_month_label = date_i18n('F', $date_ts);
$id = date_i18n('F-Y', $date_ts);

?>


    <div id="<?= $id ?>"
         class="c-events-archive-month<?= $events_archive_query->post_count === 0 ? ' no-results' : '' ?>">
        <div class="l-container">
            <div class="c-events-archive-month__title heading3">
                <span class="title-deco"></span>
                <?= $current_month_label ?>
            </div>
            <div class="c-events-archive-month__events">

                <?php if ($events_archive_query->have_posts()) : ?>
                    <?php while ($events_archive_query->have_posts()) : $events_archive_query->the_post(); ?>
                        <?php dot_the_component('event-card') ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="c-events-archive-month__not-found">Aucun évènement n'a été trouvé pour ce mois.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
<?php wp_reset_postdata(); ?>
