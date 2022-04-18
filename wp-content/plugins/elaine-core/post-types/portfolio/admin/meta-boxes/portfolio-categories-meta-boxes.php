<?php

if ( ! function_exists( 'elaine_edge_portfolio_category_additional_fields' ) ) {
	function elaine_edge_portfolio_category_additional_fields() {
		
		$fields = elaine_edge_add_taxonomy_fields(
			array(
				'scope' => 'portfolio-category',
				'name'  => 'portfolio_category_options'
			)
		);
		
		elaine_edge_add_taxonomy_field(
			array(
				'name'   => 'edgtf_portfolio_category_image_meta',
				'type'   => 'image',
				'label'  => esc_html__( 'Category Image', 'elaine-core' ),
				'parent' => $fields
			)
		);
	}
	
	add_action( 'elaine_edge_action_custom_taxonomy_fields', 'elaine_edge_portfolio_category_additional_fields' );
}