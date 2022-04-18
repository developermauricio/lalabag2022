<?php

if ( ! function_exists( 'elaine_edge_register_search_post_type_widget' ) ) {
	/**
	 * Function that register search opener widget
	 */
	function elaine_edge_register_search_post_type_widget( $widgets ) {
		$widgets[] = 'ElaineEdgeClassSearchPostType';
		
		return $widgets;
	}
	
	add_filter( 'elaine_edge_filter_register_widgets', 'elaine_edge_register_search_post_type_widget' );
}

if ( ! function_exists( 'elaine_edge_search_post_types' ) ) {
	function elaine_edge_search_post_types() {
		
		if ( empty( $_POST ) || ! isset( $_POST ) ) {
			elaine_edge_ajax_status( 'error', esc_html__( 'All fields are empty', 'elaine' ) );
		} else {
			check_ajax_referer( 'edgtf_search_post_types_nonce', 'search_post_types_nonce' );

			$args = array(
				'post_type'      => sanitize_text_field($_POST['postType']),
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'orderby'        => 'date',
				's'              => sanitize_text_field($_POST['term']),
				'posts_per_page' => 5
			);
			
			$html  = '';
			$query = new WP_Query( $args );
			
			if ( $query->have_posts() ) {
				$html .= '<ul>';
					while ( $query->have_posts() ) {
						$query->the_post();
						$html .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
					}
				$html              .= '</ul>';
				$json_data['html'] = $html;
				elaine_edge_ajax_status( 'success', '', $json_data );
			} else {
				$html              .= '<ul>';
					$html              .= '<li>' . esc_html__( 'No posts found.', 'elaine' ) . '</li>';
				$html              .= '</ul>';
				$json_data['html'] = $html;
				elaine_edge_ajax_status( 'success', '', $json_data );
			}
		}
		
		wp_die();
	}
	
	add_action( 'wp_ajax_elaine_edge_search_post_types', 'elaine_edge_search_post_types' );
    add_action( 'wp_ajax_nopriv_elaine_edge_search_post_types', 'elaine_edge_search_post_types' );
}