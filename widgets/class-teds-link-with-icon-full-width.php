<?php
/**
 * TedsUser class.
 *
 * @category   Class
 * @package    TedsLinkWithIconFullWidth
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
class TedsLinkWithIconFullWidth extends Widget_Base {
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
		return 'tedslinkwithiconfullwidth';
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
		return __( 'Lien avec icône pleine largeur', 'elementor-teds-widgets' );
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
		return 'eicon-link';
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
        return [];
    }

    /**
     * Enqueue styles.
     */
    public function get_style_depends() {
        return ['teds-link-with-icon-full-width'];
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
                'label' => esc_html__( 'Contenu', 'elementor-teds-widgets' ),
            ]
        );
        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Lien', 'elementor-teds-widgets' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'elementor-teds-widgets' ),
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icône', 'elementor-teds-widgets' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ]
            ]
        );
        $this->add_control(
            'text',
            [
                'label' => esc_html__( 'Texte', 'elementor-teds-widgets' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Voir plus', 'elementor-teds-widgets' ),
            ]
        );
        $this->add_control(
            'content_positon',
            [
                'label' => esc_html__( 'Position de l\'icône', 'elementor-teds-widgets' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => esc_html__( 'Droite', 'elementor-teds-widgets' ),
                    'left' => esc_html__( 'Gauche', 'elementor-teds-widgets' ),
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'elementor-teds-widgets' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} .teds-link-with-icon-full-width',
            ]
        );
        $this->add_control(
            'font-color',
            [
                'label' => esc_html__( 'Couleur du texte', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .teds-link-with-icon-full-width__text' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon-color',
            [
                'label' => esc_html__( 'Couleur de l\'icône', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .icon-link' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg-color',
            [
                'label' => esc_html__( 'Couleur du fond', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .teds-link-with-icon-full-width' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'padding',
            [
                'label' => esc_html__( 'Marges internes du lien', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .teds-link-with-icon-full-width' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .teds-link-with-icon-full-width',
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
        $link = $settings['link'];
        $text = $settings['text'];

        echo '<a href="' . $link['url'] . '" class="teds-link-with-icon-full-width">';
            echo '<span class="teds-link-with-icon-full-width__text' . (('left' === $settings['content_positon']) ? ' order-2' : ' order-1') . '">' . $text . '</span>';
            \Elementor\Icons_Manager::render_icon(
                $settings['icon'],
                ['aria-hidden' => 'true', 'class' => 'icon-link' . (('right' === $settings['content_positon']) ? ' order-2' : ' order-1')]);
        echo '</a>';
	}
}
