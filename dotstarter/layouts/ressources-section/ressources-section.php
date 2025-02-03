<div class="f-ressources-section">
    <div class="l-container">
        <div class="f-ressources-section__tb">
            <div class="f-ressources-section__headdings">
                <h6 class="f-ressources-section__subtitle"><?= get_sub_field('subtitle') ?></h6>
                <h2 class="f-ressources-section__title"><?= get_sub_field('title') ?></h2>
            </div>
            <div class="f-ressources-section__content">
                <ul class="f-ressources-section__list">
                    <?php while (have_rows('ressources')):
                        the_row() ?>
                        <li class="f-ressources-section__item">
                            <a href="<?= get_sub_field('file')['url'] ?>" target="_blank" download><?= get_sub_field('file_info') ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="f-resssources-section__cta">
                <?php while (have_rows('button')):
                    the_row() ?>
                    <?php dot_the_layout_part('button') ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
