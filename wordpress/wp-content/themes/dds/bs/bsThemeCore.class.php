<?php

class bsThemeCore {
    public function __construct() {

    }

    public function initTheme(){
        Bs\Core::registerTheme('dds', 'bsThemeCore', __DIR__);

        $this->initThemeOptions();
        $this->initScripts();
        $this->initStyles();

        $this->removeEmoji();
        $this->removeDashboardMenus();
    }

    //////////////////////////////////////////////////////////////////////////////
    // Theme init Functions

    public static function getLoadPaths() {
        return ['controllers', 'helpers', 'models'];
    }

    private function initThemeOptions(){

        add_theme_support('post-thumbnails');

        add_theme_support( 'automatic-feed-links' );

        add_theme_support( 'title-tag' );

        add_filter('show_admin_bar', '__return_false');
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ) );

        // menus
        add_theme_support('menus');
        register_nav_menu('menu-principal', '');

        //Bs\Controllers\UserController::activate();
        //if (class_exists('ExporterBase')) {
        //  Bs\Dashboard\ExportDashboard::activate();
        //}

        // limit to dashboard ?
        //Bs\Models\Post::createType();

    }

    private function initScripts(){

        function load_bs_scripts(){
            $urlAssets = get_bloginfo( 'template_url') . '/bs/assets/';

            // JQUERY
            wp_deregister_script('jquery');
            wp_register_script( 'jquery', $urlAssets . 'js/jquery.min.js', array(), '3.2.1', false);
            wp_enqueue_script('jquery');

            wp_deregister_script('swiper');
            wp_register_script( 'swiper', $urlAssets . 'js/plugins/swiper.min.js', array(), '', true);
            wp_enqueue_script('swiper');

            // Plugin + Main script
            /*wp_deregister_script('main');
            wp_register_script('main', $urlAssets . 'js/main.min.js', array('jquery'), '', true);
            wp_enqueue_script('main');*/

            wp_deregister_script('main');
            wp_register_script('main', $urlAssets . 'js/main.js', array('jquery'), '', true);
            wp_enqueue_script('main');

        }
        add_action( 'wp_enqueue_scripts', 'load_bs_scripts' );
    }

    private function initStyles(){

        function load_bs_styles(){

            $urlAssets = get_bloginfo('template_url') . '/bs/assets/';

            // font
            wp_enqueue_style( 'googlefonts', 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700|Montserrat:300,400,400i,500,500i,600,600i|Dancing+Script:400,700|Lato:300,400,700', false ); 
            wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.0.10/css/all.css', false ); 

            // main style minify 
            wp_enqueue_style('bsStyles', $urlAssets . 'css/style.css');
        }

        add_action( 'wp_enqueue_scripts', 'load_bs_styles' );
    }

    private function removeDashboardMenus() {
        add_action('admin_menu', function() {
            //remove_menu_page( 'edit.php' );
            //remove_menu_page( 'edit.php?post_type=page' );
            remove_menu_page( 'edit-comments.php' );
        });
    }

    private function removeEmoji() {
        // Suppression Emoji
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

}

