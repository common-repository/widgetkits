<?php
/**
 * widgetkits Form.
 *
 *
 * @since 1.0.0
 */
namespace Widgetkits\Widgets\Elementor;
use  Elementor\Widget_Base;
use  Elementor\Controls_Manager;
use  Elementor\utils;
use  Elementor\Scheme_Color;
use  Elementor\Group_Control_Typography;
use  Elementor\Scheme_Typography;
use  Elementor\Group_Control_Box_Shadow;
use  Elementor\Group_Control_Background;
use  Elementor\Group_Control_Border;
use  Elementor\Embed;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class WidgetkitsForm extends \Elementor\Widget_Base {
    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'widgetkits-form';
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
    public function get_title()
    {
        return __('Contact Form 7', 'widgetkits');
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
    public function get_icon()
    {
        return 'eicon-mail';
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
    public function get_categories()
    {
        return ['widgetkits'];
    }
    public function get_keywords()
    {
        return ['form', 'contact form', 'subcribe form', 'mailchimp'];
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
            '_section_cf7',
            [
                'label' => widgetkits_is_cf7_activated() ? __( 'Contact Form 7', 'widgetkits' ) : __( 'Notice', 'widgetkits' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        if ( ! widgetkits_is_cf7_activated() ) {
            $this->add_control(
                'cf7_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        __( 'Hi, it seems %1$s is missing in your site. Please install and activate %1$s first.', 'Exeter' ),
                        '<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank" rel="noopener">Contact Form 7</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                ]
            );
            $this->end_controls_section();
            return;
        }
        $this->add_control(
            'widgetkits_form_ts',
            [    
                'label'    => __( 'Form List Or ShortCode', 'widgetkits' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'formlist',
                'options'  => [
                    'formlist'   =>   __('Form List', 'widgetkits'),
                    'shortcode'  =>   __('Form ShortCode', 'widgetkits'),
                ],
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'form_id',
            [
                'label' => __( 'Select Your Form', 'widgetkits' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => ['' => __( '', 'widgetkits' ) ] + \widgetkits_get_cf7_forms(),
                'condition' => [
                    'widgetkits_form_ts' => 'formlist'
                ],
            ]
        );
        $this->add_control(
            'contactform_shortecode',
            [    
                'label'    => __( 'Enter your shortcode', 'widgetkits' ),
                'type'     => Controls_Manager::TEXTAREA,
                'separator' => 'after',
                'condition' => [
                    'widgetkits_form_ts' => 'shortcode'
                ],
            ]
        );
        $this->end_controls_section();

        //form fields style
        $this->start_controls_section(
            '_section_fields_style',
            [
                'label' => __( 'Fields', 'widgetkits' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => __( 'Typography', 'widgetkits' ),
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3
            ]
        );
         //field focus
        $this->start_controls_tabs( 'tabs_field_state' );
        $this->start_controls_tab(
            'tab_field_normal',
            [
                'label' => __( 'Normal', 'widgetkits' ),
            ]
        );
        $this->add_control(
            'field_color',
            [
                'label' => __( 'Text Color', 'widgetkits' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'field_color_response',
            [
                'label' => __( 'Response Output Color', 'widgetkits' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-response-output' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'field_placeholder_color',
            [
                'label' => __( 'Placeholder Text Color', 'widgetkits' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'field_bg_color',
            [
                'label' => __( 'Background Color', 'widgetkits' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_box_shadow',
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
            ]
        );
        $this->end_controls_tab();
        //f
        $this->start_controls_tab(
            'tab_field_focus',
            [
                'label' => __( 'Focus', 'widgetkits' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_focus_border',
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_focus_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
            ]
        );
        $this->add_control(
            'field_focus_bg_color',
            [
                'label' => __( 'Background Color', 'widgetkits' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'hr_one',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
            'popover-toggle',
            [
                'label' => __( 'Field advanced option', 'widgetkits' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'Default', 'widgetkits' ),
                'label_on' => __( 'Custom', 'widgetkits' ),
                'return_value' => 'yes',
            ]
        );
        
        
        $this->start_popover();

        $this->add_responsive_control(
            'wpcf7_field_height',
            [
                'label' => __( 'Fields Height', 'widgetkits' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'wpcf7_textarea_field_height',
            [
                'label' => __( 'Textarea Height', 'widgetkits' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} textarea.wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'field_width',
            [
                'label' => __( 'Width', 'widgetkits' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form  label' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'field_margin',
            [
                'label' => __( 'Spacing Between', 'widgetkits' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'field_padding',
            [
                'label' => __( 'Padding', 'widgetkits' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    'body.rtl {{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}; !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'field_border_radius',
            [
                'label' => __( 'Border Radius', 'widgetkits' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->end_controls_section();

        //start button label style
        $this->start_controls_section(
            'cf7-form-label',
            [
                'label' => __( 'Label', 'widgetkits' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'label_margin',
            [
                'label' => __( 'Spacing Bottom', 'widgetkits' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hr3',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => __( 'Typography', 'widgetkits' ),
                'selector' => '{{WRAPPER}} label',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __( 'Text Color', 'widgetkits' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();


        //start button 
        $this->start_controls_section(
            'section_layout_button',
            [
                'label' => __( 'Button', 'widgetkits' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'form_button_position',
            [    
                'label'             => __( 'Position', 'widgetkits' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'default',
                'options'           => [
                    'default'    =>   __('Default',    'widgetkits'),
                    'absolute'   =>  __('Absolute',    'widgetkits'),
                ],
                'separator' => 'after',
            ]
        );
        $this->add_responsive_control(
            'widgetkits_offset_x_end',
            [
                'label' => __( 'Offset X', 'widgetkits' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => '0',
                ],
                'size_units' => [ 'px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits--contactform-wraper.absolute [type=submit]' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'form_button_position' => 'absolute',
                ],
            ]
        );
        $this->add_responsive_control(
            'widgetkits_offset_y',
            [
                'label' => __( 'Offset Y', 'widgetkits' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => [ 'px', '%'],
                'default' => [
                    'size' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits--contactform-wraper.absolute [type=submit]' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'form_button_position' => 'absolute',
                ],
            ]
        );
        $this->add_control(
            'hr_there',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        // Button Position End
        $this->start_controls_tabs(
            'form_button_normals'
        );
        $this->start_controls_tab(
            'form_button_normal',
            [
                'label' => __('Normal', 'widgetkits'),
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Background Color', 'widgetkits' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_color',
            [
                'label' => __( 'Button Text Color', 'widgetkits' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Border', 'widgetkits'),
                'selector' => '{{WRAPPER}} .widgetkits-contact-from [type=submit]',
            ]
        ); 
        $this->end_controls_tab();

        //end normal tab
        $this->start_controls_tab(
            'form_button_hover',
            [
                'label' => __('Hover', 'widgetkits'),
            ]
        );
        $this->add_control(
            'button_hover',
            [
                'label' => __( 'Background Color Hover', 'widgetkits' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover',
            [
                'label' => __( 'Text Color Hover', 'widgetkits' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => __('Border', 'widgetkits'),
                'selector' => '{{WRAPPER}} .widgetkits-contact-from [type=submit]:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_text',
                'label'    => __('Typography', 'widgetkits'),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .widgetkits-contact-from [type=submit]',
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => __('Width', 'widgetkits'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_height',
            [
                'label' => __('Height', 'widgetkits'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_margin',
            [
                'label' => __('Margin', 'widgetkits'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'widgetkits'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .widgetkits-contact-from [type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        //button end


        //Form Box
        $this->start_controls_section(
            '_form_box_style',
            [
                'label' => __( 'Box', 'widgetkits' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'form_box_align',
            [
                'label' => __('Align', 'widgetkits'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'widgetkits'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'widgetkits'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'widgetkits'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from' => 'text-align: {{VALUE}};',
                ],
                'toggle' => true,
            ]
        );
        $this->add_control(
            'form_box_bg',
            [
                'label' => __( 'Background', 'widgetkits' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'selector' => '{{WRAPPER}} .widgetkits-contact-from',
            ]
        );
        
        $this->add_responsive_control(
            'form_box_padding',
            [
                'label' => __( 'Padding', 'widgetkits' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .widgetkits-contact-from' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'form_box_border_redius',
            [
                'label' => __( 'Border Radius', 'widgetkits' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-contact-from' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .widgetkits-contact-from' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
    protected function render()
    {
        if ( ! widgetkits_is_cf7_activated() ) {
                return;
        }
        $settings = $this->get_settings();
        $widgetkits_form_sl  = $settings['widgetkits_form_ts'];
        $widgetkits_form_id  = $settings['form_id'];
        $widgetkits_form_bp  = $settings['form_button_position'];
        $widgetkits_contactform_shortecode = $settings['contactform_shortecode'];
        ?>
        
        <?php if ( ! empty( $widgetkits_form_id  && $widgetkits_form_sl == 'formlist') ): 
        ?>
        <div class="widgetkits--contactform-wraper <?php echo esc_attr( $widgetkits_form_bp ) ?> widgetkits-contact-from ">
            <?php
                echo widgetkits_do_shortcode( 'contact-form-7', [
                'id' => $settings['form_id'],
            ] );
            ?>
        </div>
        <?php
        elseif ($widgetkits_form_sl == 'shortcode'): 
            ?>
            <div class="widgetkits--contactform-wraper <?php echo esc_attr( $widgetkits_form_bp ) ?> widgetkits-contact-from">
                <?php echo widgetkits_get_meta($widgetkits_contactform_shortecode);  ?>
            </div>
            <?php
        endif; 
    }
}
$widgets_manager->register_widget_type( new \Widgetkits\Widgets\Elementor\WidgetkitsForm() );