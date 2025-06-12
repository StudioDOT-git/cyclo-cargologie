<div class="f-bibliotheque-media l-layout">
    <div class="l-container">
        <div class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
            <div class="l-layout__deco-container">
                <?php if (have_rows('sticker')): ?>
                    <?php while (have_rows('sticker')):
                        the_row(); ?>
                        <?php dot_the_layout_part('deco'); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="l-layout__titles">
                <h2 class="l-layout__title"><?= get_sub_field('title') ?></h2>
            </div>
        </div>
    </div>
    <div class="l-container l-container--md">
        <?php
        $posts_per_page = 12;
        $paged = $_GET['page'] ?? 1;
        $args = [
            'post_type' => 'bibliotheque-media',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'meta_key' => 'date',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        ];

        // Handle URL parameters for filtering by category (Types de média)
        if (!empty($_GET['media_category'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'media_category',
                    'field' => 'slug',
                    'terms' => $_GET['media_category'],
                ]
            ];
        }

        $posts = AjaxBibliothequeMediaPost::renderPosts($args);
        ?>
        <div id="bibliotheque-media-archive" class="f-bibliotheque-media__archive"
            data-posts-per-page="<?= $posts_per_page ?>">
            <?php dot_the_layout_part('yellow-background') ?>
            <div class="l-container l-container--md"></div>
            <?php
            $component = acf_get_instance('\DOT\Core\Main\Components');
            $component->the_component('bibliotheque-media-filters-bar');
            ?>
            <div class="f-bibliotheque-media-grid">
                <?= $posts['render'] ?>
                <?php if (!$posts['total_posts']): ?>
                    <div class="c-filters_no-results">
                        <div>Aucun média n'est actuellement disponible</div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="c-pagination" data-max-num-pages="<?= $posts['max_num_pages'] ?>" data-paged="<?= $paged ?>">
                <div class="c-pagination__prev" rel="prev">Précédent</div>
                <div class="c-pagination__pages"></div>
                <div class="c-pagination__next" rel="next">Suivant</div>
            </div>
        </div>
    </div>
</div>