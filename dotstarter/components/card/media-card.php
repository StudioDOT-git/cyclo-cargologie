<?php
$post = get_post();
?>
<div class="f-media-card">
    <a href="<?= get_permalink($post->ID) ?>" class="f-media-card__link">
        <div class="f-media-card__image">
            <?php if (has_post_thumbnail($post->ID)): ?>
                <?= get_the_post_thumbnail($post->ID, 'medium') ?>
            <?php else: ?>
                <img src="<?= DOT_THEME_URI . '/assets/img/page-thumbnail.png' ?>" alt="Illustration">
            <?php endif; ?>
        </div>
        <div class="f-media-card__content">
            <h3 class="f-media-card__title"><?= esc_html($post->post_title) ?></h3>
            <?php if (get_field('excerpt', $post->ID)): ?>
                <p class="f-media-card__excerpt"><?= esc_html(get_field('excerpt', $post->ID)) ?></p>
            <?php endif; ?>
            <?php
            // Display media_category terms if you want
            $terms = get_the_terms($post->ID, 'media_category');
            if ($terms && !is_wp_error($terms)):
                echo '<div class="f-media-card__categories">';
                foreach ($terms as $term) {
                    echo '<span class="f-media-card__category">' . esc_html($term->name) . '</span> ';
                }
                echo '</div>';
            endif;
            ?>
        </div>
    </a>
</div>
