<?php if ( ! elaine_edge_post_has_read_more() && ! post_password_required() ) { ?>
	<div class="edgtf-post-read-more-button">
		<?php
			$button_params = array(
				'type'         => 'simple',
				'link'         => get_the_permalink(),
				'text'         => esc_html__( 'Learn More', 'elaine' ),
				'custom_class' => 'edgtf-blog-list-button'
			);
			
			echo elaine_edge_return_button_html( $button_params );
		?>
		<span class="edgtf-btn-icon"><?php echo elaine_edge_icon_collections()->renderIcon('arrow_carrot-right', 'font_elegant');?></span>
	</div>
<?php } ?>