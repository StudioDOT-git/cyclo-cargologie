<div class="f-column l-layout">
    <div class="f-header-yellow">
        <div class="l-container">
            <div class="f-header-yellow__tb">
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
                <svg viewBox="0 0 353 560" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.4">
                        <path
                            d="M161.796 560H39.9151C31.5925 560 24.8241 553.297 24.6737 544.931V541.907C22.7685 424.075 -72.5403 329.376 -189.809 328.973C-198.181 328.973 -205 322.068 -205 313.651V191.334C-205 182.665 -197.831 175.66 -189.257 176.013C9.08138 184.127 168.915 344.848 176.987 544.175C177.338 552.843 170.369 560 161.746 560H161.796Z"
                            fill="#FFF7C3" />
                        <path
                            d="M62.7798 0H-189.738C-198.172 0 -205 6.852 -205 15.3162V137.846C-205 146.31 -198.172 153.162 -189.738 153.162H185.123C193.557 153.162 200.385 160.014 200.385 168.479V544.684C200.385 553.148 207.212 560 215.646 560H337.738C346.172 560 353 553.148 353 544.684V291.26C353 287.18 351.393 283.3 348.532 280.428L73.5732 4.48403C70.7117 1.61224 66.8461 0 62.7798 0Z"
                            fill="#FFF7C3" />
                    </g>
                </svg>
            </div>
        </div>
    </div>
    <div class="l-container">
        <div class="f-column__tb">
            <div class="f-column__wrapper">
                <?php $i = 0; ?>
                <?php while (have_rows('columns')):
                    the_row() ?>
                    <?php $i++; ?>

                    <div class="f-column__item" data-id="#<?= $i ?>">
                        <div class="f-column__image" data-id="#<?= $i ?>">
                            <?= wp_get_attachment_image(get_sub_field('image'), 'large') ?>
                        </div>
                        <h3 class="f-column__title heading3">
                            <?= get_sub_field('title') ?>
                        </h3>
                        <p class="f-column__description body-lg">
                            <?= get_sub_field('description') ?>
                        </p>
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
