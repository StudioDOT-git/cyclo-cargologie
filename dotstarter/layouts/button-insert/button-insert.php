<div class="f-button-insert">
    <div class="l-container l-container--md">
        <div class="f-button-insert__wrapper">
            <div class="f-button-insert__heading">
                <div class="f-button-insert__deco">
                    <?php while (have_rows('sticker')):
                        the_row() ?>
                        <?php dot_the_layout_part('deco') ?>
                    <?php endwhile; ?>
                </div>
                <h2 class="heading2 f-button-insert__title">
                    <?= get_sub_field('title'); ?>
                </h2>
            </div>
            <div class="f-button-insert__content">
                <?php while (have_rows('button')):
                    the_row() ?>
                    <?php dot_the_layout_part('button') ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>