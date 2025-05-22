<div class="f-page-header">
    <div class="l-container l-container--medium">
        <div class="f-page-header__tb">
            <div class="f-page-header__wrapper">
                <div class="f-page-header__heading">
                    <div class="f-page-header__deco">
                        <?php while (have_rows('sticker')):
                            the_row() ?>
                            <?php dot_the_layout_part('deco') ?>
                        <?php endwhile; ?>
                    </div>
                    <h1 class="f-page-header__title">
                        <?= get_sub_field('title'); ?>
                    </h1>
                </div>
                <div class="f-page-header__content">
                    <?php if (get_sub_field('intro')): ?>
                        <span class="f-page-header__intro heading5"><?= get_sub_field('intro'); ?></span>
                    <?php endif; ?>
                    <p class="f-page-header__paragraph">
                        <?= get_sub_field('paragraph'); ?>
                    </p>
                    <?php if (get_sub_field('encart')): ?>
                        <span class=" body-lg f-page-header__encart"><?= get_sub_field('encart'); ?></span>
                    <?php endif; ?>
                    <?php while (have_rows('button')):
                        the_row() ?>
                        <?php dot_the_layout_part('button') ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (get_sub_field('scroll_button')): ?>
    <button class="f-page-header__scroll-down">
        <img class="f-page-header__scroll-down-image" src="<?= DOT_THEME_URI ?>/assets/icons/scroll-down.svg" alt="">
    </button>
<?php endif; ?>
<!-- 
<iframe src="https://www.youtube.com/embed/C9z8yXOVZoU?si=FvIRHEIXkgPdE0v_" title="YouTube video player" frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
