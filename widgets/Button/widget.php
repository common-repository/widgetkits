<?php
/**
 * Button Widget.
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
use  Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widgetkits_Button extends \Elementor\Widget_Base {

	public function get_name() {
		return 'widgetkits_btutton';
	}
	
	public function get_title() {
		return __( 'Button', 'widgetkits' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'widgetkits' ];
	}

    public function get_keywords()
    {
        return ['btn', 'button', 'link', 'widgetkit'];
    }

	protected function _register_controls() {

		$this->start_controls_section('content_section',
			[
				'label' => __( 'Butoon', 'widgetkits' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control('button_text',
			[
				'label' => __( 'Button Text', 'widgetkits' ),
				'type' => Controls_Manager::TEXT,
                'dynamic'    => [ 'active' => true ],
				'placeholder' => __( 'Button Text', 'widgetkits' ),
				'default' => __( 'Awsome Button', 'widgetkits' ),
				'label_block' => true,
			]
		);

       $this->add_control('widgetkits_button_link_selection', 
        [
            'label'         => __('Link Type', 'widgetkits'),
            'type'          => Controls_Manager::SELECT,
            'options'       => [
                'url'   => __('URL', 'premium-addons-for-elementor'),
                'link'  => __('Existing Page', 'widgetkits'),
            ],
            'default'       => 'url',
            'label_block'   => true,
        ]
        );
       $this->add_control('widgetkits_button_link',
            [
                'label'         => __('Link', 'widgetkits'),
                'type'          => Controls_Manager::URL,
                'default'       => [
                    'url'   => '#',
                    'is_external' => '',
                ],
                'show_external' => true,
                'placeholder'   => 'https://yourdomin.com/',
                'label_block'   => true,
                'condition'     => [
                    'widgetkits_button_link_selection' => 'url'
                ]
            ]
        );
        $this->add_control('widgetkits_button_existing_link',
            [
                'label'         => __('Existing Page', 'widgetkits'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => widgetkits_get_all_pages(),
                'condition'     => [
                    'widgetkits_button_link_selection'     => 'link',
                ],
                'multiple'      => false,
                'separator'     => 'after',
                'label_block'   => true,
            ]
        );

        $this->add_responsive_control('widgetkits_button_align',
			[
				'label'             => __( 'Alignment', 'widgetkits' ),
				'type'              => Controls_Manager::CHOOSE,
				'options'           => [
					'left'    => [
						'title' => __( 'Left', 'widgetkits' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'widgetkits' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'widgetkits' ),
						'icon'  => 'fa fa-align-right',
					],
				],
                'selectors'         => [
                    '{{WRAPPER}} .sb_wraper' => 'text-align: {{VALUE}}',
                ],
				'default' => 'left',
			]
		);
		$this->add_control('widgetkits_button_size', 
        	[
            'label'         => __('Size', 'widgetkits'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'lg',
            'options'       => [
                    'sm'        => __('Small', 'widgetkits'),
                    'md'        => __('Regular', 'widgetkits'),
                    'lg'        => __('Large', 'widgetkits'),
                    'ex'        => __('Extra Large', 'widgetkits'),
                    'block'     => __('Block', 'widgetkits'),
                ],
            'label_block'   => true,
            'separator'     => 'after',
            ]
        );

        $this->add_control('widgetkits_icon_switcher',
	        [
	            'label'         => __('Icon', 'widgetkits'),
	            'type'          => Controls_Manager::SWITCHER,
	            'description'   => __('Enable or disable button icon','widgetkits'),
	        ]
        );

		$this->add_control(
			'widgetkits_button_icon',
			[
				'label' => __( 'Icon', 'widgetkits' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition'     => [
                    'widgetkits_icon_switcher'  => 'yes'
                ],
			]
		);
		$this->add_control(
            'widgetkits_button_icon_position',
            [
                'label' => __( 'Icon Position', 'widgetkits' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'before' => [
                        'title' => __( 'Before', 'widgetkits' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'after' => [
                        'title' => __( 'After', 'widgetkits' ),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'toggle' => false,
                'default' => 'after',
                'condition' => [
                    'widgetkits_icon_switcher' => 'yes',
                    'widgetkits_button_icon!' => ''
                ]
            ]
        );

        $this->add_control(
			'button_css_id',
			[
				'label' => __( 'Button ID', 'widgetkits' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'widgetkits' ),
				'label_block' => false,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'themepaw-companion' ),
				'separator' => 'before',

			]
		);
		$this->end_controls_section();
		// End Content Section




		/*
		*Button Icon Style
		*/
		$this->start_controls_section(
            'icon_style',
            [
                'label' => __('Icon', 'widgetkits'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'widgetkits_icon_switcher' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'widgetkits'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
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
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-btn-cion i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .widgetkits-btn-cion svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_gap',
            [
                'label' => __('Icon gap', 'widgetkits'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-btn-cion .icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .widgetkits-btn-cion .icon-after ' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //icon hover

        //btn normal hover style
        $this->start_controls_tabs(
            'icon_style_tabs'
        );
        // normal
        $this->start_controls_tab(
            'icon_normal',
            [
                'label' => __('Normal', 'widgetkits'),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'widgetkits'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-btn-cion i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .widgetkits-btn-cion path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_stroke_color',
            [
                'label' => __('Icon Stroke Color', 'widgetkits'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-btn-cion i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .widgetkits-btn-cion path' => 'stroke: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_tab();

        // hover
        $this->start_controls_tab(
            'icon_hover',
            [
                'label' => __('Hover', 'widgetkits'),
            ]
        );

        $this->add_control(
            'hover_icon_color',
            [
                'label' => __('Icon Color', 'widgetkits'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-button:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .widgetkits-button:hover path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_icon_color_stock_hover',
            [
                'label' => __('Icon Stroke Color', 'widgetkits'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .widgetkits-button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .widgetkits-button:hover path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

		/*
		*Button Style
		*/
		$this->start_controls_section('style_section',
			[
				'label' => __( 'Button Style', 'widgetkits' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]

		);
        $this->add_control('button_gradient_background',
	        [
	            'label'         => __('Gradient Opction', 'widgetkits'),
	            'type'          => Controls_Manager::SWITCHER,
	            'description'   => __('Use Gradient Background','widgetkits'),
	        ]
        );
		$this->start_controls_tabs('button_style_tabs');

		//Button Tab Normal Start
		$this->start_controls_tab('style_normal_tab',
			[
				'label' => __( 'Normal', 'widgetkits' ),
			]
		);	
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'widgetkits_button_typo_normal',
                'scheme'            => Scheme_Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .widgetkits-button',

            ]
        );
		$this->add_control(
			'color',
			[
				'label' => __( 'Text Color', 'widgetkits' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1D263A',
				'selectors' => [
					'{{WRAPPER}} .widgetkits-button' => 'color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'widgetkits_button_gradient_background_normal',
				'types' => [ 'gradient', 'classic' ],
				'selector' => '{{WRAPPER}} .widgetkits-button',
				'condition' => [
					'button_gradient_background' => 'yes'
				],
			]
		);
		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background', 'widgetkits' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFCD28',
				'selectors' => [
					'{{WRAPPER}} .widgetkits-button,
					 {{WRAPPER}} .widgetkits-button.widgetkits-button-style2-shutinhor:before,
					 {{WRAPPER}} .widgetkits-button.widgetkits-button-style2-shutinver:before,
					 {{WRAPPER}} .widgetkits-button.widgetkits-button-style3-radialin:before,
					 {{WRAPPER}} .widgetkits-button.widgetkits-button-style3-rectin:before'   => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'button_gradient_background!' => 'yes'
				],
			]
		);
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),[
				'name' => 'button_box_shadow',
				'label' => __( 'Box Shadow', 'widgetkits' ),
				'selector' => '{{WRAPPER}} .widgetkits-button',
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'border_normal',
                'selector'      => '{{WRAPPER}} .widgetkits-button',
            ]

        );
        $this->add_control('border_radius_normal',
            [
                'label'         => __('Border Radius', 'widgetkits'),
                'type'          => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .widgetkits-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
		$this->add_responsive_control('padding',
			[
				'label' => __( 'Padding', 'widgetkits' ),
				'type' => Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'size_units'    => ['px', 'em', '%'],
	            'selectors'     => [
	                '{{WRAPPER}} .widgetkits-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ]
				
			]
		);
		$this->add_responsive_control('margin',
			[
				'label' => __( 'Margin', 'widgetkits' ),
				'type' => Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'size_units'    => ['px', 'em', '%'],
	            'selectors'     => [
	                '{{WRAPPER}} .widgetkits-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ]
				
			]
		);
		$this->end_controls_tab();
		// Button Tab Normal End
		
		//Button Tab Hover Start
		$this->start_controls_tab('style_hover_tab',
			[
				'label' => __( 'Hover', 'widgetkits' ),
			]
		);
        

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'widgetkits_button_typo_hover',
                'scheme'            => Scheme_Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .widgetkits-button:hover',

            ]
        );
		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'widgetkits' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .widgetkits-button:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'widgetkits_button_gradient_background_hover',
				'types' => [ 'gradient', 'classic' ],
				'selector' => '{{WRAPPER}} .widgetkits-button:hover',
				'condition' => [
					'button_gradient_background' => 'yes'
				],
			]
		);
		$this->add_control(
			'background_hover_color',
			[
				'label' => __( 'Background', 'widgetkits' ),
				'type' => Controls_Manager::COLOR,
				'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3
                ],
				'default' => '#222831',
				'selectors' => ['
					{{WRAPPER}} .widgetkits-button-none:hover,
					{{WRAPPER}} .widgetkits-button-style1-top:before,
					{{WRAPPER}} .widgetkits-button-style1-right:before,
					{{WRAPPER}} .widgetkits-button-style1-bottom:before,
					{{WRAPPER}} .widgetkits-button-style1-left:before,
					{{WRAPPER}} .widgetkits-button-style2-shutouthor:before,
					{{WRAPPER}} .widgetkits-button-style2-shutoutver:before,
					{{WRAPPER}} .widgetkits-button-style2-shutinhor,
					{{WRAPPER}} .widgetkits-button-style2-shutinver,
					{{WRAPPER}} .widgetkits-button-style2-dshutinhor:before,
					{{WRAPPER}} .widgetkits-button-style2-dshutinver:before,
					{{WRAPPER}} .widgetkits-button-style2-scshutouthor:before,
					{{WRAPPER}} .widgetkits-button-style2-scshutoutver:before,
					{{WRAPPER}} .widgetkits-button-style3-radialin,
					{{WRAPPER}} .widgetkits-button-style3-radialout:before,
					{{WRAPPER}} .widgetkits-button-style3-rectin:before,
					{{WRAPPER}} .widgetkits-button-style3-rectout:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'button_gradient_background!' => 'yes'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .widgetkits-button:hover',
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'border_hover',
                'selector'      => '{{WRAPPER}} .widgetkits-button:hover',
            ]
        );

        
        //Animation Hover
        $this->add_control('widgetkits_button_hover_effect', 
            [
                'label'         => __('Hover Effect', 'widgetkits'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'none',
                'options'       => [
                    'none'          => __('None', 'widgetkits'),
                    'style1'        => __('Slide', 'widgetkits'),
                    'style2'        => __('Shutter', 'widgetkits'),
                    'style3'        => __('In & Out', 'widgetkits'),
                ],
                'label_block'   => true,
            ]
        );
		$this->add_control('widgetkits_button_style1_dir', 
        [
            'label'         => __('Slide Direction', 'widgetkits'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'bottom',
            'options'       => [
                'bottom'       => __('Top to Bottom', 'widgetkits'),
                'top'          => __('Bottom to Top', 'widgetkits'),
                'left'         => __('Right to Left', 'widgetkits'),
                'right'        => __('Left to Right', 'widgetkits'),
            ],
            'condition'     => [
                'widgetkits_button_hover_effect' => 'style1',
            ],
            'label_block'   => true,
            ]
        );
		$this->add_control('widgetkits_button_style2_dir', 
        [
            'label'         => __('Shutter Direction', 'widgetkits'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'shutouthor',
            'options'       => [
                'shutinhor'     => __('Shutter in Horizontal', 'widgetkits'),
                'shutinver'     => __('Shutter in Vertical', 'widgetkits'),
                'shutoutver'    => __('Shutter out Horizontal', 'widgetkits'),
                'shutouthor'    => __('Shutter out Vertical', 'widgetkits'),
                'scshutoutver'  => __('Scaled Shutter Vertical', 'widgetkits'),
                'scshutouthor'  => __('Scaled Shutter Horizontal', 'widgetkits'),
                'dshutinver'   => __('Tilted Left'),
                'dshutinhor'   => __('Tilted Right'),
            ],
            'condition'     => [
                'widgetkits_button_hover_effect' => 'style2',
            ],
            'label_block'   => true,
            ]
        );
		$this->end_controls_tabs();
		$this->end_controls_tab();
		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		//Button Text And Style
		$button_text = $settings['button_text'];
		$button_size = 'widgetkits-button-' . $settings['widgetkits_button_size'];
		$button_hover = $settings['widgetkits_button_hover_effect'];

		//Button Hover Effect
		if ($button_hover == 'none') {
			$button_hover_style = 'widgetkits-button-none';
		}elseif($button_hover == 'style1'){
			$button_hover_style = 'widgetkits-button-style1-' . $settings['widgetkits_button_style1_dir'];
		}elseif ($button_hover == 'style2') {
			$button_hover_style = 'widgetkits-button-style2-' . $settings['widgetkits_button_style2_dir'];
		}elseif ($button_hover == 'style3') {
			$button_hover_style = 'widgetkits-button-style3-' . $settings['widgetkits_button_style3_dir'];
		}

		//Butoon ID
		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'widgetkits_button', 'id', $settings['button_css_id'] );
		}

        if( $settings['widgetkits_button_link_selection'] == 'url' ){
            $button_url = $settings['widgetkits_button_link']['url'];
        } else {
            $button_url = get_permalink( $settings['widgetkits_button_existing_link'] );
        }
		//Button Class Href
		$this->add_render_attribute( 'widgetkits_button', [
			'class'	=> ['widgetkits-button', esc_attr($button_size), esc_attr($button_hover_style) ],
			'href'	=> esc_attr($button_url),
		]);

        
		if( $settings['widgetkits_button_link']['is_external'] ) {
			$this->add_render_attribute( 'widgetkits_button', 'target', '_blank' );
		}
		if( $settings['widgetkits_button_link']['nofollow'] ) {
			$this->add_render_attribute( 'widgetkits_button', 'rel', 'nofollow');
		}

		$this->add_render_attribute( 'widgetkits_button', 'data-text', esc_attr($settings['button_text'] ));

		?>
		<div  class="sb_wraper">
			<a  <?php echo $this->get_render_attribute_string( 'widgetkits_button' ); ?>>

			 	<?php if ( $settings['widgetkits_button_icon_position'] == 'before' && !empty($settings['widgetkits_button_icon']['value']) ) : ?>
					<span class="widgetkits-btn-cion icon-before"><?php Icons_Manager::render_icon($settings['widgetkits_button_icon'], ['aria-hidden' => 'true']) ?></span>
                <?php endif; ?>

				<span><?php echo esc_html($button_text) ?></span>

				<?php if ( $settings['widgetkits_button_icon_position'] === 'after' && !empty($settings['widgetkits_button_icon']['value'])) : ?>
                    <span class="widgetkits-btn-cion icon-after"><?php Icons_Manager::render_icon($settings['widgetkits_button_icon'], ['aria-hidden' => 'true']) ?></span>
                <?php endif; ?>
			</a>
		</div>
		<?php
	}
}
$widgets_manager->register_widget_type( new \Widgetkits\Widgets\Elementor\Widgetkits_Button() );