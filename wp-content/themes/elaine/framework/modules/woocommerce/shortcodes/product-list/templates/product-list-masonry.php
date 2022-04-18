<div class="edgtf-pl-holder edgtf-grid-list edgtf-grid-masonry-list edgtf-disable-bottom-space <?php echo esc_attr( $holder_classes ) ?>">
	<div class="edgtf-pl-outer edgtf-outer-space edgtf-masonry-list-wrapper">
		<div class="edgtf-masonry-grid-sizer"></div>
		<div class="edgtf-masonry-grid-gutter"></div>
		<?php if ( $query_result->have_posts() ): while ( $query_result->have_posts() ) : $query_result->the_post();
			echo elaine_edge_get_woo_shortcode_module_template_part( 'templates/parts/' . $info_position, 'product-list', '', $params );
		endwhile;
		else:
			elaine_edge_get_module_template_part( 'templates/parts/no-posts', 'woocommerce', '', $params );
		endif;
		wp_reset_postdata();
		?>
	</div>
</div>