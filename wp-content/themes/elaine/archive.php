<?php
$edgtf_blog_type = elaine_edge_get_archive_blog_list_layout();
elaine_edge_include_blog_helper_functions( 'lists', $edgtf_blog_type );
$edgtf_holder_params = elaine_edge_get_holder_params_blog();

get_header();
elaine_edge_get_title();
do_action('elaine_edge_action_before_main_content');
?>

<div class="<?php echo esc_attr( $edgtf_holder_params['holder'] ); ?>">
	<?php do_action( 'elaine_edge_action_after_container_open' ); ?>
	
	<div class="<?php echo esc_attr( $edgtf_holder_params['inner'] ); ?>">
		<?php elaine_edge_get_blog( $edgtf_blog_type ); ?>
	</div>
	
	<?php do_action( 'elaine_edge_action_before_container_close' ); ?>
</div>

<?php do_action( 'elaine_edge_action_blog_list_additional_tags' ); ?>
<?php get_footer(); ?>