<?php
/**
 * TedsUser class.
 *
 * @category   Class
 * @package    ElementorTedsJsSearchInPage
 * @subpackage WordPress
 * @author     Julien Milazzo <julien@teds.fr>
 * @copyright  2023 Teds
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://teds.fr/)
 * @since      1.0.0
 * php version 8.0.13
 */

namespace ElementorTedsWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * TedsUser widget class.
 *
 * @since 1.0.0
 */
class TedsJsSearchInPage extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tedsjssearchinpage';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Moteur de recherche live', 'elementor-teds-widgets' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-search';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}

    /**
     * Enqueue scripts.
     */
    public function get_script_depends() {
        return ['teds-js-search-in-page-script'];
    }

    /**
     * Enqueue styles.
     */
    public function get_style_depends() {
        return ['teds-js-search-in-page-style'];
    }

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Global', 'text-domain' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'search_class',
            [
                'label' => esc_html__( 'Classe CSS dans laquelle chercher', 'text-domain' ),
                'description' => esc_html__( 'La classe CSS de l\'élément dans laquelle la recherche sera effectuée.', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'search_display_class',
            [
                'label' => esc_html__( 'Classe CSS qui gère l\'affichage ou non', 'text-domain' ),
                'description' => esc_html__( 'La classe CSS qui va gérer l\'affichage de l\'élément trouver ou non lors de la recherche.', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'search_placeholder',
            [
                'label' => esc_html__( 'Texte par défaut du champ de recherche', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Rechercher...'
            ]
        );
        $this->add_control(
            'live_search',
            [
                'label' => esc_html__( 'Activer la recherche live', 'text-domain' ),
                'description' => esc_html__( 'Si vous activez ce paramètre, la recherche se fera lors de la saisie direct du texte sans avoir besoin de valider la recherche.', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'live_search_key',
            [
                'label' => esc_html__( 'Nombre de caractère pour la recherche live', 'text-domain' ),
                'description' => esc_html__( 'Nombre de caractères avant que la recherche live soit exécutée.', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 3,
                'condition' => [
                    'live_search' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icône pour valider la recherche', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_content_section',
            [
                'label' => esc_html__( 'Style du champ de recherche', 'text-domain' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color',
            [
                'label' => esc_html__( 'Couleur du texte', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .teds-search-field, {{WRAPPER}} .teds-search-field::placeholder' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color-field',
            [
                'label' => esc_html__( 'Couleur du champ', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .teds-search-field' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon-color',
            [
                'label' => esc_html__( 'Couleur de l\'icône', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .search-button, {{WRAPPER}} .reset-button' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon-size',
            [
                'label' => esc_html__( 'Taille de l\'icône', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-button, {{WRAPPER}} .reset-button' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();
        echo '<div class="teds-search-wrapper" data-search-class="' . $settings['search_class'] . '" data-search-display-class="' . $settings['search_display_class'] . '" data-live-search="' . $settings['live_search'] . '" data-live-search-key="' . $settings['live_search_key'] . '">';
            echo '<input type="text" class="teds-search-field" placeholder="' . $settings['search_placeholder'] . '" />';
            echo '<i class="fas fa-times reset-button" style="display: none"></i>';
            if ($settings['icon']['value']) {
                \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true', 'class' => 'search-button']);
            } else {
                echo '<i class="fa fa-search search-button"></i>';
            }
        echo '</div>';
	}
}
