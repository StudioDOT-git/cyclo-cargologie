<?php

if (!class_exists('DOT_Taxonomies')) {
    class DOT_Taxonomies {
        public function __construct() {
            add_action('init', array($this, 'register_taxonomies'));
        }

        public function register_taxonomies() {
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
        }
    }

    new DOT_Taxonomies();
}
