<div class="f-column l-layout">
    <div class="f-header-yellow">
        <div class="l-container">
            <div class="f-header-yellow__tb">
                <div
                    class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
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
                        <h3 class="f-header-yellow__intro heading3">
                            <?php the_sub_field('intro') ?>
                        </h3>
                        <p class="f-header-yellow__paragraph body-md">
                            <?php the_sub_field('paragraph') ?>
                        </p>

                    </div>
                </div>
            </div>
            <div class="f-header-yellow__bg">
                <svg width="353" height="560" viewBox="0 0 353 560" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_525_15997)">
                        <path
                            d="M-239 302.05C-239 308.768 -233.764 314.351 -227.045 314.746H-226.65C-127.356 320.871 -47.9208 400.356 -41.7952 499.65C-41.7952 499.699 -41.7952 499.798 -41.7952 499.848C-41.4 506.615 -35.8672 512 -29.0994 512H242.601C249.418 512 254.951 506.467 254.951 499.65V176.426C254.951 169.856 252.332 163.582 247.738 158.938L114.012 25.2124C109.369 20.5688 103.095 18 96.5248 18H-226.65C-233.467 18 -239 23.5328 -239 30.35V302.05ZM106.8 381.189C106.8 388.006 101.267 393.539 94.45 393.539C89.1148 393.539 84.6194 390.13 82.8904 385.388C47.8164 296.27 -23.1714 225.233 -112.289 190.159C-116.982 188.331 -120.292 183.836 -120.292 178.55C-120.292 171.733 -114.759 166.2 -107.942 166.2H94.45C101.267 166.2 106.8 171.733 106.8 178.55V381.189Z"
                            fill="#FFEC54" />
                    </g>
                    <defs>
                        <clipPath id="clip0_525_15997">
                            <rect width="494" height="494" fill="white" transform="translate(-239 18)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
        </div>
    </div>
    <div class="l-container">
        <div class="f-column__tb">
            <div class="f-column__wrapper">
                <?php
                $columns_title_size = get_sub_field('columns_title_size');
                $columns_title_class = $columns_title_size ? $columns_title_size : 'heading3';
                ?>
                <?php $i = 0; ?>
                <?php while (have_rows('columns')):
                    the_row() ?>
                    <?php $i++; ?>

                    <div class="f-column__item" data-id="#<?= $i ?>">
                        <div class="f-column__image" data-id="#<?= $i ?>">
                            <?= wp_get_attachment_image(get_sub_field('image'), 'large') ?>
                        </div>
                        <h3 class="f-column__title <?= esc_attr($columns_title_class) ?>">
                            <?= get_sub_field('title') ?>
                        </h3>
                        <p class="f-column__description body-lg">
                            <?= get_sub_field('description') ?>
                        </p>
                        <?php if (have_rows('button')): ?>
                            <?php while (have_rows('button')):
                                the_row(); ?>
                                <?php dot_the_layout_part('button'); ?>
                            <?php endwhile; ?>
                        <?php endif; ?>

                    </div>
                <?php endwhile; ?>
            </div>
            <div class="f-column__cta-wrapper">
                <?php while (have_rows('button')):
                    the_row() ?>
                    <?php dot_the_layout_part('button') ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
