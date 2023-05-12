<?php
/**
 * TedsUser class.
 *
 * @category   Class
 * @package    TedsACFRepeaterListRender
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
defined('ABSPATH') || die();

/**
 * TedsUser widget class.
 *
 * @since 1.0.0
 */
class TedsACFRepeaterListRender extends Widget_Base
{
    /**
     * Class constructor.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
    }

    /**
     * Retrieve the widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_name()
    {
        return 'TedsACFRepeaterListRender';
    }

    /**
     * Retrieve the widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_title()
    {
        return __('Liste ACF répéteur ', 'elementor-teds-widgets');
    }

    /**
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-editor-list-ul';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @return array Widget categories.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_categories()
    {
        return array('general');
    }

    /**
     * Enqueue scripts.
     */
    public function get_script_depends()
    {
        return [];
    }

    /**
     * Enqueue styles.
     */
    public function get_style_depends()
    {
        return [];
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
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Contenu', 'elementor-teds-widgets'),
            ]
        );
        $this->add_control(
            'field_name',
            [
                'label' => esc_html__('Nom du champ dans lequel récupérer les données', 'elementor-teds-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'show_title_list',
            [
                'label' => esc_html__('Afficher le titre de la liste', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'textdomain'),
                'label_off' => esc_html__('Hide', 'textdomain'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'title_list',
            [
                'label' => esc_html__('Titre de la liste', 'text-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'textdomain'),
                'condition' => [
                    'show_title_list' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'show_before_list',
            [
                'label' => esc_html__('Ajouter un élément avant les items', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'textdomain'),
                'label_off' => esc_html__('No', 'textdomain'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'before_list',
            [
                'label' => esc_html__('Ajouter un élément avant', 'text-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('-', 'textdomain'),
                'condition' => [
                    'show_before_list' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_content_section',
            [
                'label' => esc_html__( 'Style de liste', 'text-domain' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Couleur du titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} h2' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title_list' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_title_typographie',
                'label' => esc_html__( 'Typographie du titre', 'textdomain' ),
                'selector' => '{{WRAPPER}} h2',
                'condition' => [
                    'show_title_list' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'list_color',
            [
                'label' => esc_html__( 'Couleur des éléments de la liste', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} li' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_list_typographie',
                'label' => esc_html__( 'Typographie des éléments de la liste', 'textdomain' ),
                'selector' => '{{WRAPPER}} li',
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
    protected function render()
    {
        global $wpdb;
        global $post;
        $settings = $this->get_settings_for_display();
        if (!$settings['field_name']) {
            return;
        }

        // Va chercher la liste des "ingrédients" (champs ACF défini sois-même) avec "rien" au début et "quelque chose" à la suite
        $results = $wpdb->get_results("SELECT `meta_key`, `meta_value` FROM $wpdb->postmeta WHERE meta_key LIKE '" . $settings['field_name'] . "%' AND meta_key != '" . $settings['field_name'] . "' AND post_id = " . $post->ID . " ORDER BY meta_id ASC");
        if (!count($results)) {
            return;
        }
        // Affiche le titre uniquement s'il y a du contenu dans "ingrédients"
        if ('yes' === $settings['show_title_list']) {
            echo '<h2>' . $settings['title_list'] . '</h2>';
        }
        // Affiche le resultat pour chaque élément
        foreach ($results as $result) {
              echo '<ul style="padding-left: 0">
                        <li style="list-style: none"><span>'. $settings['before_list'] .'</span>'. $result->meta_value .'</li>
                    </ul>';
        }
    }
}
