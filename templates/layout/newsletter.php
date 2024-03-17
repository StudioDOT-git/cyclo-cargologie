<?php if(!is_404()):?>
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
            <h3 class="heading3">
                <?php the_field('title_mouvement', 'option') ?>
            </h3>
            <span class="heading6">
                <?php the_field('text_mouvement', 'option') ?>
            </span>

            <?php if (have_rows('buttons_mouvement', 'option')): ?>
                <div class="l-newsletter__button-container">
                    <?php while (have_rows('buttons_mouvement', 'option')):
                        the_row() ?>
                        <?php while (have_rows('button_mouvement', 'option')):
                            the_row() ?>
                            <?php dot_the_layout_part('button') ?>
                        <?php endwhile; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <img class="l-newsletter__deco" src="<?= get_stylesheet_directory_uri(); ?>/assets/img/deco-newsletter.svg"
        alt="deco">
</div>
<?php endif;?>
