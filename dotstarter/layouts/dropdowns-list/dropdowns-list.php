<section class="f-dropdowns-list l-layout">
    <div class="l-container">
        <div class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
            <div class="l-layout__deco-container">
                <?php if (have_rows('sticker')): ?>
                    <?php while (have_rows('sticker')):
                        the_row() ?>
                        <?php dot_the_layout_part('deco') ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="l-layout__titles">
                <h6 class="l-layout__subtitle">
                    <?= get_sub_field('subtitle') ?>
                </h6>
                <h2 class="l-layout__title">
                    <?= get_sub_field('title') ?>
                </h2>
            </div>
            <div class="l-layout__description body-md">
                <?= get_sub_field('description') ?>
            </div>
        </div>

        <div class="f-dropdowns-list__column-container">
            <?php if (have_rows('dropdowns-list')): ?>
                <div class="f-dropdowns-list__container">
                    <?php $cpt = 0; ?>
                    <?php while (have_rows('dropdowns-list')):
                        the_row() ?>
                        <div class="f-dropdowns-list__item<?php echo $cpt == 0 ? ' js-open' : '' ?>">
                            <div class="f-dropdowns-list__content">
                                <div class="f-dropdowns-list__header">
                                    <?php if (get_sub_field('title')): ?>
                                        <h3 class="heading6">
                                            <?php the_sub_field('title') ?>
                                        </h3>
                                    <?php endif ?>
                                    <div class="f-dropdowns-list__arrow"></div>
                                </div>
                                <div class="f-dropdowns-list__inner" <?php echo $cpt == 0 ? ' style="height: auto;"' : '' ?>>
                                    <?php if (get_sub_field('text')): ?>
                                        <div class="f-dropdowns-list__text body-md">
                                            <?php the_sub_field('text') ?>
                                        </div>
                                    <?php endif ?>

                                    <?php if (acf_maybe_get(get_sub_field('button'), 'link') && have_rows('button')): ?>
                                        <div class="f-dropdowns-list__button">
                                            <?php while (have_rows('button')):
                                                the_row() ?>
                                                <?php dot_the_layout_part('button'); ?>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php $cpt += 1; ?>
                    <?php endwhile ?>
                </div>
            <?php endif ?>
            <?php if (have_rows('dropdowns-list-2')): ?>
                <div class="f-dropdowns-list__container">
                    <?php $cpt = 100; ?>
                    <?php while (have_rows('dropdowns-list-2')):
                        the_row() ?>
                        <div class="f-dropdowns-list__item<?php echo $cpt == 0 ? ' js-open' : '' ?>">
                            <div class="f-dropdowns-list__content">
                                <div class="f-dropdowns-list__header">
                                    <?php if (get_sub_field('title')): ?>
                                        <h3 class="heading6">
                                            <?php the_sub_field('title') ?>
                                        </h3>
                                    <?php endif ?>
                                    <div class="f-dropdowns-list__arrow"></div>
                                </div>
                                <div class="f-dropdowns-list__inner" <?php echo $cpt == 0 ? ' style="height: auto;"' : '' ?>>
                                    <?php if (get_sub_field('text')): ?>
                                        <div class="f-dropdowns-list__text body-md">
                                            <?php the_sub_field('text') ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if (acf_maybe_get(get_sub_field('button'), 'link') && have_rows('button')): ?>
                                        <div class="f-dropdowns-list__button">
                                            <?php while (have_rows('button')):
                                                the_row() ?>
                                                <?php dot_the_layout_part('button'); ?>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php $cpt += 1; ?>
                    <?php endwhile ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>
