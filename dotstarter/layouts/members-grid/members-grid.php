<div class="f-members-grid">
    <div class="l-container">
        <div class="f-members-grid__headings">
            <?php if (have_rows('sticker')): ?>
                <?php while (have_rows('sticker')):
                    the_row() ?>
                    <?php dot_the_layout_part('deco') ?>
                <?php endwhile; ?>
            <?php endif; ?>
            <div class="f-members-grid__title heading2">
                <?= get_sub_field('title') ?>
            </div>
            <p class="f-members-grid__description body-lg">
                <?= get_sub_field('description') ?>
            </p>
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