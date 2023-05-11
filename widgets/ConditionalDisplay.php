<?php

namespace ElementorTedsWidgets\Widgets;

use Elementor\{Controls_Manager, Element_Base, Repeater};

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TedsConditionalDisplay {

    /**
     * Initialize hooks
     */
    public function __construct() {
        add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'register_controls' ] );
        add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'register_controls' ] );
        add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_controls' ] );
        add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'register_controls' ] );
        add_filter( 'elementor/frontend/widget/should_render', [ $this, 'content_render' ], 10, 2 );
        add_filter( 'elementor/frontend/column/should_render', [ $this, 'content_render' ], 10, 2 );
        add_filter( 'elementor/frontend/section/should_render', [ $this, 'content_render' ], 10, 2 );
        add_filter( 'elementor/frontend/container/should_render', [ $this, 'content_render' ], 10, 2 );
    }

    public function register_controls( $element ) {
        $element->start_controls_section(
            'teds_logic_section',
            [
                'label' => __( 'Dynamic Conditional Display', 'elementor-teds-widgets' ),
                'tab'   => Controls_Manager::TAB_ADVANCED
            ]
        );
        $element->add_control(
            'teds_conditional_enable',
            [
                'label'          => __( 'Active l\'affichage conditionnelle', 'elementor-teds-widgets' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => '',
                'label_on'       => __( 'Oui', 'elementor-teds-widgets' ),
                'label_off'      => __( 'Non', 'elementor-teds-widgets' ),
                'return_value'   => 'oui',
                'style_transfer' => false
            ]
        );
        $element->add_control(
            'teds_conditional_visibility_action',
            [
                'label'          => __( 'Action', 'elementor-teds-widgets' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'show'            => [
                        'title' => esc_html__( 'Afficher', 'elementor-teds-widgets' ),
                        'icon'  => 'eaicon-eye-solid',
                    ],
                    'hide'            => [
                        'title' => esc_html__( 'Cacher', 'elementor-teds-widgets' ),
                        'icon'  => 'eaicon-eye-slash-solid',
                    ],
                ],
                'default'        => 'show',
                'toggle'         => false,
                'condition'      => [
                    'teds_conditional_enable' => 'oui',
                ],
                'style_transfer' => false
            ]
        );
        $element->add_control(
            'teds_conditional_action_apply_if',
            [
                'label'          => __( 'Applicable si', 'elementor-teds-widgets' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'all' => [
                        'title' => esc_html__( 'Tout est vrai', 'elementor-teds-widgets' ),
                        'icon'  => 'eaicon-dice-six-solid',
                    ],
                    'any' => [
                        'title' => esc_html__( 'Au moins un est vrai', 'elementor-teds-widgets' ),
                        'icon'  => 'eaicon-dice-one-solid',
                    ],
                ],
                'default'        => 'all',
                'toggle'         => false,
                'condition'      => [
                    'teds_conditional_enable'             => 'oui',
                ],
                'style_transfer' => false
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'logic_type',
            [
                'label'   => __( 'Type', 'elementor-teds-widgets' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post_categories',
                'options' => [
                    'post_categories' => __( 'Catégories d\'article', 'elementor-teds-widgets' ),
                    'post_tags' => __( 'Étiquettes d\'article', 'elementor-teds-widgets' ),
                ],
            ]
        );
        $repeater->add_control(
            'post_minimum',
            [
                'label' => esc_html__( 'Contient au moins N articles', 'elementor-teds-widgets' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
            ]
        );
        $postCategories = get_categories();
        $categories = [];
        foreach ($postCategories as $postCategory) {
            if ('category' !== $postCategory->taxonomy) {
                continue;
            }
            $categories[$postCategory->cat_ID] = $postCategory->name;
        }
        $postTags = get_tags();
        $tags = [];
        foreach ($postTags as $postTag) {
            if ('post_tag' !== $postTag->taxonomy) {
                continue;
            }
            $tags[$postTag->term_taxonomy_id] = $postTag->name;
        }
        $repeater->add_control(
            'post_categories',
            [
                'label'       => esc_html__( 'Sélectionné des catégories', 'elementor-teds-widgets' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $categories,
                'default'     => key( $categories ),
                'multiple'    => true,
                'condition'   => [
                    'logic_type' => 'post_categories',
                ]
            ]
        );
        $repeater->add_control(
            'post_tags',
            [
                'label'       => esc_html__( 'Sélectionné des étiquettes', 'elementor-teds-widgets' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $tags,
                'default'     => key( $tags ),
                'multiple'    => true,
                'condition'   => [
                    'logic_type' => 'post_tags',
                ]
            ]
        );

        $element->add_control(
            'teds_conditional_logics',
            [
                'label'          => __( 'Logiques', 'elementor-teds-widgets' ),
                'type'           => Controls_Manager::REPEATER,
                'fields'         => $repeater->get_controls(),
                'default'        => [
                    [
                        'logic_type' => 'post_categories',
                    ],
                ],
                'style_transfer' => false,
                'title_field'    => '{{{ logic_type }}}',
                'condition'      => [
                    'teds_conditional_enable' => 'oui',
                ]
            ]
        );
        $element->end_controls_section();
    }

    public function content_render( $should_render, Element_Base $element ) {
        $settings = $element->get_settings_for_display();

        if ( $settings['teds_conditional_enable'] === 'oui' ) {
            switch ( $settings['teds_conditional_visibility_action'] ) {
                case 'show':
                    return $this->checkLogics( $settings );
                case 'hide':
                    return !$this->checkLogics($settings);
            }
        }

        return $should_render;
    }

    /**
     * @param $settings
     * @return bool
     */
    public function checkLogics( $settings ): bool
    {
        $return = false;
        $neededAnyLogicTrue = 'any' === $settings['teds_conditional_action_apply_if'];
        $neededAllLogicTrue = 'all' === $settings['teds_conditional_action_apply_if'];

        foreach ( $settings['teds_conditional_logics'] as $conditionalLogic ) {
            switch ( $conditionalLogic['logic_type'] ) {
                case 'post_categories':
                    $return = count(get_posts([
                        $neededAnyLogicTrue ? 'category__in' : 'category__and' => is_array($conditionalLogic['post_categories']) ? $conditionalLogic['post_categories'] : [$conditionalLogic['post_categories']],
                        'numberposts' => $conditionalLogic['post_minimum']
                    ])) >= $conditionalLogic['post_minimum'];

                    if (($neededAnyLogicTrue && $return) || ($neededAllLogicTrue && !$return)) {
                        break(2);
                    }

                    break;
                case 'post_tags':
                    $return = count(get_posts([
                        $neededAnyLogicTrue ? 'tag__in' : 'tag__and' => is_array($conditionalLogic['post_tags']) ? $conditionalLogic['post_tags'] : [$conditionalLogic['post_tags']],
                        'numberposts' => $conditionalLogic['post_minimum']
                    ])) >= $conditionalLogic['post_minimum'];

                    if (($neededAnyLogicTrue && $return) || ($neededAllLogicTrue && !$return)) {
                        break(2);
                    }

                    break;
            }
        }

        return $return;
    }
}
