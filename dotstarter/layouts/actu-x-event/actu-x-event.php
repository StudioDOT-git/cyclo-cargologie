<div class="f-actu-x-event">
    <div class="l-container">
        <div class="f-actu-x-event__tb">
            <div class="f-actu-x-event__wrapper">
                <?php while (have_rows('spotlight')):
                    the_row() ?>
                    <div class="f-actu-x-event__spotlight">
                        <h6 class="f-actu-x-event__subtitle"><?= get_sub_field('subtitle') ?></h6>
                        <h3 class="f-actu-x-event__title heading2"><?= get_sub_field('title') ?></h3>
                        <div class="f-actu-x-event__image">
                            <?= wp_get_attachment_image(get_sub_field('image'), 'large') ?>
                            <div class="f-actu-x-event__image-overlay">
                                <div class="f-actu-x-event__date">31 Mai 2025</div>
                                <div class="f-actu-x-event__tags">
                                    <span class="f-actu-x-event__tag">Evènement</span>
                                    <span class="f-actu-x-event__tag">Portraits</span>
                                    <span class="f-actu-x-event__tag">Presse</span>

                                </div>
                                <p class="f-actu-x-event__resume"><?= get_sub_field('resume') ?></p>
                            </div>
                        </div>

                        <?php while (have_rows('button')):
                            the_row() ?>
                            <?php dot_the_layout_part('button') ?>
                        <?php endwhile; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

