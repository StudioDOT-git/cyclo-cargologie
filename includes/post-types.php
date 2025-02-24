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
        }
    }

    new DOT_PostTypes();
}
