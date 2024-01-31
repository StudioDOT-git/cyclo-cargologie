<div class="f-column">
    <div class="l-container">
        <div class="f-column__tb">
            <div class="f-column__wrapper">
                <?php $i = 0; ?>
                <?php while (have_rows('columns')):
                    the_row() ?>
                    <?php $i++; ?>

                    <div class="f-column__item" data-id="#<?= $i ?>">
                        <div class="f-column__image" data-id="#<?= $i ?>">
                            <?= wp_get_attachment_image(get_sub_field('image'), 'medium') ?>
                        </div>
                        <h3 class="f-column__title heading3"><?= get_sub_field('title') ?></h3>
                        <p class="f-column__description body-lg"><?= get_sub_field('description') ?></p>
                    </div>


                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
