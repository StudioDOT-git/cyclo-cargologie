<?php
$title_tag = get_sub_field('h_type');
$title_class = get_sub_field('h_size');
$bg_color = get_sub_field('bg_color');
$show_top_border = get_sub_field('show_top_border');
$decoration_url = get_sub_field('decoration');
$titles_size = get_sub_field('titles_size');
?>

<section class="f-dropdowns-list">
    <div class="l-container">
        <div class="f-dropdowns-list__headings">
            <?php if (get_sub_field('subtitle')): ?>
                <h6 class="f-dropdowns-list__subtitle">
                    <?php the_sub_field('subtitle') ?>
                </h6>
            <?php endif; ?>
            <?php if (get_sub_field('title')): ?>
                <h2 class="f-dropdowns-list__title">
                    <?php the_sub_field('title') ?>
                </h2>
            <?php endif; ?>
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