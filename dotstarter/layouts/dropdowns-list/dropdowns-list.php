<?php
$title_tag = get_sub_field('h_type');
$title_class = get_sub_field('h_size');
$bg_color = get_sub_field('bg_color');
$show_top_border = get_sub_field('show_top_border');
$decoration_url = get_sub_field('decoration');
$titles_size = get_sub_field('titles_size');
?>

<section
  class="f-dropdowns-list f-layout <?= $show_top_border ? 'f-layout--has-border-top' : '' ?> <?= $bg_color ? "bg-$bg_color" : '' ?>">
  <div class="l-container">
    <div class="f-dropdowns-list__tb">
        <div class="f-layout__header">

            <div class="f-layout__titles">
                <?php if (get_sub_field('title')) : ?>
                    <h6 class=" f-dropdowns-list__subtitle  <?= $title_class ?>">
                        <?php the_sub_field('subtitle') ?>
                    </h6>
                <?php endif; ?>
                <?php if (get_sub_field('title')) : ?>
                    <h2 class="f-layout__title f-dropdowns-list__title  <?= $title_class ?>">
                        <?php the_sub_field('title') ?>
                    </h2>
                <?php endif; ?>

                <?php if (get_sub_field('title_en')): ?>
                    <div class="f-layout__title-en  ">
                        <?php the_sub_field('title_en') ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (get_sub_field('introduction')): ?>
                <div class="f-layout__introductions">
                    <div class="f-layout__introduction  wysiwyg body-md">
                        <?php the_sub_field('introduction') ?>
                    </div>
                    <?php if (get_sub_field('introduction_en')): ?>
                        <div class="f-layout__introduction-en   wysiwyg body-md">
                            <?php the_sub_field('introduction_en') ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (have_rows('dropdowns-list')): ?>
            <div class="f-dropdowns-list__container">

                <?php $cpt = 0; ?>
                <?php while (have_rows('dropdowns-list')):
                    the_row() ?>
                    <div class="f-dropdowns-list__item<?php echo $cpt == 0 ? ' js-open' : '' ?>">
                        <div class="f-dropdowns-list__content">
                            <div class="f-dropdowns-list__header">
                                <?php if (get_sub_field('title')): ?>
                                    <h3 class="f-dropdowns-list__subTitle <?= $titles_size ?>">
                                        <?php the_sub_field('title') ?>
                                    </h3>
                                <?php endif ?>

                                <svg width="19" height="22" class="f-dropdowns-list__arrow" viewBox="0 0 19 22" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.8232 10.0391L0.823242 1.03906L7.32324 10.0391L1.82324 21.5391L17.8232 10.0391Z"
                                          fill="#474747" stroke="#474747" />
                                </svg>

                            </div>
                            <div class="f-dropdowns-list__inner" <?php echo $cpt == 0 ? ' style="height: auto;"' : '' ?>>
                                <?php if (get_sub_field('text')): ?>
                                    <div class="f-dropdowns-list__text wysiwyg text-xl">
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
                            <figure class="f-dropdowns-list__figure">
                                <?php if (get_sub_field('image')): ?>
                                    <?php echo wp_get_attachment_image(get_sub_field('image'), 'large'); ?>
                                <?php endif ?>
                            </figure>
                        </div>
                    </div>

                    <?php $cpt += 1; ?>
                <?php endwhile ?>

            </div>
        <?php endif ?>
    </div>
  </div>
</section>
