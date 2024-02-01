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
        <div class="f-text-x-image__bg">
            <svg viewBox="0 0 1538 4930" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line opacity="0.1" x1="0.5" y1="2.18557e-08" x2="0.499605" y2="9039" stroke="#979797"/>
                <line opacity="0.1" x1="307.5" y1="2.18557e-08" x2="307.5" y2="9039" stroke="#979797"/>
                <line opacity="0.1" x1="614.5" y1="2.68598e-08" x2="614.5" y2="9039" stroke="#979797"/>
                <line opacity="0.1" x1="921.5" y1="2.68598e-08" x2="921.5" y2="9039" stroke="#979797"/>
                <line opacity="0.1" x1="1228.5" y1="2.18557e-08" x2="1228.5" y2="9039" stroke="#979797"/>
                <line opacity="0.1" x1="1535.5" y1="2.18557e-08" x2="1535.5" y2="9039" stroke="#979797"/>
            </svg>
        </div>
</div>
