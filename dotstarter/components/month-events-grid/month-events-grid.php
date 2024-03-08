<?php

setLocale(LC_TIME, 'fr_FR');

global $events_archive_query;
$str_date = $events_archive_query->meta_query->queries[1][0][0]['value'];

?>


<?php if ($events_archive_query->have_posts()) : ?>
    <?php while ($events_archive_query->have_posts()) : $events_archive_query->the_post(); ?>
        <?php dot_the_component('card') ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
