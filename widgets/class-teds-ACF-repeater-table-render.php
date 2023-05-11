<?php
/**
 * TedsUser class.
 *
 * @category   Class
 * @package    TedsACFRepeaterRender
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
class TedsACFRepeaterTableRender extends Widget_Base {
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
		return 'TedsACFrepeaterrender';
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
		return __( 'Tableau ACF répéteur ', 'elementor-teds-widgets' );
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
		return 'eicon-table';
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
	protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Contenu', 'elementor-teds-widgets' ),
            ]
        );
        $this->add_control(
            'field_name',
            [
                'label' => esc_html__( 'Nom du champ dans lequel récupérer les données', 'elementor-teds-widgets' ),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'th_name',
            [
                'label' => esc_html__( 'Nom', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'th_list',
            [
                'label' => esc_html__( 'Liste des en-têtes', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ th_name }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_content_section',
            [
                'label' => esc_html__( 'Style des lignes', 'text-domain' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'th-color',
            [
                'label' => esc_html__( 'Couleur du texte des en-têtes', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} th' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'th-alignment',
            [
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label' => esc_html__( 'Alignement des en-têtes', 'text-domain' ),
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'text-domain' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'text-domain' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'text-domain' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} th' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Police des en-têtes', 'textdomain' ),
                'name' => 'th-typography',
                'selector' => '{{WRAPPER}} th',
            ]
        );
        $this->add_control(
            'tr-color',
            [
                'label' => esc_html__( 'Couleur du texte des lignes', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} tr' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'tr-alignment',
            [
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label' => esc_html__( 'Alignement des ligne', 'text-domain' ),
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'text-domain' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'text-domain' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'text-domain' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} tr' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Police des en-lignes', 'textdomain' ),
                'name' => 'tr-typography',
                'selector' => '{{WRAPPER}} tr',
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
        global $wpdb;
        global $post;
        $settings = $this->get_settings_for_display();
        if (!$settings['field_name']) {
            return;
        }
        $results = $wpdb->get_results("SELECT `meta_key`, `meta_value` FROM $wpdb->postmeta WHERE meta_key LIKE '" . $settings['field_name'] . "%' AND meta_key != '" . $settings['field_name'] . "' AND post_id = " . $post->ID . " ORDER BY meta_id ASC");
        if (!count($results)) {
            return;
        }
        $numbers = [];
        $fields = [];
        $formattedResults = [];
        foreach ($results as $result) {
            $match = '';
            preg_match('/\d+/', $result->meta_key, $match);
            $numbers[] = $match[0];
            $fields[] = str_replace($settings['field_name'] . '_' . $match[0], '', $result->meta_key);
            $formattedResults[$result->meta_key] = $result->meta_value;
        }
        $rows = array_unique($numbers);
        $fields = array_unique($fields);

        echo '<table>';
        foreach ($settings['th_list'] as $item) {
            if (isset($item['th_name'])) {
                echo '<th>' . $item['th_name'] . '</th>';
            }
        }

        foreach ($rows as $row) {
            echo '<tr>';
            foreach ($fields as $field) {
                echo '<td>' . $formattedResults[$settings['field_name'] . '_' . $row . $field] . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
	}
}
