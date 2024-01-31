<div class="f-text-x-image">
    <div class="l-container">
        <div class="f-text-x-image__tb">

            <?php $i = 0; ?>
            <?php while (have_rows('texte_x_image')):
                the_row() ?>
                <?php $i++; ?>
                <div class="f-text-x-image__wrapper <?= $i % 2 == 1 ? 'reverse' : '' ?>">
                    <div class="f-text-x-image__image">
                        <?= wp_get_attachment_image(get_sub_field('image'), 'medium') ?>
                    </div>
                    <div class="f-text-x-image__content">
                        <h3 class="f-text-x-image__title heading2"><?= get_sub_field('title') ?></h3>
                        <div class="f-text-x-image__paragraph body-lg"><?= get_sub_field('text') ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
