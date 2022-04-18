<?php

class ElaineEdgeClassSeparatorWidget extends ElaineEdgeClassWidget {
	public function __construct() {
		parent::__construct(
			'edgtf_separator_widget',
			esc_html__( 'Elaine Separator Widget', 'elaine' ),
			array( 'description' => esc_html__( 'Add a separator element to your widget areas', 'elaine' ) )
		);
		
		$this->setParams();
	}
	
	protected function setParams() {
		$this->params = array(
			array(
				'type'    => 'dropdown',
				'name'    => 'type',
				'title'   => esc_html__( 'Type', 'elaine' ),
				'options' => array(
					'normal'     => esc_html__( 'Normal', 'elaine' ),
					'full-width' => esc_html__( 'Full Width', 'elaine' )
				)
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'position',
				'title'   => esc_html__( 'Position', 'elaine' ),
				'options' => array(
					'center' => esc_html__( 'Center', 'elaine' ),
					'left'   => esc_html__( 'Left', 'elaine' ),
					'right'  => esc_html__( 'Right', 'elaine' )
				)
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'border_style',
				'title'   => esc_html__( 'Style', 'elaine' ),
				'options' => array(
					'solid'  => esc_html__( 'Solid', 'elaine' ),
					'dashed' => esc_html__( 'Dashed', 'elaine' ),
					'dotted' => esc_html__( 'Dotted', 'elaine' )
				)
			),
			array(
				'type'  => 'colorpicker',
				'name'  => 'color',
				'title' => esc_html__( 'Color', 'elaine' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'width',
				'title' => esc_html__( 'Width (px or %)', 'elaine' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'thickness',
				'title' => esc_html__( 'Thickness (px)', 'elaine' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'top_margin',
				'title' => esc_html__( 'Top Margin (px or %)', 'elaine' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'bottom_margin',
				'title' => esc_html__( 'Bottom Margin (px or %)', 'elaine' )
			)
		);
	}
	
	public function widget( $args, $instance ) {
		if ( ! is_array( $instance ) ) {
			$instance = array();
		}
		
		//prepare variables
		$params = '';
		
		//is instance empty?
		if ( is_array( $instance ) && count( $instance ) ) {
			//generate shortcode params
			foreach ( $instance as $key => $value ) {
				$params .= " $key='$value' ";
			}
		}
		
		echo '<div class="widget edgtf-separator-widget">';
			echo do_shortcode( "[edgtf_separator $params]" ); // XSS OK
		echo '</div>';
	}
}