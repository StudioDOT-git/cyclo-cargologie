<?php
$categories = get_the_category(get_the_ID());
$tags = get_the_tags();
?>

<a class="f-post-card" href="<?php the_permalink(); ?>">
    <div class="f-post-card__header">
        <?php $thumbnail_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>
        <img loading="lazy" src="<?php echo get_the_post_thumbnail_url() ?>" class="f-post-card__thumbnail" alt="<?php echo esc_html($thumbnail_alt) ?>" />
    </div>
    <div class="f-post-card__content">
        <div class="f-post-card__read-duration"><span><?php the_field('estimate_reading_duration') ?></span> Lecture</div>
        <div class="f-post-card__terms">
            <?php if (is_array($categories)) : ?>
                <?php foreach ($categories as $cat) : ?>
                    <div class="f-post-card__category c-tag"><?php echo $cat->name ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (is_array($tags)) : ?>
                <?php foreach ($tags as $tag) : ?>
                    <div class="f-post-card__tag c-tag"><?php echo $tag->name ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="f-post-card__title"><?php the_title() ?></div>
        <div class="f-post-card__excerpt"><?php the_excerpt() ?></div>
    </div>
</a>