<div class="f-members-grid l-layout">
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

        <div class="f-members-grid__list">
            <?php if (have_rows('members')): ?>
                <?php while (have_rows('members')):
                    the_row(); ?>
                    <div class="f-members-grid__item">
                        <div class="f-members-grid__item-image">
                            <img src="<?= get_sub_field('image')['url'] ?>" alt="<?= get_sub_field('image')['alt'] ?>">
                        </div>
                        <div class="f-members-grid__item-name heading5">
                            <?= get_sub_field('name') ?>
                        </div>
                        <div class="f-members-grid__item-position heading7">
                            <?= get_sub_field('role') ?>
                        </div>
                        <div class="f-members-grid__item-description">
                            <?= get_sub_field('description') ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
