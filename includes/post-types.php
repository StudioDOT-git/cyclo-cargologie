<?php

if (!class_exists('DOT_PostTypes')) {
    class DOT_PostTypes
    {
        public function __construct()
        {
            add_action('init', array($this, 'register_post_types'));
        }

        public function register_post_types()
        {
            // Formation CPT
            $labels = array(
                'name' => 'Formations',
                'singular_name' => 'Formation',
                'menu_name' => 'Formations',
                'add_new' => 'Ajouter une formation',
                'add_new_item' => 'Ajouter une nouvelle formation',
                'edit_item' => 'Modifier la formation',
                'new_item' => 'Nouvelle formation',
                'view_item' => 'Voir la formation',
                'search_items' => 'Rechercher des formations',
                'not_found' => 'Aucune formation trouvée',
                'not_found_in_trash' => 'Aucune formation trouvée dans la corbeille'
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'has_archive' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-welcome-learn-more',
                'supports' => array('title', 'thumbnail', 'custom-fields'),
                'rewrite' => array('slug' => 'formations')
            );

            register_post_type('formation', $args);

            // Bibliothèque média CPT
            $media_labels = array(
                'name' => _x('Bibliothèque média', 'Post type general name', 'dotcore'),
                'singular_name' => _x('Média', 'Post type singular name', 'dotcore'),
                'menu_name' => _x('Bibliothèque média', 'Admin Menu text', 'dotcore'),
                'add_new' => __('Ajouter', 'dotcore'),
                'add_new_item' => __('Ajouter un média', 'dotcore'),
                'edit_item' => __('Modifier le média', 'dotcore'),
                'new_item' => __('Nouveau média', 'dotcore'),
                'view_item' => __('Voir le média', 'dotcore'),
                'all_items' => __('Tous les médias', 'dotcore'),
                'search_items' => __('Rechercher des médias', 'dotcore'),
                'not_found' => __('Aucun média trouvé.', 'dotcore'),
                'not_found_in_trash' => __('Aucun média trouvé dans la corbeille.', 'dotcore'),
            );

            $media_args = array(
                'labels' => $media_labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'bibliotheque-media'),
                'capability_type' => 'post',
                'hierarchical' => false,
                'has_archive' => true,
                'menu_icon' => 'dashicons-format-image',
                'supports' => array('title', 'thumbnail'),
                'taxonomies' => array('category'),
            );

            register_post_type('bibliotheque-media', $media_args);

            // Attach default category taxonomy to this CPT
            register_taxonomy_for_object_type('category', 'bibliotheque-media');
        }
    }

    new DOT_PostTypes();
}

// Rename "category" to "Types de média" for the bibliotheque-media CPT only
add_filter('register_taxonomy_args', function ($args, $taxonomy) {
    if (
        $taxonomy === 'category' &&
        isset($_GET['post_type']) &&
        $_GET['post_type'] === 'bibliotheque-media'
    ) {
        $args['labels']['name'] = __('Types de média', 'dotcore');
        $args['labels']['singular_name'] = __('Type de média', 'dotcore');
        $args['labels']['add_new_item'] = __('Ajouter un type de média', 'dotcore');
        $args['labels']['edit_item'] = __('Modifier le type de média', 'dotcore');
        $args['labels']['search_items'] = __('Rechercher des types de média', 'dotcore');
        $args['labels']['all_items'] = __('Tous les types de média', 'dotcore');
    }
    return $args;
}, 10, 2);
