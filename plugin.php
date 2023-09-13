<?php
set_time_limit(120);

/**
 * Plugin Name: Teds
 * Plugin URI: https://teds.fr/
 * Description: Teds plugin.
 * Version: 0.1
 * Author: Julien Milazzo
 * Author URI: https://teds.fr/
 **/

class Teds
{
    public function __construct()
    {
        add_action( 'admin_menu', [ $this, 'teds_admin_menu'] );
    }

    public function teds_admin_menu()
    {
        add_menu_page(
            __('Plugin Teds', 'Teds'), // Page title
            __('Teds', 'Teds'), // Menu title
            'manage_options',  // Capability
            'teds', // Slug
            [ &$this, 'teds_load_plugin_page'], // Callback page function
            '/wp-content/uploads/2023/05/logo-teds-min.png'
        );
    }

    public function teds_load_plugin_page()
    {
        echo '<h1>' . __( 'Teds', 'Teds' ) . '</h1>';
        echo '<p>' . __( 'Configuration plugin Teds', 'Teds' ) . '</p>';
    }
}

new Teds();

define( 'PLUGIN_TEDS', __FILE__ );



define( 'ELEMENTOR_TEDS_TALENSOFT', __FILE__ );

/**
 * Register List Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_list_widget( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/class-tedsjssearchinpage.php');
    require_once( __DIR__ . '/widgets/class-teds-link-with-icon-full-width.php');
    require_once( __DIR__ . '/widgets/class-teds-ACF-repeater-table-render.php');

    // Register the plugin widget classes.
    $widgets_manager->register( TedsJsSearchInPage() );
    $widgets_manager->register( TedsLinkWithIconFullWidth() );
    $widgets_manager->register( TedsACFRepeaterTableRender() );
}
add_action( 'elementor/widgets/register', 'register_list_widget' );


/**
 * Register scripts and styles for Elementor test widgets.
 */
function elementor_widgets_dependencies() {
    /* Styles */
    wp_register_style( 'teds-js-search-in-page-style', plugins_url( 'assets/css/teds-js-search-in-page.css', __FILE__ ) );
    wp_register_style( 'teds-link-with-icon-full-width', plugins_url( 'assets/css/teds-link-with-icon-full-width.css', __FILE__ ) );

    /* Scripts */
    wp_register_script( 'teds-js-search-in-page-script', plugins_url( 'assets/js/teds-js-search-in-page.js', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'elementor_widgets_dependencies' );

/**
 * Include the classes.
 */
require plugin_dir_path(PLUGIN_TEDS) . 'class-elementor-teds-widgets.php';
require plugin_dir_path(PLUGIN_TEDS) . 'widgets/ConditionalDisplay.php';

new \ElementorTedsWidgets\Widgets\TedsConditionalDisplay();
