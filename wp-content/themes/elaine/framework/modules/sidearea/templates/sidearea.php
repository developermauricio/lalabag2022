<section class="edgtf-side-menu">
	<a <?php elaine_edge_class_attribute( $close_icon_classes ); ?> href="#">
		<?php echo elaine_edge_get_icon_sources_html( 'side_area', true ); ?>
	</a>
	<?php if ( is_active_sidebar( 'sidearea' ) ) {
		dynamic_sidebar( 'sidearea' );
	} ?>
</section>