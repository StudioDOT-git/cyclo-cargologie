<div class="f-page-header">
    <div class="l-container">
        <div class="f-page-header__tb">
            <div class="f-page-header__wrapper">
                <div class="-f-page-header__heading">
                    <h1 class="f-page-header__title"><?= get_sub_field('title'); ?></h1>
                </div>
                <div class="f-page-header__content">
                    <p class="f-page-header__paragraph"><?= get_sub_field('paragraph'); ?></p>
                    <?php while (have_rows('button')):
                        the_row() ?>
                        <?php dot_the_layout_part('button') ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>
