<?php

if ( ! function_exists( 'elaine_edge_register_blog_standard_template_file' ) ) {
	/**
	 * Function that register blog standard template
	 */
	function elaine_edge_register_blog_standard_template_file( $templates ) {
		$templates['blog-standard'] = esc_html__( 'Blog: Standard', 'elaine' );
		
		return $templates;
	}
	
	add_filter( 'elaine_edge_filter_register_blog_templates', 'elaine_edge_register_blog_standard_template_file' );
}

if ( ! function_exists( 'elaine_edge_set_blog_standard_type_global_option' ) ) {
	/**
	 * Function that set blog list type value for global blog option map
	 */
	function elaine_edge_set_blog_standard_type_global_option( $options ) {
		$options['standard'] = esc_html__( 'Blog: Standard', 'elaine' );
		
		return $options;
	}
	
	add_filter( 'elaine_edge_filter_blog_list_type_global_option', 'elaine_edge_set_blog_standard_type_global_option' );
}

if ( ! function_exists( 'elaine_edge_show_page_content_on_top_blog_standard' ) ) {

	function elaine_edge_show_page_content_on_top_blog_standard( ) {
		if(is_page_template('blog-standard')) {
			$page_id = elaine_edge_get_page_id();
			$post_object = get_post($page_id);
			$content = $post_object->post_content;
			echo do_shortcode($content);
		}
	}
	add_action( 'elaine_edge_action_before_main_content', 'elaine_edge_show_page_content_on_top_blog_standard' );
}
