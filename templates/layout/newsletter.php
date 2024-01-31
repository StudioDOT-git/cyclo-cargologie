<div class="l-newsletter">

    <div class="l-newsletter__container">
        <div class="l-newsletter__column">
            <h3 class="heading3">
                <?php the_field('title', 'option') ?>
            </h3>
            <span class="heading6">
                <?php the_field('text', 'option') ?>
            </span>

            <?php
            $newsletter_form = get_field('form_shortcode', 'option');
            echo do_shortcode($newsletter_form);
            ?>
        </div>
        <div class="l-newsletter__column">
        </div>

    </div>
    <img class="l-newsletter__deco" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/deco-newsletter.svg"
        alt="">

</div>