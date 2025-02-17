<div class="f-formation-calendar l-layout">
    <div class="l-container">
        <div class="l-layout__headings <?php if (have_rows('sticker')): ?>l-layout__headings--with-deco<?php endif; ?>">
            <div class="l-layout__deco-container">
                <?php if (have_rows('sticker')): ?>
                    <?php while (have_rows('sticker')):
                        the_row() ?>
                        <?php dot_the_layout_part('deco') ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="l-layout__titles">
                <h2 class="l-layout__title">
                    <?= get_sub_field('title') ?>
                </h2>
            </div>
        </div>
    </div>

    <div class="l-container l-container--md">
        <?php
        $posts_per_page = 10;
        $paged = $_GET['page'] ?? 1;
        $args = [
            'post_type' => 'formation',
            'per_page' => $posts_per_page,
            'page' => $paged,
            'meta_key' => 'date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_type' => 'NUMERIC'
        ];

        // Handle URL parameters
        if (!empty($_GET['ville'])) {
            $args['ville'] = $_GET['ville'];
        }
        if (!empty($_GET['operateur'])) {
            $args['operateur'] = $_GET['operateur'];
        }

        $posts = AjaxFormationPost::renderPosts($args);
        ?>
        <!-- <div class="f-formation-calendar__job-filter">
            <span class="f-formation-calendar__job-filter-title">Choisir un métier</span>
            <div class="f-formation-calendar__job-filter-list">
                <?php
                $selected_metier = get_sub_field('preselection_metier');
                $is_all = in_array('all', $selected_metier);
                ?>
                <div
                    class="f-formation-calendar__job <?php echo ($is_all || in_array('livraison', $selected_metier)) ? 'is-active' : ''; ?>">
                    Parcours Livraison</div>
                <div
                    class="f-formation-calendar__job <?php echo ($is_all || in_array('dispatch', $selected_metier)) ? 'is-active' : ''; ?>">
                    Parcours Dispatch</div>
                <div
                    class="f-formation-calendar__job <?php echo ($is_all || in_array('management', $selected_metier)) ? 'is-active' : ''; ?>">
                    Parcours Management</div>
            </div>
        </div> -->

        <div id="formation-archive" class="f-formation-calendar__archive" data-posts-per-page="<?= $posts_per_page ?>">

            <?php dot_the_layout_part('yellow-background') ?>

            <div class="l-container l-container--md"></div>
            <?php
            $component = acf_get_instance('\DOT\Core\Main\Components');
            $component->the_component('formation-filters-bar');
            ?>
            <div class="f-formation-grid">
                <?= $posts['render'] ?>
                <?php if (!$posts['total_posts']): ?>
                    <div class="c-filters_no-results">
                        <div>Aucun article trouvé</div>
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
