<div class="f-key-numbers">
    <div class="l-container">
        <h1 class="f-key-numbers__title heading2">
            <?php the_sub_field('title') ?>
        </h1>
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