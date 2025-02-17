<?php

if (!class_exists('DOT_Taxonomies')) {
    class DOT_Taxonomies
    {
        public function __construct()
        {
            add_action('init', array($this, 'register_taxonomies'));
        }
        public function register_taxonomies()
        {
            // Format Taxonomy
            $format_labels = array(
                'name' => 'Format',
                'singular_name' => 'Format',
                'all_items' => 'Tous les formats',
                'edit_item' => 'Modifier le format',
                'add_new_item' => 'Ajouter un format',
                'menu_name' => 'Format'
            );

            register_taxonomy('format', array('tribe_events'), array(
                'hierarchical' => true,
                'labels' => $format_labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
            ));

            // Métier Taxonomy
            $metier_labels = array(
                'name' => 'Métier',
                'singular_name' => 'Métier',
                'all_items' => 'Tous les métiers',
                'edit_item' => 'Modifier le métier',
                'add_new_item' => 'Ajouter un métier',
                'menu_name' => 'Métier'
            );

            // Métier Taxonomy
            register_taxonomy('metier', array('formation'), array(
                'hierarchical' => true,
                'labels' => $metier_labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => false,
                'publicly_queryable' => false,
                'public' => false,
                'rewrite' => false,
                'meta_box_cb' => 'radio_tax_metabox' // This makes it radio buttons instead of checkboxes
            ));

            // Add this function to create radio buttons
            function radio_tax_metabox($post, $box)
            {
                $terms = get_terms(['taxonomy' => 'metier', 'hide_empty' => false]);
                $current = wp_get_post_terms($post->ID, 'metier', ['fields' => 'ids']);
                $name = 'tax_input[metier][]';
                foreach ($terms as $term) {
                    echo '<label><input type="radio" name="' . $name . '" value="' . $term->term_id . '" ' . checked(in_array($term->term_id, $current), true, false) . '>' . $term->name . '</label><br>';
                }
            }

            // Opérateurs Taxonomy
            $operateur_labels = array(
                'name' => 'Opérateurs',
                'singular_name' => 'Opérateur',
                'all_items' => 'Tous les opérateurs',
                'edit_item' => 'Modifier l\'opérateur',
                'add_new_item' => 'Ajouter un opérateur',
                'menu_name' => 'Opérateurs'
            );

            function radio_tax_operateur_metabox($post, $box)
            {
                $terms = get_terms(['taxonomy' => 'operateur', 'hide_empty' => false]);
                $current = wp_get_post_terms($post->ID, 'operateur', ['fields' => 'ids']);
                $name = 'tax_input[operateur][]';

                // Add link to manage terms
                echo '<p><a href="' . admin_url('edit-tags.php?taxonomy=operateur') . '" target="_blank">Gérer les opérateurs</a></p>';

                foreach ($terms as $term) {
                    echo '<label><input type="radio" name="' . $name . '" value="' . $term->term_id . '" ' . checked(in_array($term->term_id, $current), true, false) . '>' . $term->name . '</label><br>';
                }
            }


            // Update the taxonomy registration to use the radio buttons
            register_taxonomy('operateur', array('formation'), array(
                'hierarchical' => true,
                'labels' => $operateur_labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => false,
                'publicly_queryable' => false,
                'public' => false,
                'rewrite' => false,
                'meta_box_cb' => 'radio_tax_operateur_metabox'
            ));

            // Ville Taxonomy
            $ville_labels = array(
                'name' => 'Villes',
                'singular_name' => 'Ville',
                'all_items' => 'Toutes les villes',
                'edit_item' => 'Modifier la ville',
                'add_new_item' => 'Ajouter une ville',
                'menu_name' => 'Villes'
            );

            register_taxonomy('ville', array('formation'), array(
                'hierarchical' => true,
                'labels' => $ville_labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => false,
                'publicly_queryable' => false,
                'public' => false,
                'rewrite' => false,
            ));
        }

    }

    new DOT_Taxonomies();
}
