<div class="edgtf-slide-from-header-bottom-holder">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<div class="edgtf-form-holder">
			<input type="text" placeholder="<?php esc_attr_e( 'Search', 'elaine' ); ?>" name="s" class="edgtf-search-field" autocomplete="off" />
			<button type="submit" <?php elaine_edge_class_attribute( $search_submit_icon_class ); ?>>
				<?php echo elaine_edge_get_icon_sources_html( 'search', false, array( 'search' => 'yes' ) ); ?>
			</button>
		</div>
	</form>
</div>