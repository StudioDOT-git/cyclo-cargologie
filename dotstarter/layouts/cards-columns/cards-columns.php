<div class="f-cards-columns">
    <div class="l-container">
        <div class="f-cards-columns__headings">
            <?php if (have_rows('sticker')): ?>
                <?php while (have_rows('sticker')):
                    the_row() ?>
                    <?php dot_the_layout_part('deco') ?>
                <?php endwhile; ?>
            <?php endif; ?>
            <h2 class="f-cards-columns__title heading2">
                <?php the_sub_field('title') ?>
            </h2>
        </div>
    </div>
    <div class="f-cards-columns__wrapper">
        <?php $i = 0; ?>
        <?php while (have_rows('sections')):
            the_row() ?>
            <?php $i++; ?>
            <div class="f-cards-columns__section">
                <div class="l-container">
                    <div class="f-cards-columns__section-container">
                        <div class="f-cards-columns__section-image" data-id="#<?= $i ?>">
                            <div class="f-cards-columns__image">
                                <?= wp_get_attachment_image(get_sub_field('image'), 'large') ?>
                            </div>
                            <?php if (have_rows('sticker')): ?>
                                <?php while (have_rows('sticker')):
                                    the_row() ?>
                                    <?php dot_the_layout_part('deco') ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="f-cards-columns__section-text">
                            <h3 class="f-cards-columns__section-title heading6">
                                <?php the_sub_field('title') ?>
                            </h3>
                            <p class="f-cards-columns__section-description body-xs">
                                <?= get_sub_field('description') ?>
                            </p>
                            <?php if (have_rows('button')): ?>
                                <div class="f-cards-columns__cta-wrapper">
                                    <?php while (have_rows('button')):
                                        the_row() ?>
                                        <?php dot_the_layout_part('button') ?>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>