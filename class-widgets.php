<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    ElementorTedsWidgets
 * @subpackage WordPress
 * @author     Julien Milazzo <julien@teds.fr>
 * @copyright  2023 Teds
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://teds.fr/)
 * @since      1.0.0
 * php version 8.0.13
 */

namespace ElementorTedsWidgets;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Widgets {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once 'widgets/class-tedsjssearchinpage.php';
        require_once 'widgets/class-teds-link-with-icon-full-width.php';
        require_once 'widgets/class-teds-ACF-repeater-table-render.php';
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// It's now safe to include Widgets files.
		$this->include_widgets_files();

		// Register the plugin widget classes.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\TedsJsSearchInPage() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\TedsLinkWithIconFullWidth() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\TedsACFRepeaterTableRender() );
        // widget link personnalisable
	}

    /**
     * Register scripts and styles for Elementor test widgets.
     */
    function elementor_teds_widgets_dependencies() {
        /* Styles */
        wp_register_style( 'teds-js-search-in-page-style', plugins_url( 'assets/css/teds-js-search-in-page.css', __FILE__ ) );
        wp_register_style( 'teds-link-with-icon-full-width', plugins_url( 'assets/css/teds-link-with-icon-full-width.css', __FILE__ ) );

        /* Scripts */
        wp_register_script( 'teds-js-search-in-page-script', plugins_url( 'assets/js/teds-js-search-in-page.js', __FILE__ ) );
    }

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Register the widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'elementor_teds_widgets_dependencies' ) );
	}
}

// Instantiate the Widgets class.
Widgets::instance();
