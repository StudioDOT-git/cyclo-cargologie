<div class="f-members-grid">
    <div class="l-container">
        <div class="f-members-grid__tb">
            <div class="f-members-grid__title heading2">
                <?= get_sub_field('title') ?>
            </div>
            <div class="f-members-grid__list">
                <?php if (have_rows('members')): ?>
                    <?php while (have_rows('members')): the_row(); ?>
                        <div class="f-members-grid__item">
                            <div class="f-members-grid__item__img">
                                <img src="<?= get_sub_field('image')['url'] ?>" alt="<?= get_sub_field('image')['alt'] ?>">
                            </div>
                            <div class="f-members-grid__item__name">
                                <?= get_sub_field('name') ?>
                            </div>
                            <div class="f-members-grid__item__position">
                                <?= get_sub_field('role') ?>
                            </div>
                            <div class="f-members-grid__item__description">
                                <?= get_sub_field('description') ?>
                            </div>
                            <?= dot_get_icon('linkedin', 'f-members-grid__item__linkedin') ?>
                            <?= dot_get_icon('twitter', 'f-members-grid__item__linkedin') ?>

                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
