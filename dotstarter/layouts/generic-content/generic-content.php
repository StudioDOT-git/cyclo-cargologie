<?php

$title_tag = get_sub_field('h_type');
$title_class = get_sub_field('h_size');
$bg_color = get_sub_field('bg_color');
$show_top_border = get_sub_field('show_top_border');
?>

<div
    id="f-generic-content"
    class="f-generic-content f-layout <?= $show_top_border ? 'f-layout--has-border-top' : '' ?> <?= $bg_color ? 'bg-' . $bg_color : '' ?>">
    <div class="l-container">
        <div class="f-generic-content__tb">
            <div class="f-generic-content__main">
                <?php if (have_rows('content')) : ?>
                    <?php while (have_rows('content')) :
                        the_row(); ?>
                        <?php switch (get_row_layout()):
                        case 'title':
                            $type = get_sub_field('type');
                            $size = get_sub_field('size');
                            $tag_open = "<$type class=\"generic-title $size \">";
                            $tag_close = "</$type>";

                            $full_title = $tag_open;

                            $full_title .= get_sub_field('title') . $tag_close;

                            echo $full_title;
                            break;
                        case 'text': ?>
                            <div class="generic-content-text wysiwyg">
                                <?php the_sub_field('text'); ?>
                            </div>
                            <?php break;
                        case 'text-en': ?>
                            <div class="generic-content-text-en wysiwyg">
                                <?php the_sub_field('text_en'); ?>
                            </div>
                            <?php break;
                        case 'image':
                            $image = get_sub_field('image');
                            $is_large = get_sub_field('is_large');
                            ?>
                            <figure class="generic-image slide-ttb <?= $is_large ? 'is-large' : '' ?>">
                                <?= wp_get_attachment_image($image['ID'], 'full'); ?>
                                <figcaption>
                                    <?= $image['caption']; ?>
                                </figcaption>
                            </figure>
                            <?php break;
                        case 'slider':
                            $images = get_sub_field('gallery');
                            $is_large = get_sub_field('is_large');
                            ?>
                            <div class="f-generic-content__slider-wrapper">
                                <div
                                    class="generic-gallery f-generic-content__slider <?= $is_large ? 'is-large' : '' ?>">
                                    <?php foreach ($images as $image) : ?>
                                        <figure class="generic-gallery__item f-generic-content__slide">
                                            <?= wp_get_attachment_image($image['ID'], 'full'); ?>
                                            <figcaption>
                                                <?= $image['caption']; ?>
                                            </figcaption>
                                        </figure>
                                    <?php endforeach; ?>

                                </div>

                                <div class="f-generic-content__index c-slider__index">
                                    <span class="c-slider__prev btn-prev"><img
                                            src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-left.svg"/></span>
                                    <div class="c-slider__index-mid">
                                        <span class="current-index">1</span> / <span class="total-slides">0</span>
                                    </div>
                                    <span class="c-slider__next btn-next"><img src="<?= DOT_THEME_URI ?>/assets/icons/slider-arrow-right.svg"/></span>
                                </div>
                            </div>

                            <?php break;
                        case 'columns': ?>
                            <div class="generic-columns">
                                <?php if (have_rows('columns')) :
                                    while (have_rows('columns')) :
                                        the_row(); ?>
                                        <div class="generic-columns__column">
                                            <?php if (get_sub_field('title')) : ?>
                                                <?php
                                                $title_size = get_sub_field('title_size');
                                                $title = get_sub_field('title');
                                                echo "<h3 class=\"generic-columns__title $title_size\">$title</h3>";
                                                ?>
                                            <?php endif; ?>
                                            <?php if (get_sub_field('text')) : ?>
                                                <p class="generic-columns__text wysiwyg">
                                                    <?php the_sub_field('text'); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endwhile;
                                endif; ?>
                            </div>
                            <?php break;
                        case 'embed': ?>
                            <?php $force_ratio = get_sub_field('force_ratio') ?>
                            <div class="generic-embed <?= $force_ratio ? 'is-16-9' : '' ?> slide-ttb">
                                <div class="generic-embed__embed">
                                    <?php the_sub_field('embed') ?>
                                </div>
                            </div>
                            <?php break;
                        case 'buttons':
                            if (have_rows('button_repeater')) : ?>
                                <div class="f-generic-content__buttons">
                                    <?php while (have_rows('button_repeater')) :
                                        the_row();
                                        while (have_rows('button')) :
                                            the_row();
                                            dot_the_layout_part('button');
                                        endwhile;
                                    endwhile; ?>
                                </div>
                            <?php endif;
                    endswitch;
                    endwhile;
                endif; ?>
            </div>
            <?php if (get_sub_field('embed') && !is_admin()) : ?>
                <div class="f-generic-content__sidebar">
                    <div class="f-generic-content__sidebar-content">
                        <?php the_sub_field('embed'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
