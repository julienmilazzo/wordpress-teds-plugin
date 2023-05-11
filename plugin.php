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

/**
 * Include the classes.
 */
require plugin_dir_path(PLUGIN_TEDS) . 'class-elementor-teds-widgets.php';
require plugin_dir_path(PLUGIN_TEDS) . 'widgets/ConditionalDisplay.php';
new \ElementorTedsWidgets\Widgets\TedsConditionalDisplay();
