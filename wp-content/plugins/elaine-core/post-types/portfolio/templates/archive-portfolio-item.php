<?php
get_header();
elaine_edge_get_title();
do_action( 'elaine_edge_action_before_main_content' ); ?>
<div class="edgtf-container edgtf-default-page-template">
	<?php do_action( 'elaine_edge_action_after_container_open' ); ?>
	<div class="edgtf-container-inner clearfix">
		<?php
			$elaine_taxonomy_id   = get_queried_object_id();
			$elaine_taxonomy_type = is_tax( 'portfolio-tag' ) ? 'portfolio-tag' : 'portfolio-category';
			$elaine_taxonomy      = ! empty( $elaine_taxonomy_id ) ? get_term_by( 'id', $elaine_taxonomy_id, $elaine_taxonomy_type ) : '';
			$elaine_taxonomy_slug = ! empty( $elaine_taxonomy ) ? $elaine_taxonomy->slug : '';
			$elaine_taxonomy_name = ! empty( $elaine_taxonomy ) ? $elaine_taxonomy->taxonomy : '';
			
			elaine_core_get_archive_portfolio_list( $elaine_taxonomy_slug, $elaine_taxonomy_name );
		?>
	</div>
	<?php do_action( 'elaine_edge_action_before_container_close' ); ?>
</div>
<?php get_footer(); ?>
