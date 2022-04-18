<?php

class ElaineEdgeClassButtonWidget extends ElaineEdgeClassWidget {
	public function __construct() {
		parent::__construct(
			'edgtf_button_widget',
			esc_html__( 'Elaine Button Widget', 'elaine' ),
			array( 'description' => esc_html__( 'Add button element to widget areas', 'elaine' ) )
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
					'solid'   => esc_html__( 'Solid', 'elaine' ),
					'outline' => esc_html__( 'Outline', 'elaine' ),
					'simple'  => esc_html__( 'Simple', 'elaine' )
				)
			),
			array(
				'type'        => 'dropdown',
				'name'        => 'size',
				'title'       => esc_html__( 'Size', 'elaine' ),
				'options'     => array(
					'small'  => esc_html__( 'Small', 'elaine' ),
					'medium' => esc_html__( 'Medium', 'elaine' ),
					'large'  => esc_html__( 'Large', 'elaine' ),
					'huge'   => esc_html__( 'Huge', 'elaine' )
				),
				'description' => esc_html__( 'This option is only available for solid and outline button type', 'elaine' )
			),
			array(
				'type'    => 'textfield',
				'name'    => 'text',
				'title'   => esc_html__( 'Text', 'elaine' ),
				'default' => esc_html__( 'Button Text', 'elaine' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'link',
				'title' => esc_html__( 'Link', 'elaine' )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'target',
				'title'   => esc_html__( 'Link Target', 'elaine' ),
				'options' => elaine_edge_get_link_target_array()
			),
			array(
				'type'  => 'colorpicker',
				'name'  => 'color',
				'title' => esc_html__( 'Color', 'elaine' )
			),
			array(
				'type'  => 'colorpicker',
				'name'  => 'hover_color',
				'title' => esc_html__( 'Hover Color', 'elaine' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'background_color',
				'title'       => esc_html__( 'Background Color', 'elaine' ),
				'description' => esc_html__( 'This option is only available for solid button type', 'elaine' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'hover_background_color',
				'title'       => esc_html__( 'Hover Background Color', 'elaine' ),
				'description' => esc_html__( 'This option is only available for solid button type', 'elaine' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'border_color',
				'title'       => esc_html__( 'Border Color', 'elaine' ),
				'description' => esc_html__( 'This option is only available for solid and outline button type', 'elaine' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'hover_border_color',
				'title'       => esc_html__( 'Hover Border Color', 'elaine' ),
				'description' => esc_html__( 'This option is only available for solid and outline button type', 'elaine' )
			),
			array(
				'type'        => 'textfield',
				'name'        => 'margin',
				'title'       => esc_html__( 'Margin', 'elaine' ),
				'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'elaine' )
			)
		);
	}
	
	public function widget( $args, $instance ) {
		$params = '';
		
		if ( ! is_array( $instance ) ) {
			$instance = array();
		}
		
		// Filter out all empty params
		$instance = array_filter( $instance, function ( $array_value ) {
			return trim( $array_value ) != '';
		} );
		
		// Default values
		if ( ! isset( $instance['text'] ) ) {
			$instance['text'] = 'Button Text';
		}
		
		// Generate shortcode params
		foreach ( $instance as $key => $value ) {
			$params .= " $key='$value' ";
		}
		
		echo '<div class="widget edgtf-button-widget">';
			echo do_shortcode( "[edgtf_button $params]" ); // XSS OK
		echo '</div>';
	}
}