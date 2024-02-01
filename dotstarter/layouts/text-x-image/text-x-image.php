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
</div>
