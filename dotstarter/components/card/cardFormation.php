<?php
$post = get_post();
?>
<div class="card-formation">
    <a href="<?= get_post_permalink($post->ID) ?>" class="card-formation__link">
        <h1>Hello card-formation</h1>
        <div class="card-formation__image">
            <?php if (get_the_post_thumbnail($post->ID)): ?>
                <?= get_the_post_thumbnail($post->ID) ?>
            <?php else: ?>
                <img src="<?= DOT_THEME_URI . '/assets/img/page-thumbnail.png' ?>" alt="Illustration">
            <?php endif; ?>
        </div>
        <div class="card-formation__content">
            <h3 class="card-formation__title"><?= $post->post_title ?></h3>
            <?php if (get_field('excerpt')): ?>
                <p class="card-formation__excerpt"><?= get_field('excerpt') ?></p>
            <?php endif; ?>
        </div>
    </a>
</div>
