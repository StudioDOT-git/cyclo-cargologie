<div class="f-key-numbers l-layout">
    <div class="l-container">
        <div class="l-layout__headings">
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
        <div class="f-key-numbers__wrapper">
            <?php while (have_rows('columns')):
                the_row() ?>
                <div class="f-key-numbers__item">
                    <?php if (have_rows('sticker')): ?>
                        <?php while (have_rows('sticker')):
                            the_row() ?>
                            <?php dot_the_layout_part('deco') ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <h3 class="f-key-numbers__number">
                        <?= get_sub_field('number') ?>
                    </h3>
                    <p class="f-key-numbers__description heading6">
                        <?= get_sub_field('description') ?>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
