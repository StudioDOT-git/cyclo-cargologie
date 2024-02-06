<?php


if (!class_exists('DOT_Starter')) {
    class DOT_Starter {

        /**
         * Init : set constants, load files, set hooks
         *
         * @throws Exception
         */
        public function __construct() {
            require_once(get_stylesheet_directory() . '/vendor/autoload.php');

            add_action('tgmpa_register', array($this, 'register_required_plugins'));

            $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
            $dotenv->load();

            if (!class_exists('\DOT\Core\DOT_Core') || !defined('ACF_PRO') || !defined('ACFE')) {
                return;
            }

            require_once(DOT_THEME_INCLUDES_PATH . 'helpers.php');
            require_once(DOT_THEME_INCLUDES_PATH . 'walker.php');
            require_once(DOT_THEME_INCLUDES_PATH . 'post-types.php');
            require_once(DOT_THEME_INCLUDES_PATH . 'taxonomies.php');
            require_once(DOT_THEME_INCLUDES_PATH . 'storage.php');
            require_once(DOT_THEME_INCLUDES_PATH . 'tinymce.php');

            add_action('after_setup_theme', array($this, 'theme_setup'));
            add_action('after_setup_theme', array($this, 'register_nav_menus'));

            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 1);
            add_action('wp_enqueue_scripts', array($this, 'remove_wp_block_library_css'), 100);
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

            remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

            add_action('upload_mimes', array($this, 'add_mime_types_to_upload_whitelist'));

            add_filter('script_loader_tag', array($this, 'set_scripts_type_module_attribute'), 99, 3);

            add_action('admin_init', array($this, 'disable_comments'));

            // Modifier le logo sur la page de connexion à l'administration
            add_action('login_enqueue_scripts', array($this, 'login_page_custom_logo'));
        }

        /**
         * Set theme supports
         *
         * @return void
         */
        public function theme_setup() {
            add_theme_support('post-thumbnails');
            add_theme_support('title-tag');
            add_theme_support('custom-logo', array(
                'height' => 60,
                'width' => 400,
                'flex-height' => true,
                'flex-width' => true,
                'header-text' => array('site-title', 'site-description'),
            ));
        }

        /**
         * Register menus
         *
         * @return void
         */
        public function register_nav_menus() {
            register_nav_menus(array(
                'main-menu' => __('Main Menu', 'dotstarter'),
                'side-menu' => __('Side Menu', 'dotstarter'),
                'legal-menu' => __('Legal Menu', 'dotstarter'),
            ));
        }

        function login_page_custom_logo() { ?>
            <style type="text/css">
                #login h1 a,
                .login h1 a {
                    background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dot-black.svg');
                }
            </style>
        <?php }


        /**
         * Enqueue front-end styles
         *
         * @return void
         */
        public function enqueue_styles() {
            wp_enqueue_style('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
            wp_enqueue_style('frontend', DOT_THEME_URI . '/dist/css/frontend.min.css', null, filemtime(DOT_THEME_PATH . '/dist/css/frontend.min.css'));
        }

        /**
         * Enqueue admin styles
         *
         * @return void
         */
        public function enqueue_admin_scripts() {
            wp_enqueue_style('dotstarter-admin-css', DOT_THEME_URI . '/dist/css/admin.min.css', array(), @filemtime(DOT_THEME_PATH . '/dist/css/admin.min.css'));
        }


        /**
         * Enqueue front-end scripts
         *
         * @return void
         */
        public function enqueue_scripts() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('detect-autofill', 'https://unpkg.com/detect-autofill/dist/detect-autofill.js', array(), null, true);
            wp_enqueue_script('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);

            wp_enqueue_script('dotstarter-frontend', DOT_THEME_URI . '/dist/js/bundle.min.js', array('jquery', 'detect-autofill'), filemtime(DOT_THEME_PATH . '/dist/js/bundle.min.js'), true);

            if (get_field('gmaps_api_key', 'option')) {
                wp_enqueue_script('google-map', 'https://maps.googleapis.com/maps/api/js?key=' . get_field('gmaps_api_key', 'option'), array(), '3', true);
            }

            // Inject variables from PHP to front-end scripts
            $is_first_visit = acf_maybe_get($_SESSION, '_dot_is_first_visit');
            $args = array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'homeUrl' => home_url(),
                'isLoggedIn' => is_user_logged_in(),
                'nonce' => wp_create_nonce('dot_nonce'),
                'isFirstVisit' => $is_first_visit
            );
            wp_localize_script('dotstarter-frontend', 'ajaxConfig', $args);
        }

        /**
         * Remove Gutenberg default styles
         *
         * @return void
         */
        function remove_wp_block_library_css() {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-block-style'); // REMOVE WOOCOMMERCE BLOCK CSS
            wp_dequeue_style('global-styles'); // REMOVE THEME.JSON
        }

        /**
         * Add new MIME types to file upload whitelist
         *
         * @param $file_types
         * @return array
         */
        public function add_mime_types_to_upload_whitelist($file_types): array {
            $new_filetypes = array();
            $new_filetypes['svg'] = 'image/svg+xml';
            $new_filetypes['webp'] = 'image/webp';

            return array_merge($file_types, $new_filetypes);
        }

        /**
         * Add module type to front-end scripts
         *
         * @param [type] $tag
         * @param [type] $handle
         * @param [type] $src
         * @return void
         */
        public function set_scripts_type_module_attribute($tag, $handle, $src) {
            // if not your script, do nothing and return original $tag

            if (!str_contains($handle, 'dotstarter-frontend')) {
                return $tag;
            }
            // change the script tag by adding type="module" and return it.
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';

            return $tag;
        }

        /**
         * Disable comments
         *
         * @return void
         */
        public function disable_comments() {
            // Close comments on the front-end
            add_filter('comments_open', '__return_false', 20, 2);
            add_filter('pings_open', '__return_false', 20, 2);

            // Hide existing comments
            add_filter('comments_array', '__return_empty_array', 10, 2);

            // Remove comments page in menu
            add_action('admin_menu', function () {
                remove_menu_page('edit-comments.php');
            });

            // Remove comments links from admin bar
            add_action('init', function () {
                if (is_admin_bar_showing()) {
                    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
                }
            });

            // Redirect any user trying to access comments page
            global $pagenow;

            if ($pagenow === 'edit-comments.php') {
                wp_safe_redirect(admin_url());
                exit;
            }

            // Remove comments metabox from dashboard
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

            // Disable support for comments and trackbacks in post types
            foreach (get_post_types() as $post_type) {
                if (post_type_supports($post_type, 'comments')) {
                    remove_post_type_support($post_type, 'comments');
                    remove_post_type_support($post_type, 'trackbacks');
                }
            }
        }

        /**
         * Will indicate which plugins need to be installed on the admin interface
         *
         * @return void
         * @throws Exception
         */
        public function register_required_plugins() {
            $plugins = array(
                // Plug-ins that need licence key
                array(
                    'name' => 'Advanced Custom Fields Pro',
                    'slug' => 'advanced-custom-fields-pro',
                    'required' => true,
                ),
                array(
                    'name' => 'WP Migrate DB Pro',
                    'slug' => 'wp-migrate-db-pro',
                    'required' => true,
                ),

                // Plug-ins from WordPress repository
                array(
                    'name' => 'Classic Editor',
                    'slug' => 'classic-editor',
                    'required' => true,
                ),
                array(
                    'name' => 'Advanced Custom Fields : Extended',
                    'slug' => 'acf-extended',
                    'required' => true,
                ),
                // DotCore
                array(
                    'name' => 'DOT Core',
                    'slug' => 'dotcore',
                    'required' => true,
                ),
            );

            $config = array(
                'id' => 'dotstarter',
                // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',
                // Default absolute path to bundled plugins.
                'menu' => 'tgmpa-install-plugins',
                // Menu slug.
                'parent_slug' => 'themes.php',
                // Parent menu slug.
                'capability' => 'edit_theme_options',
                // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
                'has_notices' => true,
                // Show admin notices or not.
                'dismissable' => true,
                // If false, a user cannot dismiss the nag message.
                'dismiss_msg' => '',
                // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => true,
                // Automatically activate plugins after installation or not.
                'message' => '',
                // Message to output right before the plugins table.
            );

            tgmpa($plugins, $config);
        }
    }
}
