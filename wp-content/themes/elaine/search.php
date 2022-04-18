<?php
$edgtf_search_holder_params = elaine_edge_get_holder_params_search();
?>
<?php get_header(); ?>
<?php elaine_edge_get_title(); ?>
<?php do_action('elaine_edge_action_before_main_content'); ?>
	<div class="<?php echo esc_attr( $edgtf_search_holder_params['holder'] ); ?>">
		<?php do_action( 'elaine_edge_action_after_container_open' ); ?>
		<div class="<?php echo esc_attr( $edgtf_search_holder_params['inner'] ); ?>">
			<?php elaine_edge_get_search_page(); ?>
		</div>
		<?php do_action( 'elaine_edge_action_before_container_close' ); ?>
	</div>
<?php get_footer(); ?>